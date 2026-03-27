#!/usr/bin/env bash
# Installs the WordPress test suite and creates a test database.
# Usage: bash bin/install-wp-tests.sh <db-name> <db-user> <db-pass> [db-host] [wp-version] [skip-db-create]
#
# Source: wp-cli/scaffold-command (MIT)
# Copy to bin/install-wp-tests.sh in each plugin repo.

set -euo pipefail

DB_NAME=${1:-wordpress_test}
DB_USER=${2:-root}
DB_PASS=${3:-root}
DB_HOST=${4:-localhost}
WP_VERSION=${5:-latest}
SKIP_DB_CREATE=${6:-false}

TMPDIR=${TMPDIR:-/tmp}
WP_TESTS_DIR=${WP_TESTS_DIR:-$TMPDIR/wordpress-tests-lib}
WP_CORE_DIR=${WP_CORE_DIR:-$TMPDIR/wordpress}

download() {
    if command -v curl >/dev/null 2>&1; then
        curl -s "$1" > "$2"
    elif command -v wget >/dev/null 2>&1; then
        wget -nv -O "$2" "$1"
    fi
}

if [[ "$WP_VERSION" == "nightly" || "$WP_VERSION" == "trunk" ]]; then
    WP_TESTS_TAG="trunk"
elif [[ "$WP_VERSION" == "latest" ]]; then
    local_version=$(download "https://api.wordpress.org/core/version-check/1.7/" - | grep '"version"' | sed 's/.*: *"\([^"]*\)".*/\1/' | head -1)
    WP_TESTS_TAG="tags/${local_version}"
else
    WP_TESTS_TAG="tags/${WP_VERSION}"
fi

echo "Using WP tests tag: $WP_TESTS_TAG"

install_wp() {
    if [[ -d "$WP_CORE_DIR/wp-includes" ]]; then return; fi
    mkdir -p "$WP_CORE_DIR"
    if [[ "$WP_VERSION" == "nightly" || "$WP_VERSION" == "trunk" ]]; then
        mkdir -p "$TMPDIR/wordpress-nightly"
        download "https://wordpress.org/nightly-builds/wordpress-latest.zip" "$TMPDIR/wordpress-nightly/wordpress-nightly.zip"
        unzip -q "$TMPDIR/wordpress-nightly/wordpress-nightly.zip" -d "$TMPDIR/wordpress-nightly/"
        mv "$TMPDIR/wordpress-nightly/wordpress/"* "$WP_CORE_DIR/"
    else
        if [[ "$WP_VERSION" == "latest" ]]; then
            local_version=$(download "https://api.wordpress.org/core/version-check/1.7/" - | grep '"version"' | sed 's/.*: *"\([^"]*\)".*/\1/' | head -1)
            archive="https://wordpress.org/wordpress-${local_version}.tar.gz"
        else
            archive="https://wordpress.org/wordpress-${WP_VERSION}.tar.gz"
        fi
        download "$archive" "$TMPDIR/wordpress.tar.gz"
        tar --strip-components=1 -zxmf "$TMPDIR/wordpress.tar.gz" -C "$WP_CORE_DIR"
    fi
}

install_test_suite() {
    if [[ -d "$WP_TESTS_DIR/includes" ]]; then return; fi
    mkdir -p "$WP_TESTS_DIR"
    svn co --quiet --ignore-externals \
        "https://develop.svn.wordpress.org/${WP_TESTS_TAG}/tests/phpunit/includes/" \
        "$WP_TESTS_DIR/includes"
    svn co --quiet --ignore-externals \
        "https://develop.svn.wordpress.org/${WP_TESTS_TAG}/tests/phpunit/data/" \
        "$WP_TESTS_DIR/data"
    download "https://develop.svn.wordpress.org/${WP_TESTS_TAG}/wp-tests-config-sample.php" "$WP_TESTS_DIR/wp-tests-config.php"
    sed -i "s:dirname( __FILE__ ) . '/src/':'$WP_CORE_DIR/':" "$WP_TESTS_DIR/wp-tests-config.php"
    sed -i "s/youremptytestdbnamehere/$DB_NAME/" "$WP_TESTS_DIR/wp-tests-config.php"
    sed -i "s/yourusernamehere/$DB_USER/"         "$WP_TESTS_DIR/wp-tests-config.php"
    sed -i "s/yourpasswordhere/$DB_PASS/"         "$WP_TESTS_DIR/wp-tests-config.php"
    sed -i "s|localhost|$DB_HOST|"                "$WP_TESTS_DIR/wp-tests-config.php"
}

create_db() {
    if [[ "$SKIP_DB_CREATE" == "true" ]]; then return; fi
    mysqladmin create "$DB_NAME" --user="$DB_USER" --password="$DB_PASS" \
        --host="${DB_HOST%%:*}" --port="${DB_HOST##*:}" 2>/dev/null || true
}

install_wp
install_test_suite
create_db

echo "WordPress test suite installed."

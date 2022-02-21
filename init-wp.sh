#!/bin/sh

set -e

# Initialize wordpress
# NOTE: This script should run after starting wpcli docker container

# Variables
SITE_URL="http://localhost:8080"
SITE_NAME="Sample"
USER_NAME="admin"
USER_PASS="pass"
USER_EMAIL="info@example.com"
PLUGIN_NAME="albamn-hskwakr"

# Check a given value is an available or not
# For more details:
#   help type
has() {
  type "$1" >/dev/null 2>&1
}

# Requirements
if ! has "docker-compose"; then
  echo "docker-compose required"
  exit 1
fi

if ! has "grep"; then
  echo "grep required"
  exit 1
fi

# Check a given value is in docker ps
docker_ps() {
  docker-compose ps --services | grep "$1"
}

# This script should run after starting wpcli docker container
if ! docker_ps "wpcli"; then
  echo "Don't forget 'docker-compose up -d' or please try again in few minutes"
  exit 1
fi

# Initialize wordpress
docker-compose run wpcli wp core install \
  --url="${SITE_URL}" \
  --title="${SITE_NAME}" \
  --admin_user="${USER_NAME}" \
  --admin_password="${USER_PASS}" \
  --admin_email="${USER_EMAIL}"

# Activate plugin
docker-compose run wpcli wp plugin activate "${PLUGIN_NAME}"

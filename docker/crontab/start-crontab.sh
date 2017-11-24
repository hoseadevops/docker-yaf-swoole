#!/bin/bash
env > /tmp/crontab.env
docker_path=$(pwd -P)
echo "*/5 * * * * set -a; . /tmp/crontab.env; set +a; env > /tmp/env.output; /usr/local/bin/php -v >> /var/log/crontab/crontab.log 2>> /var/log/crontab/crontab.error" > docker/crontab/crontab
chmod +x docker/crontab/crontab
crontab docker/crontab/crontab
cron -f &

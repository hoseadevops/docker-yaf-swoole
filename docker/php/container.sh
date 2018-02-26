#!/bin/bash
set -e


function run_php()
{
    local args='--restart=always'

    #todo websocket test
    args="$args -p 10841:8084"
    args="$args -p 10851:8085"

    args="$args --cap-add SYS_PTRACE"

    args="$args -v $project_docker_runtime_dir/php:/var/log/php"

    args="$args -v $project_docker_runtime_dir/crontab:/var/log/crontab"

    if [ "$app_env" = 'production' ]; then
        args="$args -v $project_docker_php_dir/conf/php-prod.ini:/usr/local/etc/php/php.ini"
    else
        args="$args -v $project_docker_php_dir/conf/php-dev.ini:/usr/local/etc/php/php.ini"
    fi
    args="$args -v $project_docker_php_dir/conf/php-fpm.conf:/usr/local/etc/php-fpm.conf"

    args="$args -v $project_path:$project_path"
    args="$args -w $project_path"

    args="$args --volumes-from $busybox_container"
    args="$args --link $redis_container"

    local cmd='bash docker.sh _run_cmd_php_container'
    run_cmd "docker run -d $args -h $php_container --name $php_container $php_image $cmd"
}

function rm_php()
{
    rm_container $php_container
}

function to_php()
{
    local cmd='bash'
    _send_cmd_to_php_container "cd $project_path; $cmd"
}

#todo websocket test
function run_web_socket()
{
    local cmd='php websocket/chat-service.php'
    _send_cmd_to_php_container "cd $project_path; $cmd";
}

function _send_cmd_to_php_container()
{
    local cmd=$1
    run_cmd "docker exec -it $php_container bash -c '$cmd'"
}

function _run_cmd_php_container()
{
    run_cmd '/usr/sbin/rsyslogd'
    run_cmd 'bash docker/crontab/start-crontab.sh'
    if [ -f /var/log/php/php-fpm-error.log ]; then
        run_cmd 'touch /var/log/php/php-fpm-error.log'
    fi
    if [ -f /var/log/php/php-fpm-slow ]; then
        run_cmd 'touch /var/log/php/php-fpm-slow.log'
    fi
    run_cmd 'chmod -R a+r /var/log/php/'
    run_cmd '/usr/local/sbin/php-fpm -R'
}
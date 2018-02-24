<?php
/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 2018/2/23
 * Time: 下午6:24
 */


$service         = new swoole_websocket_server("0.0.0.0", 8085);

$redis           = new Redis();

$redis->connect('hexing-yaf-swoole-redis3.0.1', 6379);

//$redis->flushAll();exit;

$service->on('open', function (swoole_websocket_server $service, $request){
    global $redis;
    echo "server: client open success with fd{$request->fd}\n";
    $redis->sAdd('fd', $request->fd);
});

//监听WebSocket消息事件
$service->on('message', function (swoole_websocket_server $service, $frame){
    global $redis;

    $fds = $redis->sMembers('fd');

    $data = 'from' . $frame->fd . ":{$frame->data}\n";

    foreach ($fds as $fd){
        $service->push($fd, $data);
    }
});

//监听WebSocket连接关闭事件
$service->on('close', function ($service, $fd){
    echo "client {$fd} closed\n";
    global $redis;
    $redis->sRem('fd',$fd);
});

$service->start();
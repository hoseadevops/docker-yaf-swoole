<?php
/**
 * Created by PhpStorm.
 * User: hexing
 * Date: 2018/2/23
 * Time: 下午6:07
 */

## 设置路径
define('_ROOT_', dirname(__FILE__));

##  监听地址和端口
$server = new swoole_websocket_server("0.0.0.0", 8888);

## 服务端接收连接事件
$server->on('open', function (swoole_websocket_server $server, $request) {
    if(!file_exists(_ROOT_.'/client/'.$request->fd.'.client')){
        @file_put_contents(_ROOT_.'/client/'.$request->fd.'.client',$request->fd);
    }
});

## 服务端接收信息事件
$server->on('message', function (swoole_websocket_server $server, $frame) {
    foreach(notice(_ROOT_.'/client/') as $v){
        $server->push($v,$frame->data);
    }
});

## 服务端接收关闭事件
$server->on('close', function ($ser, $fd) {
    @unlink(_ROOT_.'/client/'.$fd.'.client');
});

## 服务开启
$server->start();


/**
 * 统计在线人数
 *
 * @param $dir
 * @return int
 */
function clearDir($dir)
{
    $n = 0;
    if ($dh = opendir($dir))
    {
        while (($file = readdir($dh)) !== false)
        {
            if ($file == '.' or $file == '..')
            {
                continue;
            }
            if (is_file($dir . $file)) {
                $n++;
            }
        }
    }
    closedir($dh);
    return $n;
}

/**
 * 通知在线的人
 *
 * @param $dir
 * @return array
 */
function notice($dir)
{
    $array = [];
    if ($dh = opendir($dir))
    {
        while (($file = readdir($dh)) !== false)
        {
            if ($file == '.' or $file == '..')
            {
                continue;
            }
            if (is_file($dir . $file)) {
                $array[]=file_get_contents($dir.$file);
            }
        }
    }
    closedir($dh);
    return $array;
}
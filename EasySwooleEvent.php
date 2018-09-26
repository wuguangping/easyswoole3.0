<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/5/28
 * Time: 下午6:33
 */

namespace EasySwoole\Frame;


use App\Process\Inotify;
use App\Process\Test;
use App\Utility\Pools\MysqlPool;
use App\Utility\Pools\RedisPool;
use EasySwoole\Component\Di;
use EasySwoole\Core\EventRegister;
use EasySwoole\Core\Process\ProcessManager;
use EasySwoole\Core\Time\Timer;
use EasySwoole\Frame\AbstractInterface\Event;
use EasySwoole\Http\Request;
use EasySwoole\Http\Response;
use EasySwoole\Trigger\Logger;

class EasySwooleEvent implements Event
{

    public static function initialize()
    {
        // TODO: Implement initialize() method.
        date_default_timezone_set("Asia/Shanghai");
        // 引入simple_dom_html.php文件
        require_once EASYSWOOLE_ROOT."/App/Utility/simple_dom_html.php";
    }

    public static function mainServerCreate(EventRegister $register)
    {
        // TODO: Implement mainServerCreate() method.
        $register->add(EventRegister::onWorkerStart, function (\swoole_server $server, $workerId) {
            if ($workerId === 0) {
//                $count = 0;
//                $timer = Timer::loop(10 * 1000, function () use(&$timer, &$count) {
//                    if ($count == 10) {
//                        unset($count);
//                        Timer::clear($timer);
//                    } else {
//                        echo 'test'.PHP_EOL;
//                        $count = $count + 1;
//                        echo 'count'.$count.PHP_EOL;
//                    }
//                });
                // 定时任务
                Timer::loop(1 * 1000, function () {
                    $time = date('H:i:s');
                    if ($time === '17:26:00') {
                        echo '17:00'.PHP_EOL;
                    }
                });

                // 启动定时器
//                Timer::loop(10000, function() {
//                    Logger::getInstance()->console('timer run');  # 写日志到控制台
//                    ProcessManager::getInstance()->writeByProcessName('test', time());  # 向自定义进程发消息
//                });
            }
        });
        // webSocket绑定监听事件
//        $register->add('open', function(\swoole_websocket_server $server, $request) {
//            echo "server: handshake success with fd{$request->fd}".PHP_EOL;
//        });
//        $register->add('message', function(\swoole_websocket_server $server, $frame) {
//            echo "received message: {$frame->data}\n";
//            $parse = new Parse();
//            $parse->handler($frame);
//        });
//        $register->add('close', function($ser, $fd) {
//            echo "client {$fd} closed\n";
//        });

        // 创建自定义进程
        // ProcessManager::getInstance()->addProcess('test', Test::class);

        // 开启热重启进程
        ProcessManager::getInstance()->addProcess('autoReload', Inotify::class);

        // 注入redis池和mysql池
        Di::getInstance()->set('REDISPOOL', new RedisPool);
        Di::getInstance()->set('MYSQLPOOL', new MysqlPool);
    }

    public static function onRequest(Request $request, Response $response): bool
    {
        // TODO: Implement onRequest() method.
        return true;
    }

    public static function afterRequest(Request $request, Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}
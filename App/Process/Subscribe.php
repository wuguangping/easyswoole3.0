<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18-9-26
 * Time: 下午4:41
 */

namespace App\Process;


use EasySwoole\Component\Di;
use EasySwoole\Core\Process\AbstractProcess;
use Swoole\Process;

class Subscribe extends AbstractProcess
{

    public function run(Process $process)
    {
        // TODO: Implement run() method.
        $redis = Di::getInstance()->get('REDISPOOL')->getObj();
        $redis->subscribe(['ch1'], function () {
            print_r(func_get_args());
        });
    }

    public function onShutDown()
    {
        // TODO: Implement onShutDown() method.
    }

    public function onReceive(string $str)
    {
        // TODO: Implement onReceive() method.
    }
}
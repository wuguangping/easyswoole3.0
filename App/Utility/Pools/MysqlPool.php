<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18-9-25
 * Time: 下午4:37
 */

namespace App\Utility\Pools;


use EasySwoole\Component\Pool\AbstractPool;
use EasySwoole\Frame\Config;

class MysqlPool extends AbstractPool
{

    protected function createObject(): bool
    {
        // TODO: Implement createObject() method.
        $conf = Config::getInstance()->getConf('MYSQL');
        $mysql = new MysqlPoolObject($conf);
        return $this->recycleObj($mysql);
    }
}
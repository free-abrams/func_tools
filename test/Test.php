<?php

namespace FreeAbrams\Test;
use Monolog\Handler\StreamHandler;
use Monolog\Test\TestCase;
use Monolog\Logger;
/**
 * Created By FreeAbrams
 * Date: 2022/3/10
 */
require __DIR__.'/../vendor/autoload.php';
define('ROOT_PATH', __DIR__);

class Test extends TestCase
{
  public function testPushAndPop()
  {
    $stack = [];
    $this->assertEquals(0, count($stack));
    array_push($stack, 'foo');
    // 添加日志文件,如果没有安装monolog，则有关monolog的代码都可以注释掉
    $this->Log()->error('hello', $stack);
    $this->assertEquals('foo', $stack[count($stack)-1]);
    $this->assertEquals(1, count($stack));
    $this->assertEquals('foo', array_pop($stack));
    $this->assertEquals(0, count($stack));
  }
  
  public function Log()
  {
    // create a log channel
    $log = new Logger('Tester');
    $log->pushHandler(new StreamHandler(ROOT_PATH . '/storage/logs/app.log', Logger::WARNING));
    $log->error("Error");
    return $log;
  }
}
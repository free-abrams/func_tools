<?php
namespace FreeAbrams\Test;

use FreeAbrams\FuncTools\Handlers\Str;
use PHPUnit\Framework\TestCase;

/**
 * Created By FreeAbrams
 * Date: 2022/7/20
 */
class StrTest extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
	public function testStartWith()
	{
		$search = 'Illuminate';
		$subject = 'Illuminate\Support\Facades\Facade';
		Str::startWith($search, $subject);
	}
	
    /**
     * @doesNotPerformAssertions
     */
	public function testEndWith()
	{
		$search = 'Facade';
		$subject = 'Illuminate\Support\Facades\Facade';
		Str::endWith($search, $subject);
	}
	
    /**
     * @doesNotPerformAssertions
     */
	public function testReplacement()
	{
		$search = 'Facade';
		$subject = 'Illuminate\Support\Facades\Facade';
		Str::replace($search, 'Fd', $subject, 1);
	}
    /**
     * @doesNotPerformAssertions
     */
	public function testSearch()
	{
		$search = 'Facade';
		$subject = 'Illuminate\Support\Facades\Facade';
		Str::search($search, $subject);
	}
	
	public function testAfter()
	{
		$subject = 'This is my name';
		$sting = 'my';
		$this->assertEquals(' name', Str::after($subject, $sting));
	}
	
	public function testAfterLast()
	{
		$subject = 'App\Http\Controllers\Controller';
		$sting = '\\\\';
		$this->assertEquals('Controller', Str::afterLast($subject, $sting));
	}
	
	public function testBefore()
	{
		$subject = 'This is my name';
		$sting = 'my';
		$this->assertEquals('This is ', Str::before($subject, $sting));
	}
	
	public function testBeforeLast()
	{
		$subject = 'App\Http\Controllers\Controller';
		$sting = '\\\\';
		$this->assertEquals('App\Http\Controllers', Str::beforeLast($subject, $sting));
	}
	
	public function testBetween()
	{
		$subject = 'App\Http\Controllers\Controller';
		$before = 'App';
		$after = 'Controller';
		$this->assertEquals('\Http\Controllers\\', Str::between($subject, $before, $after));
	}
	
	public function testContains()
	{
		$subject = 'App\Http\Controllers\Controller';
		$this->assertEquals(true, Str::contains($subject, 'App'));
		$this->assertEquals(false, Str::contains($subject, 'Apps'));
	}
	
	public function testContainsAll()
	{
		$subject = 'App\Http\Controllers\Controller';
		$this->assertEquals(true, Str::containsAll($subject, 'App'));
		$this->assertEquals(true, Str::containsAll($subject, ['App', 'Http']));
		$this->assertEquals(false, Str::containsAll($subject, ['Apps', 'Controller']));
	}
	
	public function testDirname()
	{
		$subject = 'App\Http\Controllers\Controller';
		$this->assertEquals('App\Http', Str::dirname($subject, 2));
		$this->assertEquals('App\Http\Controllers', Str::dirname($subject, 1));
	}
	
	public function testIsAscii()
	{
		$this->assertEquals(true, Str::isAscii('abc'));
		$this->assertEquals(false, Str::isAscii('窝'));
	}
}
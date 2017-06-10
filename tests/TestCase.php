<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Debug\ExceptionHandler;
use App\Exceptions\Handler;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp()
    {
    	parent::setUp();
    	$this->disableExceptionHandling();
    }

   	public function signIn($user = null)
   	{
   		$user = $user ?: create('App\User');

   		$this->actingAs($user);

   		return $this;
   	}

   	public function disableExceptionHandling()
   	{
   		$this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

   		$this->app->instance(ExceptionHandler::class, new TestHandler); 
   	}

   	public function withEceptionHandling()
   	{
   		$this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

   		return $this;
   	}
}

class TestHandler extends Handler
{
	public function __construct()
    {
    }
    public function report(\Exception $e)
    {
    }
    public function render($request, \Exception $e)
    {
        throw $e;
    }
}


	

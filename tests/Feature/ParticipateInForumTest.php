<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
	use DatabaseMigrations;

   
	// public function test_a_unauthenticated_users_may_not_add_replies()
	// {
	// 	// $this->expectException('Illuminate\Auth\AuthenticationException');
 //        $user = factory('App\User')->create();

 //        $thread = factory('App\Thread')->make();
 //        $reply = factory('App\Reply')->make();

 //        $this->post($thread->path().'/replies', $reply->toArray());
 //    	// $this->post('threads/1/replies', []);

	// }

    public function test_a_authenticated_user_may_participate_in_forum_threads()
    {

    	//make user auth
    	$this->be($user = create('App\User'));

    	//add existing thread
    	$thread = create('App\Thread');

    	//When user add a reply to the thread
    	//simulate post request for sepcific route
    	$reply = make('App\Reply');
    	$this->post($thread->path().'/replies', $reply->toArray());

    	//checking if replies is visibile on the page

    	$this->get($thread->path())->assertSee($reply->body);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadTest extends TestCase
{
	use DatabaseMigrations;

	
    public function test_guest_cant_create_a_thread()
    {

       $this->withExceptionHandling();

       $this->get('/threads/create')
       ->assertRedirect('/login');

       $this->post('/threads')
       ->assertRedirect('/login');

    }


    /** @test **/
    public function test_an_authenticated_user_can_create_a_thread()
    {
    	$this->signIn();

    	// raw method gave array attributes
    	$thread = make('App\Thread');

    	//we have to pass array
    	$response = $this->post('/threads', $thread->toArray());

    	//go to thread page
        //get Location will return id of thread
    	$this->get($response->headers->get('Location'))
    	->assertSee($thread->title)
    	->assertSee($thread->body);
    }

    public function test_guests_cannot_see_the_create_thread_page()
    {
        $this->withExceptionHandling()->get('threads/create')->assertRedirect('/login');
    }

    public function test_a_thread_requires_a_title()
    {
        $this->publishAThread(['title' => null])
        ->assertSessionHasErrors('title');
    }

    public function test_a_thread_requires_a_body()
    {
        $this->publishAThread(['body' => null])
        ->assertSessionHasErrors('body');
    }

    public function test_a_thread_requires_a_valid_channel()
    {

        factory('App\Channel', 2)->create();

        $this->publishAThread(['channel_id' => null])
        ->assertSessionHasErrors('channel_id');

        $this->publishAThread(['channel_id' => 999])
        ->assertSessionHasErrors('channel_id');
    }

    public function publishAThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }

}

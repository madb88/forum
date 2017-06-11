<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadTest extends TestCase
{
	use DatabaseMigrations;

	
    public function test_guest_cant_create_a_thread()
    {

       $this->withEceptionHandling();

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
    	$thread = create('App\Thread');

    	//we have to pass array
    	$this->post('/threads', $thread->toArray());

    	//go to thread page
    	$this->get($thread->path())
    	->assertSee($thread->title)
    	->assertSee($thread->body);
    }

    public function test_guests_cannot_see_the_create_thread_page()
    {
        $this->withEceptionHandling()->get('threads/create')->assertRedirect('/login');
    }


}

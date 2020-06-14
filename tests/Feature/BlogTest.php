<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
 use WithFaker, RefreshDatabase;

 /** @test */
 public function a_user_can_create_a_blog()
 {
  //不需要處理Exception
  //$this->withoutExceptionHandling();

  $this->actingAs(factory(\App\User::class)->create());
  $attributes = factory(\App\Blog::class)->raw();
  unset($attributes['owner_id']);
//進行POST請求
  $this->post('/blogs', $attributes)->assertRedirect('/blogs');
//驗證資料庫的blogs表格是否有此資料
  $this->assertDatabaseHas('blogs', $attributes);
  $this->get('/blogs')->assertSee($attributes['title']);

 }

 /** @test */
 public function a_blog_require_a_title()
 {
  $this->actingAs(factory(\App\User::class)->create());
  $attributes = factory(\App\Blog::class)->raw(['title' => '']);
  $this->post('/blogs', $attributes)->assertSessionHasErrors('title');

 }

/** @test */
 public function a_blog_require_a_description()
 {
$this->actingAs(factory(\App\User::class)->create());

  $attributes = factory(\App\Blog::class)->raw(['description' => '']);
  $this->post('/blogs', $attributes)->assertSessionHasErrors('description');


 }

//  /** @test */
//  public function a_blog_require_a_ownerId()
//  {
//   //$this->withoutExceptionHandling();
//   $this->actingAs(factory(\App\User::class)->create());

//   $attributes = factory(\App\Blog::class)->raw(['owner_id' => null]);
//   $this->post('/blogs', $attributes)->assertSessionHasErrors('owner_id');
//  }

 /** @test */
 public function a_user_can_view_a_blog()
 {
  //$this->withoutExceptionHandling();

  $blog = factory(\App\Blog::class)->create();
  $this->get($blog->path())
   ->assertSee($blog->title)
   ->assertSee($blog->description);
 }

 /** @test */
 public function only_authenticated_user_can_create_blog()
 {
  //$this->withoutExceptionHandling();
  $attributes = factory(\App\Blog::class)->raw();
  $this->post('/blogs', $attributes)->assertRedirect('login');
 }

}

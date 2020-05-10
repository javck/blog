<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class BlogTest extends TestCase
{
    use WithFaker,RefreshDatabase;
 /** @test */
 public function a_user_can_create_a_blog()
 {
  //不需要處理Exception
  $this->withoutExceptionHandling();

  $attributes = [
   'title'       => $this->faker->sentence,
   'description' => $this->faker->paragraph,
  ];
  //進行POST請求
  $this->post('/blogs', $attributes)->assertRedirect('/blogs');
  //驗證資料庫的blogs表格是否有此資料
  $this->assertDatabaseHas('blogs', $attributes);
  $this->get('/blogs')->assertSee($attributes['title']);

 }
}

<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Blog;

class BlogTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    /** @test */
    public function a_blog_has_path(){
        $blog = factory(Blog::class)->create();
        $this->assertEquals('/blogs/'.$blog->id , $blog->path());
    }
}

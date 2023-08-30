<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogTest extends TestCase
{
    /**
     * Test get all post .
     */
    public function testGetAllPosts()
    {
        $response = $this->get('/api/posts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'category_id',
                        'user_id',
                        'slug',
                        'title',
                        'content',
                        'scheduled_at',
                        'thumbnail',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    public function testGetSinglePost()
    {
        $post = factory(\App\Models\Post::class)->create();

        $response = $this->get('/api/posts/' . $post->id);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'user',
                    'category',
                    'slug',
                    'title',
                    'content',
                    'thumbnail',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
}

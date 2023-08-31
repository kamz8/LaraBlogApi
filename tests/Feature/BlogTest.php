<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory;

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
                        'category' => [
                            "id",
                            "name",
                        ],
                        'user'=> [
                            "id",
                            "name",
                        ],
                        'slug',
                        'title',
                        'content',
                        'thumbnail_url',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    public function testGetSinglePost()
    {
        $response = $this->get('/api/posts/1');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'category' => [
                        "id",
                        "name",
                    ],
                    'user'=> [
                        "id",
                        "name",
                    ],
                    'slug',
                    'title',
                    'content',
                    'thumbnail_url',
                    'created_at',
                    'updated_at',
                ]
            ]);
    }
}

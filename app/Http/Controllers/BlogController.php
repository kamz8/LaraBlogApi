<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private $blogService;
    public function __construct(BlogService $blogService)
    {
        $this->blogService = new BlogService();
    }

    /**
     * Display a listing of the resource for main blog endpoint.
     */
    public function index()
    {
        $posts = $this->blogService->getAllPosts();
        return PostResource::collection($posts);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $post = $this->blogService->getPostById($id);
        return new PostResource($post);
    }
    /*
     * Down below can add method for searching post etc.
     * */

}

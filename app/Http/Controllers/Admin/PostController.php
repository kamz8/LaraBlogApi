<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Services\BlogService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Include BlogService
     */
    private BlogService $blogService;
    public function __construct(BlogService $blogService)
    {
        $this->blogService = new BlogService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = $this->blogService->getPostById($id);
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Database\Eloquent\Casts\ArrayObject;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function PHPUnit\Framework\isNull;

class BlogService
{
    function getAllPosts() : Object {
        $user = auth()->user();
        $postQuery = Post::with(['user', 'category']);
        if (!is_null($user) && $user->hasRole(['user'])) {
            return $postQuery->where('scheduled_at', '<=', now())->paginate(config('blog.paginate.limit'));
        }

        return $postQuery->paginate(config('blog.paginate.limit'));

    }

    function getPostBySlug(string $slug) : object
    {
        return Post::with(['user', 'category'])->where('slug', $slug)->first();
    }

    function getPostById(string $id) : object
    {
        try {
            return Post::with(['user', 'category'])->findOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundHttpException('Post not found', $e);
        }
    }
}

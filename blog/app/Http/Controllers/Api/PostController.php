<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListPostsRequest;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Services\Posts\CreatePostService;
use App\Services\Posts\ListPostsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        private readonly CreatePostService $createPostService,
        private readonly ListPostsService $listPostsService,
    ) {
    }

    /** POST /api/posts — создание публикации. */
    public function create(PostRequest $request): JsonResponse
    {
        $post = $this->createPostService->create(
            $request->user(),
            $request->validated(),
        );

        return (new PostResource($post->load('author:id,name')))
            ->response()
            ->setStatusCode(201);
    }

    /** GET /api/posts — список публикаций (порционно, с фильтрами и сортировкой). */
    public function index(ListPostsRequest $request): AnonymousResourceCollection
    {
        $posts = $this->listPostsService->list($request->validated());

        return PostResource::collection($posts);
    }

    /** GET /api/my-posts — лента публикаций текущего пользователя. */
    public function myPosts(ListPostsRequest $request): AnonymousResourceCollection
    {
        $posts = $this->listPostsService->list(
            $request->validated(),
            $request->user(),
        );

        return PostResource::collection($posts);
    }
}
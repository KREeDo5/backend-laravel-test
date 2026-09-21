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

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     tags={"Posts"},
     *     summary="Создание публикации",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             required={"title", "text"},
     *             @OA\Property(property="title", type="string", maxLength=255, example="Новая публикация"),
     *             @OA\Property(property="text", type="string", example="Текст публикации"),
     *         ),
     *     ),
     *
     *     @OA\Response(response=201, description="Публикация создана",
     *         @OA\JsonContent(ref="#/components/schemas/PostResponse"),
     *     ),
     *     @OA\Response(response=401, description="Не авторизован (нет Bearer-токена)",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse"),
     *     ),
     *     @OA\Response(response=422, description="Ошибка валидации",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse"),
     *     ),
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/posts",
     *     tags={"Posts"},
     *     summary="Лента публикаций",
     *
     *     @OA\Parameter(name="limit", in="query", required=false,
     *         @OA\Schema(type="integer", minimum=1, maximum=20, example=10),
     *     ),
     *     @OA\Parameter(name="offset", in="query", required=false,
     *         @OA\Schema(type="integer", minimum=0, example=0),
     *     ),
     *     @OA\Parameter(name="sort", in="query", required=false,
     *         @OA\Schema(type="string", enum={"title_asc", "title_desc", "date_asc", "date_desc"}, example="date_desc"),
     *     ),
     *     @OA\Parameter(name="date_from", in="query", required=false,
     *         @OA\Schema(type="string", format="date", example="2026-01-01"),
     *     ),
     *     @OA\Parameter(name="date_to", in="query", required=false,
     *         @OA\Schema(type="string", format="date", example="2026-12-31"),
     *     ),
     *
     *     @OA\Response(response=200, description="Порция публикаций",
     *         @OA\JsonContent(ref="#/components/schemas/PostListResponse"),
     *     ),
     * )
     */
    public function index(ListPostsRequest $request): AnonymousResourceCollection
    {
        $posts = $this->listPostsService->list($request->validated());

        return PostResource::collection($posts);
    }

    /**
     * @OA\Get(
     *     path="/api/my-posts",
     *     tags={"Posts"},
     *     summary="Публикации текущего пользователя",
     *     security={{"bearerAuth": {}}},
     *
     *     @OA\Parameter(name="limit", in="query", required=false,
     *         @OA\Schema(type="integer", minimum=1, maximum=20, example=10),
     *     ),
     *     @OA\Parameter(name="offset", in="query", required=false,
     *         @OA\Schema(type="integer", minimum=0, example=0),
     *     ),
     *     @OA\Parameter(name="sort", in="query", required=false,
     *         @OA\Schema(type="string", enum={"title_asc", "title_desc", "date_asc", "date_desc"}, example="date_desc"),
     *     ),
     *     @OA\Parameter(name="date_from", in="query", required=false,
     *         @OA\Schema(type="string", format="date", example="2026-01-01"),
     *     ),
     *     @OA\Parameter(name="date_to", in="query", required=false,
     *         @OA\Schema(type="string", format="date", example="2026-12-31"),
     *     ),
     *
     *     @OA\Response(response=200, description="Порция публикаций пользователя",
     *         @OA\JsonContent(ref="#/components/schemas/PostListResponse"),
     *     ),
     *     @OA\Response(response=401, description="Не авторизован (нет Bearer-токена)",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse"),
     *     ),
     * )
     */
    public function myPosts(ListPostsRequest $request): AnonymousResourceCollection
    {
        $posts = $this->listPostsService->list(
            $request->validated(),
            $request->user(),
        );

        return PostResource::collection($posts);
    }
}
<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StoreCommentRequest;
use App\Http\Resources\Comments\CommentResourceCollection;
use App\Http\Resources\Comments\CommentResource;
use App\Services\Comments\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function __construct(
        private readonly CommentService $commentService
    ) {
    }

    public function index(Request $request, string $commentable, int $id): CommentResourceCollection
    {
        $comments = $this->commentService->listByCommentable($commentable, $id);

        return new CommentResourceCollection($comments);
    }

    public function store(StoreCommentRequest $request, string $commentable, int $id): JsonResponse
    {
        $comment = $this->commentService->create($request->user(), $commentable, $id, $request->validated());

        return response()->json((new CommentResource($comment))->toArray($request), 201);
    }
}


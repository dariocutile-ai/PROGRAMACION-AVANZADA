<?php

namespace App\Services\Comments;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Comment;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Collection;

class CommentService
{
    public function __construct(private readonly CommentRepositoryInterface $repository) {}

    public function listByCommentable(string $commentable, int $id): Collection
    {
        return $this->repository->listByCommentable($commentable, $id);
    }

    public function create(
        AuthenticatableContract $user,
        string $commentable,
        int $id,
        array $validated
    ): Comment {
        return $this->repository->createForCommentable($commentable, $id, [
            'user_id' => $user->getAuthIdentifier(),
            'content' => $validated['content'],
        ]);
    }
}


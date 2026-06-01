<?php

namespace App\Interfaces;

use App\Models\Comment;

interface CommentRepositoryInterface extends RepositoryInterface
{
    public function listByCommentable(string $commentableType, int $id): \Illuminate\Database\Eloquent\Collection;

    public function createForCommentable(string $commentableType, int $id, array $data): Comment;
}

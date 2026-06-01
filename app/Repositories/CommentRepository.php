<?php

namespace App\Repositories;

use App\Interfaces\CommentRepositoryInterface;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function __construct(Comment $model)
    {
        parent::__construct($model);
    }

    public function listByCommentable(string $commentableType, int $id): Collection
    {
        $commentable = $this->resolveCommentable($commentableType, $id);

        return $commentable->comments()->with('user')->latest()->get();
    }

    public function createForCommentable(string $commentableType, int $id, array $data): Comment
    {
        $commentable = $this->resolveCommentable($commentableType, $id);

        return $commentable->comments()->create([
            'user_id' => $data['user_id'],
            'content' => $data['content'],
        ]);
    }

    private function resolveCommentable(string $commentableType, int $id): \Illuminate\Database\Eloquent\Model
    {
        return match ($commentableType) {
            'products' => Product::query()->findOrFail($id),
            'categories' => Category::query()->findOrFail($id),
            'suppliers' => Supplier::query()->findOrFail($id),
            default => throw new ModelNotFoundException(),
        };
    }
}

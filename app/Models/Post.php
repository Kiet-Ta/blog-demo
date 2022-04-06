<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Post model",
 *     description="Post model",
 *     required={"title", "content"},
 *     @OA\Xml(name="Post"),
 *     @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *     @OA\Property(property="title", type="string", description="Post title"),
 *     @OA\Property(property="content", type="string", description="Post content"),
 *     @OA\Property(
 *          property="created_at",
 *          type="string",
 *          format="date-time",
 *          description="Initial creation timestamp",
 *          readOnly="true"
 *      ),
 *      @OA\Property(
 *          property="updated_at",
 *          type="string",
 *          format="date-time",
 *          description="Last update timestamp",
 *          readOnly="true"
 *      ),
 * )
 */
class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
    ];
}

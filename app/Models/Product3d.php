<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property int $product_id
 * @property string $model_file_path
 * @property string $file_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|Product3d newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product3d newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product3d query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product3d whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product3d whereFileType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product3d whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product3d whereModelFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product3d whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product3d whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product3d extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'model_file_path', 'file_type'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

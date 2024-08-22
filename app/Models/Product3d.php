<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product3d extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'model_file_path', 'file_type'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

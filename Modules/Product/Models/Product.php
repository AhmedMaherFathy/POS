<?php

namespace Modules\Product\Models;

use App\Traits\PaginatedCollection;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Database\Factories\ProductFactory;

class Product extends Model
{
    use HasFactory , PaginatedCollection, MediaAlly;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'production_date',
        'expiration_date',
        'selling_price',
        'buying_price',
        'quantity',
        'discount',
    ];

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    // public function registerMediaCollections(): void
    // {
    //     $this
    //         ->addMediaCollection('images')
    //         ->singleFile();
    // }

    // public function image()
    // {
    //     return $this->mediaRet();
    // }

    // public function mediaRet()
    // {
    //     return Product::query()
    //         ->media()
    //         ->where('collection_name', 'images')
    //         ->select(
    //             array_merge(
    //                 ['id', 'model_id', 'disk', 'file_name', 'mime_type']
    //             )
    //         );
    // }
}

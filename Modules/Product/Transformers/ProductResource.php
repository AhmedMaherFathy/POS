<?php

namespace Modules\Product\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $imageUrl = $this->fetchFirstMedia()['file_url'] ?? null;

        // $defaultImageUrl = asset('public/media/default/store.png');
        // info(env('APP_URL').'/public/media/default/store.png'); die;
        // return $imageUrl ?: $defaultImageUrl;
        return [
                "id" => $this->id,
                "name" => $this->name,
                "production_date" => $this->production_date,
                "expiration_date" => $this->expiration_date,
                "selling_price" => $this->selling_price,
                "buying_price" => $this->buying_price,
                "quantity" => $this->quantity,
                "discount" => $this->discount,
                "image" => $imageUrl ?: env('APP_URL').'/public/media/default/store.png',
        ];
    }
}

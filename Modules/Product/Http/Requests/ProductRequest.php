<?php

namespace Modules\Product\Http\Requests;

use App\Traits\HttpResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class ProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    use HttpResponse;

    public function rules(): array
    {
        $inUpdate = ! preg_match('/.*products$/', $this->url());
        $value = $inUpdate ? 'sometimes' : 'required';

        return [
            'name' => 'string|' . $value,
            'production_date' => 'date|'. $value,
            'expiration_date' => 'after:today|after:production_date|'. $value,
            'selling_price' => 'min:1|'. $value,
            'buying_price' => 'min:1|'. $value,
            'quantity' => 'min:1|integer|'. $value,
            'discount' => 'min:0|sometimes|integer',
            'image' => 'image|mimes:png,jpg,jpeg|max:10240|'. $value,  // 10MB
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}

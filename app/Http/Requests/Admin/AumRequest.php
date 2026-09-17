<?php

namespace App\Http\Requests\Admin;

use App\Models\Aum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() || $this->user()?->isSuperAdmin();
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in(Aum::TYPES)],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'phone' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'maps_url' => ['nullable', 'url', 'max:1000'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }
}

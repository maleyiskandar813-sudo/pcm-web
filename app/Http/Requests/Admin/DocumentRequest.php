<?php

namespace App\Http\Requests\Admin;

use App\Models\Document;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocumentRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(Document::CATEGORIES)],
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,zip', 'max:10240'],
        ];
    }
}

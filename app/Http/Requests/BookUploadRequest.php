<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\Books;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookUploadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'book_name' => ['required', 'string'],
            'book_desc' => ['required', 'string'],
        ];
    }
}
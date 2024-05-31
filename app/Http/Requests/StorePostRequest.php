<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rules\File;

class StorePostRequest extends FormRequest
{
    //tipos de arquivos permitidos
    public static array $extensions = [
        'jpg', 'jpeg', 'png', 'gif', 'webp',
        'avi', 'mp4'
    ];

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'body' => ['nullable', 'string'],
            'attachments' => [
                'array',
                'max:20',
                function ($attribute, $value, $fail) {
                    $totalSize = collect($value)->sum(fn (UploadedFile $file) => $file->getSize());
                    if ($totalSize > 10 * 1024 * 1024) {
                        $fail('O total de arquivos enviados é maior que 1GB.');
                    }
                }

            ],
            'attachments.*' => [
                'file',
                File::types(self::$extensions)
            ],
            'user_id' => ['numeric'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['user_id' => auth()->user()->id]);
    }

    public function messages()
    {
        return [
            'attachments.*.mimes' => 'Formato do arquivo inválido, tipos permitidos: ' .
                implode(',', self::$extensions),
        ];
    }
}

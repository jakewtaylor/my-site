<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetAlbumsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'page' => 'numeric|nullable',
            'per_page' => 'numeric|nullable|max:50',
        ];
    }

    public function getPage()
    {
        $page = $this->input('page');

        if ($page) return intval($page);

        return 1;
    }

    public function getPerPage()
    {
        $perPage = $this->input('per_page');

        if ($perPage) return intval($perPage);

        return 50;
    }
}

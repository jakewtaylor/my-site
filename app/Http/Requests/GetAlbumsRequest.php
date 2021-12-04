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
        ];
    }

    public function getPage()
    {
        $page = $this->input('page');

        if ($page) return intval($page);

        return 1;
    }
}

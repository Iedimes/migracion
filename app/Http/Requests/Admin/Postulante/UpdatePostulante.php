<?php

namespace App\Http\Requests\Admin\Postulante;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdatePostulante extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.postulante.edit', $this->postulante);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['sometimes', 'string'],
            'last_name' => ['sometimes', 'string'],
            'cedula' => ['sometimes', 'string'],
            'marital_status' => ['sometimes', 'string'],
            'nacionalidad' => ['sometimes', 'string'],
            'gender' => ['sometimes', 'string'],
            'birthdate' => ['sometimes', 'string'],
            'localidad' => ['nullable', 'string'],
            'asentamiento' => ['nullable', 'string'],
            'ingreso' => ['sometimes', 'string'],
            'address' => ['sometimes', 'string'],
            'grupo' => ['sometimes', 'string'],
            'phone' => ['sometimes', 'string'],
            'mobile' => ['sometimes', 'string'],
            'nexp' => ['nullable', 'string'],
            
        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();


        //Add your code for manipulation with request data here

        return $sanitized;
    }
}

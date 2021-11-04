<?php

namespace App\Http\Requests\Admin\Postulante;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StorePostulante extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.postulante.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'cedula' => ['required', 'string'],
            'marital_status' => ['required', 'string'],
            'nacionalidad' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'birthdate' => ['required', 'string'],
            'localidad' => ['nullable', 'string'],
            'asentamiento' => ['nullable', 'string'],
            'ingreso' => ['required', 'string'],
            'address' => ['required', 'string'],
            'grupo' => ['required', 'string'],
            'phone' => ['required', 'string'],
            'mobile' => ['required', 'string'],
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

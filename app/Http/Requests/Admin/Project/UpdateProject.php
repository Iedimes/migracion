<?php

namespace App\Http\Requests\Admin\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateProject extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.project.edit', $this->project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'phone' => ['sometimes', 'string'],
            'sat_id' => ['sometimes', 'string'],
            'state_id' => ['sometimes', 'string'],
            'city_id' => ['sometimes', 'string'],
            'modalidad_id' => ['sometimes', 'string'],
            'leader_name' => ['nullable', 'string'],
            'localidad' => ['nullable', 'string'],
            'land_id' => ['sometimes', 'string'],
            'typology_id' => ['sometimes', 'integer'],
            'action' => ['nullable', 'string'],
            'expsocial' => ['nullable', 'string'],
            'exptecnico' => ['nullable', 'string'],
            
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

<?php

namespace App\Http\Requests\Admin\PostulanteHasDiscapacidad;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DestroyPostulanteHasDiscapacidad extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.postulante-has-discapacidad.delete', $this->postulanteHasDiscapacidad);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}

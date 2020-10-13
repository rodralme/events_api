<?php

namespace App\Http\Requests;

use App\Models\Person;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:255',
            'description' => 'nullable',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'organizers' => 'required',
        ];
    }

    /**
     * Custom validations.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->areOrganizersValidPeople()) {
                $validator->errors()->add('organizers', 'Organizers should be valid people!');
            }
        });
    }

    private function areOrganizersValidPeople()
    {
        return collect($this->get('organizers', []))
            ->every(fn ($id) => Person::find($id));
    }
}

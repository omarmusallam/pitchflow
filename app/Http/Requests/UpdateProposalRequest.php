<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProposalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $workspace = auth()->user()->workspace;

        return [
            'client_id' => [
                'required',
                'integer',
                Rule::exists('clients', 'id')->where(function ($query) use ($workspace) {
                    $query->where('workspace_id', $workspace->id);
                }),
            ],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:draft,sent,viewed,accepted,rejected'],
            'intro_message' => ['nullable', 'string'],
            'valid_until' => ['nullable', 'date'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ];
    }
}

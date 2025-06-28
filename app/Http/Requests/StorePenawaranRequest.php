<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePenawaranRequest extends FormRequest
{
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
            'id_user' => 'required|exists:users,id',
            'id_client' => 'required|exists:clients,id',
            'tanggal_penawaran' => 'required|date',
            'judul_penawaran' => 'required|string|max:255',
            'diskon' => 'nullable|numeric|min:0|max:100',
            'diskon_satu' => 'nullable|integer|min:0|max:100',
            'diskon_dua' => 'nullable|integer|min:0|max:100',
            'ppn' => 'nullable|integer|min:0|max:100',
            'total' => 'nullable|numeric|min:0',
            'total_diskon' => 'nullable|numeric|min:0',
            'total_diskon_1' => 'nullable|numeric|min:0',
            'total_diskon_2' => 'nullable|numeric|min:0',
            'grand_total' => 'nullable|numeric|min:0',
            'json_produk' => 'nullable|array',
            'syarat_kondisi' => 'nullable|array',
            'syarat_kondisi.*' => 'nullable|string',
            'catatan' => 'nullable|string',
            'status' => 'nullable|integer',
            'status_deleted' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'id_user.required' => 'Sales harus dipilih.',
            'id_user.exists' => 'Sales yang dipilih tidak valid.',
            'id_client.required' => 'Client harus dipilih.',
            'id_client.exists' => 'Client yang dipilih tidak valid.',
            'tanggal_penawaran.required' => 'Tanggal penawaran harus diisi.',
            'tanggal_penawaran.date' => 'Format tanggal penawaran tidak valid.',
            'judul_penawaran.required' => 'Judul penawaran harus diisi.',
            'judul_penawaran.max' => 'Judul penawaran maksimal 255 karakter.',
            'diskon.numeric' => 'Diskon harus berupa angka.',
            'diskon.min' => 'Diskon minimal 0%.',
            'diskon.max' => 'Diskon maksimal 100%.',
            'diskon_satu.integer' => 'Diskon satu harus berupa angka bulat.',
            'diskon_satu.min' => 'Diskon satu minimal 0%.',
            'diskon_satu.max' => 'Diskon satu maksimal 100%.',
            'diskon_dua.integer' => 'Diskon dua harus berupa angka bulat.',
            'diskon_dua.min' => 'Diskon dua minimal 0%.',
            'diskon_dua.max' => 'Diskon dua maksimal 100%.',
            'total_diskon.numeric' => 'Total diskon harus berupa angka.',
            'total_diskon.min' => 'Total diskon minimal 0.',
            'total_diskon_1.numeric' => 'Total diskon satu harus berupa angka.',
            'total_diskon_1.min' => 'Total diskon satu minimal 0.',
            'total_diskon_2.numeric' => 'Total diskon dua harus berupa angka.',
            'total_diskon_2.min' => 'Total diskon dua minimal 0.',
            'ppn.integer' => 'PPN harus berupa angka bulat.',
            'ppn.min' => 'PPN minimal 0%.',
            'ppn.max' => 'PPN maksimal 100%.',
        ];
    }
}

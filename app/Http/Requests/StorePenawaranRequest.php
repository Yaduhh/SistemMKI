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
        // Untuk update dan storeRevisi, nomor_penawaran tidak required karena sudah ada atau dibuat otomatis
        $routeName = $this->route()->getName();
        $isUpdate = $routeName === 'admin.penawaran.update';
        $isStoreRevisi = $routeName === 'admin.penawaran.store-revisi';
        
        return [
            'id_user' => 'required|exists:users,id',
            'id_client' => 'required|exists:clients,id',
            'nomor_penawaran' => ($isUpdate || $isStoreRevisi) ? 'nullable|string|max:255' : 'required|string|max:255',
            'tanggal_penawaran' => 'required|date',
            'judul_penawaran' => 'required|string|max:255',
            'project' => 'nullable|string|max:255',
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
            'json_produk.*.judul' => 'nullable|string|max:255',
            'json_produk.*.product_sections' => 'nullable|array',
            'json_produk.*.product_sections.*' => 'nullable|array',
            'json_produk.*.product_sections.*.*.item' => 'nullable|string',
            'json_produk.*.product_sections.*.*.type' => 'nullable|string',
            'json_produk.*.product_sections.*.*.dimensi' => 'nullable|string',
            'json_produk.*.product_sections.*.*.panjang' => 'nullable|string',
            'json_produk.*.product_sections.*.*.finishing' => 'nullable|string',
            'json_produk.*.product_sections.*.*.tebal_panjang' => 'nullable|string',
            'json_produk.*.product_sections.*.*.warna' => 'nullable|string',
            'json_produk.*.product_sections.*.*.qty_area' => 'nullable|numeric|min:0',
            'json_produk.*.product_sections.*.*.qty' => 'nullable|numeric|min:0',
            'json_produk.*.product_sections.*.*.harga' => 'nullable|numeric|min:0',
            'json_produk.*.product_sections.*.*.total_harga' => 'nullable|numeric|min:0',
            'json_produk.*.product_sections.*.*.satuan' => 'nullable|string',
            'syarat_kondisi' => 'nullable|array',
            'syarat_kondisi.*' => 'nullable|string',
            'additional_condition' => 'nullable|array',
            'additional_condition.*.label' => 'nullable|string|max:255',
            'additional_condition.*.produk' => 'nullable|array',
            'additional_condition.*.produk.*.item' => 'nullable|string',
            'additional_condition.*.produk.*.code' => 'nullable|string',
            'additional_condition.*.produk.*.slug' => 'nullable|string',
            'additional_condition.*.produk.*.nama_produk' => 'nullable|string',
            'additional_condition.*.produk.*.satuan' => 'nullable|string',
            'additional_condition.*.produk.*.qty_area' => 'nullable|numeric|min:0',
            'additional_condition.*.produk.*.satuan_vol' => 'nullable|string',
            'additional_condition.*.produk.*.qty' => 'nullable|numeric|min:0',
            'additional_condition.*.produk.*.harga' => 'nullable|numeric|min:0',
            'additional_condition.*.produk.*.total_harga' => 'nullable|numeric|min:0',
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
            'nomor_penawaran.required' => 'Nomor penawaran harus diisi.',
            'nomor_penawaran.max' => 'Nomor penawaran maksimal 255 karakter.',
            'tanggal_penawaran.required' => 'Tanggal penawaran harus diisi.',
            'tanggal_penawaran.date' => 'Format tanggal penawaran tidak valid.',
            'judul_penawaran.required' => 'Judul penawaran harus diisi.',
            'judul_penawaran.max' => 'Judul penawaran maksimal 255 karakter.',
            'project.max' => 'Nama project maksimal 255 karakter.',
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

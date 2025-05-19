<x-layouts.app :title="__('Edit Pengajuan')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Edit Pengajuan')" :description="__('Perbarui detail pengajuan di bawah ini')" />

        <form action="{{ route('admin.pengajuan.update', $pengajuan->id) }}" method="POST" class="flex flex-col gap-6">
            @csrf
            @method('PUT')

            <flux:input name="nomor_pengajuan" :label="__('Nomor Pengajuan')" type="text" autocomplete="off"
                value="{{ old('nomor_pengajuan', $pengajuan->nomor_pengajuan) }}" />
            <flux:input name="date_pengajuan" :label="__('Tanggal Pengajuan')" type="date" autocomplete="off"
                value="{{ old('date_pengajuan', $pengajuan->date_pengajuan ? $pengajuan->date_pengajuan->format('Y-m-d') : '') }}" />
            <flux:input name="judul_pengajuan" :label="__('Judul Pengajuan')" type="text" autocomplete="off"
                value="{{ old('judul_pengajuan', $pengajuan->judul_pengajuan) }}" />
            <flux:input name="diskon_satu" :label="__('Diskon Satu')" type="number" autocomplete="off"
                value="{{ old('diskon_satu', $pengajuan->diskon_satu) }}" />
            <flux:input name="diskon_dua" :label="__('Diskon Dua')" type="number" autocomplete="off"
                value="{{ old('diskon_dua', $pengajuan->diskon_dua) }}" />
            <flux:input name="diskon_tiga" :label="__('Diskon Tiga')" type="number" autocomplete="off"
                value="{{ old('diskon_tiga', $pengajuan->diskon_tiga) }}" />
            <flux:input name="client" :label="__('Client')" type="text" autocomplete="off"
                value="{{ old('client', $pengajuan->client) }}" />
            <flux:input name="nama_client" :label="__('Nama Client')" type="text" autocomplete="off"
                value="{{ old('nama_client', $pengajuan->nama_client) }}" />
            <flux:input name="title_produk" :label="__('Title Produk')" type="text" autocomplete="off"
                value="{{ old('title_produk', $pengajuan->title_produk) }}" />
            <flux:input name="title_aksesoris" :label="__('Title Aksesoris')" type="text" autocomplete="off"
                value="{{ old('title_aksesoris', $pengajuan->title_aksesoris) }}" />
            <flux:input name="json_produk" :label="__('JSON Produk')" type="text" autocomplete="off"
                value="{{ old('json_produk', $pengajuan->json_produk) }}" />
            <flux:input name="total_1" :label="__('Total 1')" type="number" step="any" autocomplete="off"
                value="{{ old('total_1', $pengajuan->total_1) }}" />
            <flux:input name="total_2" :label="__('Total 2')" type="number" step="any" autocomplete="off"
                value="{{ old('total_2', $pengajuan->total_2) }}" />
            <flux:input name="note" :label="__('Note')" type="text" autocomplete="off"
                value="{{ old('note', $pengajuan->note) }}" />
            <flux:input name="ppn" :label="__('PPN')" type="number" autocomplete="off"
                value="{{ old('ppn', $pengajuan->ppn) }}" />
            <flux:input name="grand_total" :label="__('Grand Total')" type="number" step="any" autocomplete="off"
                value="{{ old('grand_total', $pengajuan->grand_total) }}" />
            <flux:input name="syarat_kondisi" :label="__('Syarat & Kondisi')" type="text" autocomplete="off"
                value="{{ old('syarat_kondisi', $pengajuan->syarat_kondisi) }}" />
            <flux:input name="status" :label="__('Status')" type="number" autocomplete="off"
                value="{{ old('status', $pengajuan->status) }}" />
            <flux:select name="status_deleted" :label="__('Status Deleted')">
                <option value="0" @if (old('status_deleted', $pengajuan->status_deleted) == 0) selected @endif>{{ __('Aktif') }}</option>
                <option value="1" @if (old('status_deleted', $pengajuan->status_deleted) == 1) selected @endif>{{ __('Dihapus') }}</option>
            </flux:select>

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Update') }}
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts.app>

<div>
    <table class="min-w-full border border-gray-300 rounded-lg dark:border-zinc-700 dark:bg-zinc-900 shadow-sm">
        <thead class="bg-gray-100 dark:bg-zinc-800">
            <tr>
                <th class="px-3 py-2 text-left">No</th>
                <th class="px-3 py-2 text-left">Area</th>
                <th class="px-3 py-2 text-left">Section</th>
                <th class="px-3 py-2 text-left">Item</th>
                <th class="px-3 py-2 text-left">Type</th>
                <th class="px-3 py-2 text-left">Dimensi</th>
                <th class="px-3 py-2 text-left">Panjang</th>
                <th class="px-3 py-2 text-left">Finishing</th>
                <th class="px-3 py-2 text-left">Tebal/Panjang</th>
                <th class="px-3 py-2 text-left">Qty Area</th>
                <th class="px-3 py-2 text-left">Qty</th>
                <th class="px-3 py-2 text-left">Harga</th>
                <th class="px-3 py-2 text-left">Total Harga</th>
                <th class="px-3 py-2 text-left">Satuan</th>
            </tr>
        </thead>
        <tbody id="material-utama-body">
            @php $grandTotal = 0; @endphp
            @foreach($produk as $i => $item)
                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-zinc-900 dark:even:bg-zinc-800">
                    <td class="border px-3 py-2 dark:border-zinc-700">{{ $i+1 }}</td>
                    <td class="border px-3 py-2 dark:border-zinc-700">{{ $item['area'] ?? '' }}</td>
                    <td class="border px-3 py-2 dark:border-zinc-700">{{ $item['section'] ?? '' }}</td>
                    <td class="border px-3 py-2 dark:border-zinc-700">{{ $item['item'] ?? '' }}</td>
                    <td class="border px-3 py-2 dark:border-zinc-700">{{ $item['type'] ?? '' }}</td>
                    <td class="border px-3 py-2 dark:border-zinc-700">{{ $item['dimensi'] ?? '' }}</td>
                    <td class="border px-3 py-2 dark:border-zinc-700">{{ $item['panjang'] ?? '' }}</td>
                    <td class="border px-3 py-2 dark:border-zinc-700">{{ $item['finishing'] ?? '' }}</td>
                    <td class="border px-3 py-2 dark:border-zinc-700">{{ $item['tebal_panjang'] ?? '' }}</td>
                    <td class="border px-3 py-2 dark:border-zinc-700">{{ $item['qty_area'] ?? '' }}</td>
                    <td class="border px-3 py-2 dark:border-zinc-700">{{ $item['qty'] ?? '' }}</td>
                    <td class="border px-3 py-2 dark:border-zinc-700">{{ isset($item['harga']) ? number_format($item['harga'], 0, ',', '.') : '' }}</td>
                    <td class="border px-3 py-2 dark:border-zinc-700 font-semibold">{{ isset($item['total_harga']) ? number_format($item['total_harga'], 0, ',', '.') : '' }}</td>
                    <td class="border px-3 py-2 dark:border-zinc-700">{{ $item['satuan'] ?? '' }}</td>
                </tr>
                @php $grandTotal += isset($item['total_harga']) ? (float)$item['total_harga'] : 0; @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-gray-200 dark:bg-zinc-800">
                <td colspan="12" class="text-right font-semibold px-3 py-2">Grand Total</td>
                <td class="font-bold px-3 py-2 text-emerald-700 dark:text-emerald-400">{{ number_format($grandTotal, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div> 
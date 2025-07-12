<div>
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 rounded-lg dark:border-zinc-700 dark:bg-zinc-900 shadow-sm">
            <thead class="bg-gray-100 dark:bg-zinc-800">
                <tr>
                    <th class="px-3 py-2 text-left whitespace-nowrap">No</th>
                    <th class="px-3 py-2 text-left whitespace-nowrap">Item</th>
                    <th class="px-3 py-2 text-left whitespace-nowrap">Type</th>
                    <th class="px-3 py-2 text-left whitespace-nowrap">Dimensi</th>
                    <th class="px-3 py-2 text-left whitespace-nowrap">Panjang</th>
                    <th class="px-3 py-2 text-left whitespace-nowrap">Qty</th>
                    <th class="px-3 py-2 text-left whitespace-nowrap">Satuan</th>
                    <th class="px-3 py-2 text-left whitespace-nowrap">Warna</th>
                    <th class="px-3 py-2 text-left whitespace-nowrap">Harga</th>
                    <th class="px-3 py-2 text-left whitespace-nowrap">Total Harga</th>
                </tr>
            </thead>
        <tbody id="material-utama-body">
            @php $grandTotal = 0; @endphp
            @foreach($produk as $i => $item)
                @php
                    // Find existing data for this item
                    $existingItemData = null;
                    if (isset($existingData) && is_array($existingData)) {
                        foreach ($existingData as $existing) {
                            if (isset($existing['item']) && $existing['item'] === $item['item']) {
                                $existingItemData = $existing;
                                break;
                            }
                        }
                    }
                @endphp
                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-zinc-900 dark:even:bg-zinc-800">
                    <td class="border px-3 py-2 dark:border-zinc-700">{{ $i+1 }}</td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="hidden" name="material_utama[{{ $i }}][item]" value="{{ $existingItemData['item'] ?? $item['item'] ?? '' }}">
                        {{ $existingItemData['item'] ?? $item['item'] ?? '' }}
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="hidden" name="material_utama[{{ $i }}][type]" value="{{ $existingItemData['type'] ?? $item['type'] ?? '' }}">
                        {{ $existingItemData['type'] ?? $item['type'] ?? '' }}
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="hidden" name="material_utama[{{ $i }}][dimensi]" value="{{ $existingItemData['dimensi'] ?? $item['dimensi'] ?? '' }}">
                        {{ $existingItemData['dimensi'] ?? $item['dimensi'] ?? '' }}
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="hidden" name="material_utama[{{ $i }}][panjang]" value="{{ $existingItemData['panjang'] ?? $item['panjang'] ?? '' }}">
                        {{ $existingItemData['panjang'] ?? $item['panjang'] ?? '' }}
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="hidden" name="material_utama[{{ $i }}][qty]" value="{{ $existingItemData['qty'] ?? $item['qty'] ?? '' }}">
                        {{ $existingItemData['qty'] ?? $item['qty'] ?? '' }}
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="text" name="material_utama[{{ $i }}][satuan]" 
                               value="{{ $existingItemData['satuan'] ?? $item['satuan'] ?? '' }}" placeholder="PCS/BATANG/DLL"
                               class="w-full px-2 py-1 border border-gray-300 rounded dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="text" name="material_utama[{{ $i }}][warna]" 
                               value="{{ $existingItemData['warna'] ?? '' }}" 
                               class="w-full px-2 py-1 border border-gray-300 rounded dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
                               placeholder="Masukkan warna">
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="hidden" name="material_utama[{{ $i }}][harga_satuan]" 
                               value="{{ $existingItemData['harga_satuan'] ?? $item['harga'] ?? 0 }}">
                        <div class="w-full px-2 py-1 text-right">
                            Rp {{ number_format($existingItemData['harga_satuan'] ?? $item['harga'] ?? 0, 0, ',', '.') }}
                        </div>
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="hidden" name="material_utama[{{ $i }}][total]" 
                               value="{{ $existingItemData['total'] ?? $item['total_harga'] ?? 0 }}">
                        <div class="w-full px-2 py-1 text-right font-semibold">
                            Rp {{ number_format($existingItemData['total'] ?? $item['total_harga'] ?? 0, 0, ',', '.') }}
                        </div>
                    </td>
                </tr>
                @php 
                    $totalValue = $existingItemData['total'] ?? $item['total_harga'] ?? 0;
                    $grandTotal += (float)$totalValue; 
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-gray-200 dark:bg-zinc-800">
                <td colspan="9" class="text-right font-semibold px-3 py-2">Grand Total</td>
                <td class="font-bold px-3 py-2 text-emerald-700 dark:text-emerald-400 text-right">
                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>
    </div>
</div>

 
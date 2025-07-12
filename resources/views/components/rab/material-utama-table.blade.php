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
            @if(isset($existingData) && is_array($existingData) && count($existingData) > 0)
                {{-- Use existing data if available --}}
                @foreach($existingData as $i => $existingItemData)
                    <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-zinc-900 dark:even:bg-zinc-800">
                        <td class="border px-3 py-2 dark:border-zinc-700">{{ $i+1 }}</td>
                        <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                            <input type="hidden" name="material_utama[{{ $i }}][item]" value="{{ $existingItemData['item'] ?? '' }}">
                            {{ $existingItemData['item'] ?? '' }}
                        </td>
                        <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                            <input type="hidden" name="material_utama[{{ $i }}][type]" value="{{ $existingItemData['type'] ?? '' }}">
                            {{ $existingItemData['type'] ?? '' }}
                        </td>
                        <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                            <input type="hidden" name="material_utama[{{ $i }}][dimensi]" value="{{ $existingItemData['dimensi'] ?? '' }}">
                            {{ $existingItemData['dimensi'] ?? '' }}
                        </td>
                        <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                            <input type="hidden" name="material_utama[{{ $i }}][panjang]" value="{{ $existingItemData['panjang'] ?? '' }}">
                            {{ $existingItemData['panjang'] ?? '' }}
                        </td>
                        <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                            <input type="hidden" name="material_utama[{{ $i }}][qty]" value="{{ $existingItemData['qty'] ?? '' }}">
                            {{ $existingItemData['qty'] ?? '' }}
                        </td>
                        <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                            <input type="text" name="material_utama[{{ $i }}][satuan]" 
                                   value="{{ $existingItemData['satuan'] ?? '' }}" placeholder="PCS/BATANG/DLL"
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
                                   value="{{ $existingItemData['harga_satuan'] ?? 0 }}">
                            <div class="w-full px-2 py-1 text-right">
                                Rp {{ number_format($existingItemData['harga_satuan'] ?? 0, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                            <input type="hidden" name="material_utama[{{ $i }}][total]" 
                                   value="{{ $existingItemData['total'] ?? 0 }}">
                            <div class="w-full px-2 py-1 text-right font-semibold">
                                Rp {{ number_format($existingItemData['total'] ?? 0, 0, ',', '.') }}
                            </div>
                        </td>
                    </tr>
                    @php 
                        $totalValue = $existingItemData['total'] ?? 0;
                        $grandTotal += (float)$totalValue; 
                    @endphp
                @endforeach
            @else
                {{-- Use produk data for new RAB --}}
                @foreach($produk as $i => $item)
                <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-zinc-900 dark:even:bg-zinc-800">
                    <td class="border px-3 py-2 dark:border-zinc-700">{{ $i+1 }}</td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="hidden" name="material_utama[{{ $i }}][item]" value="{{ $item['item'] ?? '' }}">
                        {{ $item['item'] ?? '' }}
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="hidden" name="material_utama[{{ $i }}][type]" value="{{ $item['type'] ?? '' }}">
                        {{ $item['type'] ?? '' }}
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="hidden" name="material_utama[{{ $i }}][dimensi]" value="{{ $item['dimensi'] ?? '' }}">
                        {{ $item['dimensi'] ?? '' }}
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="hidden" name="material_utama[{{ $i }}][panjang]" value="{{ $item['panjang'] ?? '' }}">
                        {{ $item['panjang'] ?? '' }}
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="number" step="0.01" min="0" name="material_utama[{{ $i }}][qty]" 
                               value="{{ $item['qty'] ?? '' }}" 
                               class="w-full px-2 py-1 border border-gray-300 rounded dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
                               onchange="updateTotal({{ $i }})">
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="text" name="material_utama[{{ $i }}][satuan]" 
                               value="{{ $item['satuan'] ?? '' }}" placeholder="PCS/BATANG/DLL"
                               class="w-full px-2 py-1 border border-gray-300 rounded dark:bg-zinc-800 dark:border-zinc-700 dark:text-white">
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="text" name="material_utama[{{ $i }}][warna]" 
                               value="{{ $item['warna'] ?? '' }}" 
                               class="w-full px-2 py-1 border border-gray-300 rounded dark:bg-zinc-800 dark:border-zinc-700 dark:text-white"
                               placeholder="Masukkan warna">
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="number" step="0.01" min="0" name="material_utama[{{ $i }}][harga_satuan]" 
                               value="{{ $item['harga'] ?? 0 }}" 
                               class="w-full px-2 py-1 border border-gray-300 rounded dark:bg-zinc-800 dark:border-zinc-700 dark:text-white text-right"
                               onchange="updateTotal({{ $i }})">
                    </td>
                    <td class="border px-3 py-2 dark:border-zinc-700 truncate">
                        <input type="number" step="0.01" min="0" name="material_utama[{{ $i }}][total]" 
                               value="{{ $item['total_harga'] ?? 0 }}" 
                               class="w-full px-2 py-1 border border-gray-300 rounded dark:bg-zinc-800 dark:border-zinc-700 dark:text-white text-right font-semibold"
                               readonly>
                    </td>
                </tr>
                @php 
                    $totalValue = $item['total_harga'] ?? 0;
                    $grandTotal += (float)$totalValue; 
                @endphp
                @endforeach
            @endif
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



 
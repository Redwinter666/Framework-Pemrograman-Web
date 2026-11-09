<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Penjualan</h2>
            <span class="text-sm text-gray-500">
                Periode {{ $start->format('d M Y') }} &ndash; {{ $end->format('d M Y') }}
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form method="GET" action="{{ route('report.sales') }}" class="flex flex-wrap gap-3 items-end mb-4">
                    <div>
                        <label for="start" class="block text-sm text-gray-700">Dari Tanggal</label>
                        <input type="date" id="start" name="start" value="{{ $start->format('Y-m-d') }}"
                            class="rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label for="end" class="block text-sm text-gray-700">Sampai Tanggal</label>
                        <input type="date" id="end" name="end" value="{{ $end->format('Y-m-d') }}"
                            class="rounded-md border-gray-300 shadow-sm">
                    </div>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md">
                        Tampilkan
                    </button>
                    <a href="{{ route('report.export', request()->query()) }}"
                        class="bg-green-600 text-white px-4 py-2 rounded-md">
                        Export Excel
                    </a>
                </form>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div class="bg-gray-50 rounded-md p-4">
                        <p class="text-xs text-gray-500">Total Penjualan</p>
                        <p class="text-xl font-semibold">Rp{{ number_format($totalPenjualan, 0, ',', '.') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-md p-4">
                        <p class="text-xs text-gray-500">Jumlah Transaksi</p>
                        <p class="text-xl font-semibold">{{ $jumlahTransaksi }}</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">No. Invoice</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Tanggal</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500">Kasir</th>
                                <th class="px-3 py-2 text-right text-xs font-medium text-gray-500">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($transactions as $trx)
                                <tr>
                                    <td class="px-3 py-2">{{ $trx->invoice_number }}</td>
                                    <td class="px-3 py-2">{{ $trx->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-3 py-2">{{ $trx->user->name }}</td>
                                    <td class="px-3 py-2 text-right">Rp{{ number_format($trx->total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-3 py-6 text-center text-gray-500">
                                        Belum ada transaksi pada rentang tanggal ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>

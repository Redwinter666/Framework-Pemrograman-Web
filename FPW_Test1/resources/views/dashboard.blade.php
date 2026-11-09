<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('report.sales') }}" class="text-sm text-indigo-600 hover:text-indigo-800">
                    Lihat Laporan Penjualan
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <x-card>
                    <p class="text-xs text-gray-500">Omzet Hari Ini</p>
                    <p class="text-xl font-semibold">Rp{{ number_format($omzetHariIni, 0, ',', '.') }}</p>
                </x-card>
                <x-card>
                    <p class="text-xs text-gray-500">Omzet Kemarin</p>
                    <p class="text-xl font-semibold">Rp{{ number_format($omzetKemarin, 0, ',', '.') }}</p>
                </x-card>
                <x-card>
                    <p class="text-xs text-gray-500">Transaksi Hari Ini</p>
                    <p class="text-xl font-semibold">{{ $transaksiHariIni }}</p>
                </x-card>
                <x-card>
                    <p class="text-xs text-gray-500">Produk Stok Menipis</p>
                    <p class="text-xl font-semibold text-yellow-600">{{ $produkMenipis }}</p>
                </x-card>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <x-card class="lg:col-span-2">
                    <h3 class="font-semibold mb-3">Tren Penjualan 7 Hari Terakhir</h3>
                    <canvas id="chartTren" height="120"></canvas>
                </x-card>

                <x-card>
                    <h3 class="font-semibold mb-3">Produk Terlaris</h3>
                    @if ($produkTerlaris->isNotEmpty())
                        <ol class="list-decimal list-inside space-y-1 text-sm">
                            @foreach ($produkTerlaris as $produk)
                                <li>
                                    {{ $produk->name }}
                                    <span class="text-gray-500">({{ $produk->total_qty }} terjual)</span>
                                </li>
                            @endforeach
                        </ol>
                    @else
                        <p class="text-sm text-gray-500">Belum ada penjualan.</p>
                    @endif
                </x-card>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const canvas = document.getElementById('chartTren');

                if (!canvas || typeof Chart === 'undefined') {
                    return;
                }

                new Chart(canvas, {
                    type: 'line',
                    data: {
                        labels: @json($labelTren),
                        datasets: [{
                            label: 'Penjualan (Rp)',
                            data: @json($dataTren),
                            borderColor: '#4f46e5',
                            backgroundColor: 'rgba(79, 70, 229, 0.12)',
                            fill: true,
                            tension: 0.3,
                        }],
                    },
                    options: {
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        return 'Rp' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                    },
                                },
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function (value) {
                                        return 'Rp' + new Intl.NumberFormat('id-ID').format(value);
                                    },
                                },
                            },
                        },
                    },
                });
            });
        </script>
    @endpush
</x-app-layout>

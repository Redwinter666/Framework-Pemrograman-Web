<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // Menampilkan halaman laporan penjualan dengan filter rentang tanggal
    public function sales(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : now()->subDays(6)->startOfDay();
        $end = $request->filled('end') ? Carbon::parse($request->end)->endOfDay() : now()->endOfDay();

        $transactions = Transaction::with('user')
            ->whereBetween('created_at', [$start, $end])
            ->latest()
            ->get();

        $totalPenjualan = $transactions->sum('total');
        $jumlahTransaksi = $transactions->count();

        return view('reports.sales', compact('transactions', 'totalPenjualan', 'jumlahTransaksi', 'start', 'end'));
    }

    // Mengunduh laporan penjualan sebagai berkas Excel (.xlsx)
    public function export(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : now()->subDays(6)->startOfDay();
        $end = $request->filled('end') ? Carbon::parse($request->end)->endOfDay() : now()->endOfDay();

        $filename = 'laporan-penjualan-' . $start->format('Ymd') . '-' . $end->format('Ymd') . '.xlsx';

        return Excel::download(new SalesExport($start, $end), $filename);
    }
}

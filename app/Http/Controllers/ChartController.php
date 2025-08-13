<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\PengaduanLog;

class ChartController extends Controller
{
    public function getDataInvoice()
    {
        // Ambil jumlah invoice berdasarkan status
        $labels = ['Proses', 'Lunas'];
        $values = [
            Invoice::where('status', 'Pending')->count(),
            Invoice::where('status', 'Paid')->count(),
        ];

        return response()->json([
            'labels' => $labels,
            'values' => $values
        ]);
    }

    public function getDataLaporan()
    {
        // Ambil jumlah laporan berdasarkan status
        $labels = ['Lapor', 'Proses', 'Keputusan'];
        $values = [
            PengaduanLog::where('status', 'diajukan')->count(),
            PengaduanLog::where('status', 'diproses')->count(),
            PengaduanLog::where('status', 'disetujui')->count(),
        ];

        return response()->json([
            'labels' => $labels,
            'values' => $values
        ]);
    }

    public function getInvoiceGaris()
    {
        // Hitung invoice per tanggal
        $data = Invoice::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return response()->json([
            'labels' => $data->pluck('date'),
            'values' => $data->pluck('count')
        ]);
    }

    public function getLaporanGaris()
    {
        // Hitung laporan per tanggal
        $data = PengaduanLog::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return response()->json([
            'labels' => $data->pluck('date'),
            'values' => $data->pluck('count')
        ]);
    }
}


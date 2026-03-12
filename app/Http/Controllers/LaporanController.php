<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $this->authorizeStaff();

        $search = trim((string) $request->string('search'));
        $status = trim((string) $request->string('status'));

        $pinjamans = $this->buildQuery($search, $status)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('laporan.index', compact('pinjamans', 'status'));
    }

    public function exportPdf(Request $request)
    {
        $this->authorizeStaff();

        $search = trim((string) $request->string('search'));
        $status = trim((string) $request->string('status'));

        $pinjamans = $this->buildQuery($search, $status)
            ->latest()
            ->get();

        $pdf = Pdf::loadView('laporan.pdf', [
            'pinjamans' => $pinjamans,
            'printedAt' => now(),
            'search' => $search,
            'status' => $status,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-peminjaman-' . now()->format('Ymd-His') . '.pdf');
    }

    private function buildQuery(string $search, string $status)
    {
        return Peminjaman::with(['user', 'buku.kategori'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })->orWhereHas('buku', function ($bukuQuery) use ($search) {
                        $bukuQuery->where('judul', 'like', "%{$search}%")
                            ->orWhere('penulis', 'like', "%{$search}%");
                    });
                });
            })
            ->when($status !== '', function ($query) use ($status) {
                $query->where('status_peminjaman', $status);
            });
    }

    private function authorizeStaff(): void
    {
        if (!Auth::check() || !in_array(Auth::user()->level, ['admin', 'petugas'], true)) {
            abort(403, 'Akses Ditolak.');
        }
    }
}
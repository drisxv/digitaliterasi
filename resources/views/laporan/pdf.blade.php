{{--
    Template PDF laporan peminjaman.

    Kegunaan:
    - Dipakai oleh DOMPDF untuk menghasilkan file PDF dari data peminjaman.
    - Menampilkan metadata cetak (waktu cetak, keyword pencarian, status filter).

    Route pemanggil: `laporan.pdf`
    Data:
    - $pinjamans: collection/paginator Peminjaman
    - $printedAt: waktu cetak (Carbon)
    - $search: string keyword
    - $status: string status filter
--}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            font-size: 12px;
        }

        .header {
            margin-bottom: 24px;
        }

        .title {
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin: 0 0 6px 0;
        }

        .subtitle {
            color: #6b7280;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin: 0;
        }

        .meta {
            margin-top: 12px;
            color: #4b5563;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 10px;
            vertical-align: top;
        }

        th {
            background: #f3f4f6;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .muted {
            color: #6b7280;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <p class="title">Laporan Peminjaman</p>
        <p class="subtitle">Digitaliterasi</p>
        <div class="meta">
            <div>Dicetak: {{ $printedAt->format('d M Y H:i') }}</div>
            <div>Pencarian: {{ $search !== '' ? $search : 'Semua data' }}</div>
            <div>Status: {{ $status !== '' ? $status : 'Semua status' }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Peminjam</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pinjamans as $pinjaman)
            <tr>
                <td>
                    <div><strong>{{ $pinjaman->user->nama_lengkap }}</strong></div>
                    <div class="muted">{{ '@' . $pinjaman->user->username }} • {{ $pinjaman->user->email }}</div>
                </td>
                <td>
                    <div><strong>{{ $pinjaman->buku->judul }}</strong></div>
                    <div class="muted">{{ $pinjaman->buku->kategori->nama_kategori ?? 'Umum' }}</div>
                </td>
                <td>{{ $pinjaman->tanggal_peminjaman->format('d M Y') }}</td>
                <td>{{ $pinjaman->tanggal_pengembalian?->format('d M Y') ?? '-' }}</td>
                <td>{{ $pinjaman->status_peminjaman }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Tidak ada data peminjaman.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
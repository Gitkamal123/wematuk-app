<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">  
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h1 {
            text-align: center;
        }

        /* Tombol akan disembunyikan saat print */
        @media print {
            .no-print {
                display: none;
            }
        }

        /* Style untuk tombol "Cetak Ulang" */
        .btn-cetak {
            padding: 8px 12px;
            background-color: #0d6efd;
            /* Biru */
            color: white;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        /* Style untuk tombol "Tutup" */
        .btn-tutup {
            padding: 8px 12px;
            background-color: #6c757d;
            /* Abu-abu */
            color: white;
            border-radius: 4px;
            margin-left: 10px;
            border: none;
            cursor: pointer;
        }
    </style>


</head>

<body onload="window.print()">
    <h1>Daftar Tugas Kuliah</h1>
    <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d M Y, H:i') }}</p>

    <button class="no-print btn-cetak" onclick="window.print()">Cetak</button>
    <button class="no-print btn-tutup" onclick="try { window.opener.location.href='{{ route('home') }}'; } catch(e) {} window.close();">
    Kembali</button>

    <br><br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Tugas</th>
                <th>Deskripsi</th>
                <th>Deadline</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tugas as $index => $t)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $t->judul }}</td>
                    <td>{{ $t->deskripsi }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->deadline)->format('d M Y, H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data tugas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>


</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Rekap Financial</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        .tengah {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }

        /* header wrapper */
    .header-wrap{
        width:100%;
        margin-bottom:20px;
    }

    /* tabel karena dompdf lebih stabil */
    .header-table{
        width:100%;
        /* border-collapse:collapse; */
    }
    .header-table td{
        vertical-align:middle;
        padding:0;                /* hilangkan jarak bawaan */
        border: 0;
    }
    .logo{
        width:100px;
    }
    h2,h4{
        margin:0;                 /* supaya rapat */
    }
    </style>
</head>

<body>

    <div class="header-wrap">
        <table class="header-table">
            <tr>
                <!-- kolom kiri: logo -->
                <td style="width:110px">
                    <img src="{{ public_path('home/assets/img/undipaa.png') }}" class="logo" alt="Logo">
                </td>
    
                <!-- kolom tengah: judul, dipusatkan -->
                <td style="text-align:center">
                    <h2>Rekap Pendapatan Asisten Dosen</h2>
                    <h4>Periode: {{ $periode }}</h4>
                </td>
    
                <!-- kolom kanan: “penyeimbang” lebar logo agar judul betul‑betul center -->
                <td style="width:110px"></td>
            </tr>
        </table>
        </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Asdos</th>
                <th>Jumlah Kehadiran</th>
                <th>Gaji Bersih</th>
                <th>Tanda terima</th>
            </tr>
        </thead>
        <tbody>
            @foreach($asdos as $index => $a)
                <tr>
                    <td class="tengah">{{ $index + 1 }}</td>
                    <td>{{ $a->nama }}({{ $a->stb }})</td>
                    <td class="tengah">{{ $a->kehadiran }}</td>
                    <td>Rp {{ number_format($a->pendapatan, 0, ',', '.') }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="tengah"><strong>Total Pengeluaran</strong></td>
                <td colspan="2"><strong>Rp {{ number_format($pengeluaran, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

</body>

</html>
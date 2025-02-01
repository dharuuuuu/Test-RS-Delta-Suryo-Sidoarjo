<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $inspection->inv_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #6366f1; color: white; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h1>Invoice</h1>
    <p>Invoice Number : <strong>{{ $inspection->inv_number }}</strong></p>
    <p>Nama Pasien : <strong>{{ $inspection->nama_pasien }}</strong></p>
    <p>Tanggal Pemeriksaan : <strong>{{ $inspection->tanggal_pemeriksaan }}</strong></p>
    <p>Tanggal Pembayaran : <strong>{{ \Carbon\Carbon::parse($tanggal_pembayaran)->format('Y-m-d') }}</strong></p>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Obat</th>
                <th class="text-center">Quantity</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $index = 1; @endphp
            @foreach ($inspection->medicines as $medicine)
                @php
                    $price = app(\App\Http\Controllers\InspectionController::class)->getMedicinePrice($medicine->id_obat, $inspection->tanggal_pemeriksaan);
                    $total = $medicine->jumlah * $price;
                @endphp
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ $medicine->nama_obat }}</td>
                    <td class="text-center">{{ $medicine->jumlah }}</td>
                    <td class="text-right">Rp {{ number_format($price, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Grand Total</th>
                <th class="text-right">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="4" class="text-right">Total Dibayar</th>
                <th class="text-right">Rp {{ number_format($totalBayar, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="4" class="text-right">Total Kembalian</th>
                <th class="text-right">Rp {{ number_format($totalKembalian, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>

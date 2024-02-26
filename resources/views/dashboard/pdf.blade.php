<!-- resources/views/rekap-pdf.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap PDF</title>
    <style>
        /* Add your styling for the PDF layout here */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <h1>Rekap PDF</h1>

    <p>Tanggal: {{ $type === 'month' ? 'Bulan ' . date('F Y', strtotime($value)) : 'Tahun ' . $value }}</p>
    <p>Jumlah Data: {{ count($penilaians) }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Penghasilan</th>
                <th>Tanggungan</th>
                <th>Jaminan</th>
                <th>Tanggal</th>
                <th>Jenis Jaminan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penilaians as $key => $data)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $data->nama_alternatif }}</td>
                    <td>{{ $data->alamat }}</td>
                    <td>{{ $data->penghasilan }}</td>
                    <td>{{ $data->tanggungan }}</td>
                    <td>{{ $data->jaminan }}</td>
                    <td>{{ $data->created_at }}</td>
                    <td>{{ $data->nama_variabel }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>

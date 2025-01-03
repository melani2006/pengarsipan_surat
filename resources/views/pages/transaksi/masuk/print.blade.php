<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h1 {
            margin-bottom: 5px;
        }

        h4 {
            margin-top: 0;
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
        }

        #cari-section {
            margin: 30px 0;
            text-align: start;
        }
    </style>
</head>
<body onload="window.print()">

<hr>

<h2>{{ $title }}</h2>

@if($tanggal)
    <div id="cari-section">
        Cari: {{ ucfirst($cari) }}: {{ date('d-m-Y', strtotime($tanggal)) }}
        <br>
        Total: {{ count($data) }}
    </div>
@endif

<table>
    <thead>
    <tr>
        <th>Perihal</th>
        <th>Nomor Surat</th>
        <th>Penerima</th>
        <th>Tanggal Surat</th>
        <th>Deskripsi</th>
        <th>Catatan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $surat)
        <tr>
            <td>{{ $surat->perihal }}</td>
            <td>{{ $surat->nomor_surat }}</td>
            <td>{{ $surat->pengirim }}</td>
            <td>{{ $surat->formatted_tanggal_surat }}</td>
            <td>{{ $surat->deskripsi }}</td>
            <td>{{ $surat->catatan }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

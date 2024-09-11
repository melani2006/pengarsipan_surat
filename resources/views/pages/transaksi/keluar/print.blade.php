<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dokumen</title>
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
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
        }

        #filter-section {
            margin: 30px 0;
            text-align: start;
        }
    </style>
</head>
<body onload="window.print()">

<h1>{{ $config['institution_name'] }}</h1>
<h4>{{ $config['institution_address'] }}</h4>
<hr>

<h2>{{ $title }}</h2>

@if($since && $until && $filter)
    <div id="filter-section">
        {{ $filter }}: {{ "$since - $until" }}
        <br>
        Total: {{ count($data) }}
    </div>
@endif

<table>
    <thead>
    <tr>
        <th>Nomor Agenda</th>
        <th>Nomor Referensi</th>
        <th>penerima</th>
        <th>Tanggal Surat</th>
        <th>Deskripsi</th>
        <th>Catatan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $letter)
        <tr>
            <td>{{ $letter->agenda_number }}</td>
            <td>{{ $letter->reference_number }}</td>
            <td>{{ $letter->penerima }}</td>
            <td>{{ $letter->formatted_Tanggal_Surat }}</td>
            <td>{{ $letter->deskripsi }}</td>
            <td>{{ $letter->Catatan }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

</body>
</html>

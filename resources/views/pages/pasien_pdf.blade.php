<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pasien</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
		@page {
    	size: A4 landscape;
		}
	</style>
	<center>
		<h4>Data Pasien</h4>
	 	</center>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
                <th>
                    NIK
                  </th>
                  <th>
                    No MKCare
                  </th>
                  <th>
                    No JKN
                  </th>
                  <th>
                    Nama
                  </th>
                  <th>
                    Jenis Kelamin
                  </th>
                  <th>
                  Tempat/Tgl Lahir
                  </th>
                  <th>
                    Alamat
                   </th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($pasien as $p)
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{$p->nik}}</td>
				<td>{{$p->no_mkcare}}</td>
				<td>{{$p->no_jkn}}</td>
				<td>{{$p->nama}}</td>
                <td>{{$p->jenis_kelamin}}</td>
                <td>{{$p->tempat_lahir}}/{{$p->tanggal_lahir}}</td>
                <td>{{$p->alamat}}</td>
			</tr>
			@endforeach
		</tbody>
	</table>

</body>
</html>
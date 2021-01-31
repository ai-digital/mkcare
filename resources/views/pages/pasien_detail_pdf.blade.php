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
	
            <tbody>
                @php $i=1 @endphp
             
			 
            <tr>
                <th>
                    NIK
                  </th> <td>:</td><td>{{$pasien->nik}}</td>
                </tr>
                <tr>
                  <th>
                    No MKCare
                  </th><td>:</td><td>{{$pasien->no_mkcare}}</td>
                </tr>
                <tr>
                  <th>
                    No JKN
                  </th><td>:</td><td>{{$pasien->no_jkn}}</td>
                </tr>
                <tr>
                  <th>
                    Nama
                  </th><td>:</td><td>{{$pasien->nama}}</td>
                </tr>
                <tr>
                  <th>
                    Jenis Kelamin
                  </th><td>:</td><td>{{$pasien->jenis_kelamin}}</td>
                </tr>
                  <tr>
                  <th>
                  Tempat/Tgl Lahir
                  </th><td>:</td><td>{{$pasien->tempat_lahir}}/{{$pasien->tanggal_lahir}}</td>
                </tr>
                <tr>
                  <th>
                    Alamat
                   </th><td>:</td><td>{{$pasien->alamat}}</td>
                </tr>
                <tr>
                    <th>
                     Provinsi
                     </th><td>:</td><td>{{$pasien->provinsi}}</td>
                  </tr>
                  <tr>
                    <th>
                    Kabupaten
                     </th><td>:</td><td>{{$pasien->kabupaten}}</td>
                  </tr> 
                  <tr>
                    <th>
                    Kecamatan
                     </th><td>:</td><td>{{$pasien->kecamatan}}</td>
                  </tr> 
                  <tr>
                    <th>
                   Kelurahan
                     </th><td>:</td><td>{{$pasien->kelurahan}}</td>
                  </tr> 
                  <tr>
                    <th>
                  Nomor HP
                     </th><td>:</td><td>{{$pasien->nomor_hp}}</td>
                  </tr> 
                  <tr>
                    <th>
                   Nomor WA
                     </th><td>:</td><td>{{$pasien->nomor_wa}}</td>
                  </tr> 
			 
		</tbody>
	</table>

</body>
</html>
<?php

namespace App\Imports;

use App\Models\Pasien;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class PasiensImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Pasien([
            //
            'nik' => $row['nik'],
            'no_mkcare' => $row['no_mkcare'], 
            'no_jkn' => $row['no_jkn'], 
            'nama' => $row['nama'],
            'tempat_lahir'=> $row['tempat_lahir'],
            'tanggal_lahir'=>\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir']),
            'alamat'=>$row['alamat'],
            'jenis_kelamin'=>$row['jenis_kelamin'],
            'nomor_wa'=>$row['nomor_wa'],
            'nomor_hp'=>$row['nomor_hp'],
        ]);
    }
}

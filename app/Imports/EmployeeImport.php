<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeesImport implements ToModel
{
    public function model(array $row)
    {
        return new Employee([
            'name' => $row[0],
            'nik' => $row[1],
            'email' => $row[2],
            'departemen_id' => $row[3],
            'jabatan_id' => $row[4],
            'gada_id' => $row[5],
            'sertifikat' => $row[6],
            'keterangan' => $row[7],
            'tmt' => $this->transformDate($row[8]),
            'ttl' => $this->transformDate($row[9]),
            'telp' => $row[10],
            'nik_ktp' => $row[11],
            'berlaku' => $row[12],
            'status' => $row[13],
            'pendidikan' => $row[14],
            'nama_ibu' => $row[15],
            'no_regkta' => $row[16],
            'no_kta' => $row[17],
            'alamat_ktp' => $row[18],
            'alamat_domisili' => $row[19],
            'bpjsket' => $row[20],
            'no_npwp' => $row[21],
        ]);
    }

    /**
     * Transformasi tanggal jika diperlukan.
     */
    private function transformDate($value)
    {
        if ($value && is_numeric($value)) {
            return \Carbon\Carbon::createFromFormat('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d'));
        }

        return $value;
    }
}

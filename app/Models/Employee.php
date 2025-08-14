<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'pict_diri',
        'keterangan',
        'tmt',
        'nik',
        'departemen_id',
        'jabatan_id',
        'gada_id',
        'tempat_lahir',
        'ttl',
        'telp',
        'nik_ktp',
        'status_kepegawaian',
        'berlaku',
        'status',
        'pendidikan',
        'email',
        'nama_ibu',
        'nama_pasangan',
        'tempatlahir_pasangan',
        'ttl_pasangan',
        'nama_anak1',
        'tempatlahir_anak1',
        'ttl_anak1',
        'nama_anak2',
        'tempatlahir_anak2',
        'ttl_anak2',
        'nama_anak3',
        'tempatlahir_anak3',
        'ttl_anak3',
        'pict_sertifikat',
        'pict_sertifikat1',
        'pict_sertifikat2',
        'pict_sertifikat3',
        'no_regkta',
        'alamat_ktp',
        'alamat_domisili',
        'bpjsket',
        'no_npwp',
        'bpjskes',
        'pict_ktp',
        'pict_kk',
        'pict_kta',
        'pict_ijasah',
        'pict_bpjsket',
        'pict_bpjskes',
        'pict_npwp',
        'pict_pkwt',
        'uk_sepatu',
        'uk_seragam',
        'status_kerja',
        'pict_jobapp',
        'lokasikerja',
        'date_start',
        'date_end',// Fixed the typo here
    ];

    // Relasi Employee dengan Departemen
   // App\Models\Employee.php
public function departemen()
{
    return $this->belongsTo(Departemen::class, 'departemen_id');
}

public function jabatan()
{
    return $this->belongsTo(Jabatan::class, 'jabatan_id');
}

public function gadaDetail()
{
     return $this->hasMany(GadaDetail::class);
    // or
    return $this->belongsTo(GadaDetail::class);

}
public function gadaDetails()
{
    return $this->hasMany(GadaDetail::class, 'employee_id', 'id');
}


public function partner()
{
    return $this->belongsTo(Partner::class, 'partner_id');
}


    // Relasi Employee dengan Blacklist
    public function blacklist()
    {
        return $this->hasMany(Blacklist::class);
    }
}

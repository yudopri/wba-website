@extends('adminlte::page')

@section('title', 'Details Karyawan')

@section('content_header')
    <h1>Details Karyawan</h1>
@stop

@section('content')
    <!-- Tombol Kembali -->
    <div class="mb-3">
    <a href="{{ route('admin.employee.index', request()->query()) }}" class="btn btn-secondary">
    Back to Employees
</a>

</div>


    <div class="card">
        <div class="card-body">

            <!-- Identitas Karyawan -->
            <h5>Identitas Karyawan</h5>
            <div class="mb-3">
                <strong>Name:</strong>
                <p>{{ $employee->name }}</p>
            </div>
            <div class="mb-3">
                <strong>NIK KTP:</strong>
                <p>{{ $employee->nik_ktp ? Crypt::decryptString($employee->nik_ktp) : '-' }}</p>
            </div>
            <div class="mb-3">
                <strong>Alamat KTP:</strong>
                <p>{{ Crypt::decryptString($employee->alamat_ktp) ?: '-' }}</p>
            </div>
            <div class="mb-3">
                <strong>Alamat Domisili:</strong>
                <p>{{ Crypt::decryptString($employee->alamat_domisili) ?: '-' }}</p>
            </div>
            <div class="mb-3">
                <strong>NIK Karyawan:</strong>
                <p>{{ $employee->nik ? Crypt::decryptString($employee->nik) : '-' }}</p>
            </div>
            <div class="mb-3">
                <strong>No KTA:</strong>
                <p>{{ $employee->no_regkta ? Crypt::decryptString($employee->no_regkta) : '-' }}</p>
            </div>
            <div class="mb-3">
                <strong>No BPJS Ketenagakerjaan:</strong>
                <p>{{ $employee->bpjsket ? Crypt::decryptString($employee->bpjsket) : '-' }}</p>
            </div>
            <div class="mb-3">
                <strong>No BPJS Kesehatan:</strong>
                <p>{{ $employee->bpjskes ? Crypt::decryptString($employee->bpjskes) : '-' }}</p>
            </div>
            <div class="mb-3">
                <strong>No NPWP:</strong>
                <p>{{ $employee->no_npwp ? Crypt::decryptString($employee->no_npwp) : '-' }}</p>
            </div>
            <div class="mb-3">
                <strong>Tempat Tanggal Lahir:</strong>
                <p>
                    {{ $employee->tempat_lahir }},
                    {{ $employee->ttl ? \Carbon\Carbon::parse($employee->ttl)->format('d M Y') : '-' }}
                </p>
            </div>
            <div class="mb-3">
                <strong>Phone:</strong>
                <p>{{ Crypt::decryptString($employee->telp) ?: '-' }}</p>
            </div>

           <!-- Informasi Pribadi -->
            <h5>Informasi Pribadi</h5>
            <div class="mb-3">
                <strong>Status:</strong>
                <p id="status_text">{{ $employee->status ?: '-' }}</p>
            </div>
            <div class="mb-3">
                <strong>Nama Ibu:</strong>
                <p>{{ $employee->nama_ibu ? Crypt::decryptString($employee->nama_ibu) : '-' }}</p>
            </div>

            <!-- Nama Pasangan -->
            <div class="mb-3" id="nama_pasangan_group">
                <strong>Nama Pasangan:</strong>
                <p>{{ $employee->nama_pasangan ? Crypt::decryptString($employee->nama_pasangan) : '-' }}</p>
            </div>

            <!-- Tempat Tanggal Lahir Pasangan -->
            <div class="mb-3" id="tempat_pasangan_group">
                <strong>Tempat Tanggal Lahir Pasangan:</strong>
                <p>
                    {{ $employee->tempatlahir_pasangan }},
                    {{ $employee->ttl_pasangan ? \Carbon\Carbon::parse($employee->ttl_pasangan)->format('d M Y') : '-' }}
                </p>
            </div>

            @php
                $children = [
                    [
                        'nama' => $employee->nama_anak1 ? Crypt::decryptString($employee->nama_anak1) : '-',
                        'tempat_lahir' => $employee->tempatlahir_anak1 ?: '',
                        'ttl' => $employee->ttl_anak1 ?: ''
                    ],
                    [
                        'nama' => $employee->nama_anak2 ? Crypt::decryptString($employee->nama_anak2) : '-',
                        'tempat_lahir' => $employee->tempatlahir_anak2 ?: '',
                        'ttl' => $employee->ttl_anak2 ?: ''
                    ],
                    [
                        'nama' => $employee->nama_anak3 ? Crypt::decryptString($employee->nama_anak3) : '-',
                        'tempat_lahir' => $employee->tempatlahir_anak3 ?: '',
                        'ttl' => $employee->ttl_anak3 ?: ''
                    ]
                ];
            @endphp

            @foreach ($children as $index => $child)
                <!-- Nama Anak -->
                <div class="mb-3" id="nama_anak{{ $index + 1 }}_group">
                    <strong>Nama Anak {{ $index + 1 }}:</strong>
                    <p>{{ $child['nama'] }}</p>
                </div>

                <!-- Tempat Tanggal Lahir Anak -->
                <div class="mb-3" id="tempat_anak{{ $index + 1 }}_group">
                    <strong>Tempat Tanggal Lahir Anak {{ $index + 1 }}:</strong>
                    <p>
                        {{ $child['tempat_lahir'] ?: '-' }},
                        {{ $child['ttl'] ? \Carbon\Carbon::parse($child['ttl'])->format('d M Y') : '-' }}
                    </p>
                </div>
            @endforeach

<div class="mb-3">
                <strong>Ukuran Sepatu:</strong>
                <p>{{ $employee->uk_sepatu ?: '-' }}</p>
            </div>

<div class="mb-3">
                <strong>Ukuran Seragam:</strong>
                <p>{{ $employee->uk_seragam ?: '-' }}</p>
            </div>

            <!-- Pekerjaan -->
            <h5>Pekerjaan</h5>
            <div class="mb-3">
                <strong>Departemen:</strong>
                <p>{{ optional($employee->departemen)->name ?: '-' }}</p>
            </div>
            <div class="mb-3">
                <strong>Jabatan:</strong>
                <p>{{ optional($employee->jabatan)->name ?: '-' }}</p>
            </div>

            <div class="mb-3">
                <strong>Pendidikan:</strong>
                <p>{{ $employee->pendidikan ?: '-' }}</p>
            </div>

            <div class="mb-3">
                <strong>Sertifikasi:</strong>
                <p>
                    @if ($employee->gadadetail->isEmpty())
                        Tidak Ada
                    @else
                        @foreach ($employee->gadadetail as $detail)
                            {{ $detail->gada->name ?: '-' }}@if (!$loop->last), @endif
                        @endforeach
                    @endif
                </p>
            </div>
            <div class="mb-3">
                <strong>Lokasi:</strong>
                <p>{{ $employee->lokasikerja ?: '-' }}</p>
            </div>
            <div class="mb-3">
                <strong>Status Kepegawaian:</strong>
                <p id="status_kepegawaian_text">{{ $employee->status_kepegawaian ?: '-' }}</p>
            </div>
               <h5>Dokumen Lain</h5>
<div>
    @foreach ([
        'diri' => 'Diri',
        'ktp' => 'KTP',
        'kk' => 'KK',
        'kta' => 'KTA',
        'ijasah' => 'Ijazah',
        'bpjsket' => 'BPJS Ketenagakerjaan',
        'bpjskes' => 'BPJS Kesehatan',
        'npwp' => 'NPWP',
        'jobapp' => 'Lamaran Kerja'
    ] as $documentKey => $documentLabel)
        <div class="mb-3">
            <strong>Foto {{ $documentLabel }}:</strong>
            <div class="d-flex align-items-center">
                @if($employee->{'pict_' . $documentKey})
                    <a href="{{ asset($employee->{'pict_' . $documentKey}) }}" target="_blank" class="btn btn-info btn-sm mr-2">
                        <i class="fas fa-eye"></i> View {{ $documentLabel }}
                    </a>
                    <!-- Delete Button -->
                    <form action="{{ route('admin.employee.deleteDocument', [$employee->id, $documentKey]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mr-2">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                    @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
                        <a href="{{ route('admin.employee.' . $documentKey, $employee->id) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> Download
                        </a>
                    @endif
                @else
                    <p class="text-muted">No {{ $documentLabel }} uploaded</p>
                @endif
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    @foreach ([
        'sertifikat' => 'Sertifikat',
        'sertifikat1' => 'Sertifikat Tambahan 1',
        'sertifikat2' => 'Sertifikat Tambahan 2',
        'sertifikat3' => 'Sertifikat Tambahan 3'
    ] as $certificateKey => $certificateLabel)
        <div class="col-md-4 mb-4">
            <strong>{{ $certificateLabel }}:</strong>
            <div class="d-flex align-items-center">
                @if($employee->{'pict_' . $certificateKey})
                    <a href="{{ asset($employee->{'pict_' . $certificateKey}) }}" target="_blank" class="btn btn-info btn-sm mr-2">
                        <i class="fas fa-eye"></i> View {{ $certificateLabel }}
                    </a>
                    <!-- Delete Button -->
                    <form action="{{ route('admin.employee.deleteDocument', [$employee->id, $certificateKey]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mr-2">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                    @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
                        <a href="{{ route('admin.employee.' . $certificateKey, $employee->id) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> Download
                        </a>
                    @endif
                @else
                    <p class="text-muted">No {{ $certificateLabel }} uploaded</p>
                @endif
            </div>
        </div>
    @endforeach
</div>



            @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
                <h5>Informasi Tambahan</h5>
                <div class="mb-3">
                    <strong>Keterangan:</strong>
                    <p>{{ $employee->keterangan ?: '-' }}</p>
                </div>
                <div class="mb-3" id="tanggal_mulai_group">
                    <strong>Tanggal Mulai:</strong>
                    <p>{{ $employee->date_start === '0000-00-00' || !$employee->date_start ? '-' : \Carbon\Carbon::parse($employee->date_start)->translatedFormat('d F Y') }}</p>
                </div>
                <div class="mb-3" id="tanggal_selesai_group">
                    <strong>Tanggal Selesai:</strong>
                    <p>{{ $employee->date_end === '0000-00-00' || !$employee->date_end ? '-' : \Carbon\Carbon::parse($employee->date_end)->translatedFormat('d F Y') }}</p>
                </div>
                <div class="mb-3" id="masa_pkwt_group">
                    <strong>Masa Berlaku PKWT:</strong>
                    <p>{{ $employee->berlaku === '0000-00-00' || !$employee->berlaku ? '-' : \Carbon\Carbon::parse($employee->berlaku)->translatedFormat('d F Y') }}</p>
                </div>
                <div class="mb-3">
            <strong>Foto Dokumen PKWT:</strong>
            <div class="d-flex align-items-center">
                @if($employee->pict_pkwt)
                    <a href="{{ asset($employee->pict_pkwt) }}" target="_blank" class="btn btn-info btn-sm mr-2">
                        <i class="fas fa-eye"></i> View Dokumen PKWT
                    </a>
                    <!-- Delete Button -->
                    <form action="{{ route('admin.employee.deleteDocument', [$employee->id, $employee->pict_pkwt]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mr-2">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                    @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
                        <a href="{{ route('admin.employee.pict_pkwt', $employee->id) }}" class="btn btn-success btn-sm">
                            <i class="fas fa-download"></i> Download
                        </a>
                    @endif
                @else
                    <p class="text-muted">No Dokumen PKWT uploaded</p>
                @endif
            </div>
        </div>
                <div class="mb-3" id="tmt_group">
                    <strong>TMT:</strong>
                    <p>{{ $employee->tmt ? \Carbon\Carbon::parse($employee->tmt)->format('d M Y') : '-' }}</p>
                </div>
            @endif
        </div>

        <div class="card-footer">
            @if(auth()->user()->role === 'Admin')
            <a href="{{ route('admin.employee.edit', $employee->id) }}" class="btn btn-warning">Edit</a>
             @elseif(auth()->user()->role === 'Manager')
                <a href="{{ route('admin.employee.edit', $employee->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('admin.employee.destroy', $employee->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</button>
                </form>
            @endif
        </div>
    </div>
 <script>
    // Update fields based on status kepegawaian
   // Function to update fields based on the status kepegawaian
function updateFields() {
    const statusKepegawaian = document.getElementById("status_kepegawaian_text").textContent.trim();
    const masaPkwtGroup = document.getElementById("masa_pkwt_group");
    const tanggalMulaiGroup = document.getElementById("tanggal_mulai_group");
    const tanggalSelesaiGroup = document.getElementById("tanggal_selesai_group");
    const tmtGroup = document.getElementById("tmt_group");

    // Default: Hide all groups
    console.log("Hiding all groups initially");
    [masaPkwtGroup, tanggalMulaiGroup, tanggalSelesaiGroup, tmtGroup].forEach(group => {
        if (group) group.style.display = "none";
    });

    // Conditional display based on status kepegawaian
    if (statusKepegawaian === "Karyawan Tetap") {
        console.log("Displaying tmtGroup for 'Karyawan Tetap'");
        tmtGroup.style.display = "block";
    } else if (statusKepegawaian === "Karyawan Tidak Tetap") {
        console.log("Displaying masaPkwtGroup and tmtGroup for 'Karyawan Tidak Tetap'");
        masaPkwtGroup.style.display = "block";
        tmtGroup.style.display = "block";
    } else if (statusKepegawaian === "Karyawan Magang" || statusKepegawaian === "Karyawan Temporal" || statusKepegawaian === "Karyawan PKL") {
        console.log("Displaying tanggalMulaiGroup and tanggalSelesaiGroup for 'Karyawan Magang, Temporal, or PKL'");
        tanggalMulaiGroup.style.display = "block";
        tanggalSelesaiGroup.style.display = "block";
    }
}

// Initialize field visibility based on current value
document.addEventListener("DOMContentLoaded", updateFields);

function updateVisibility() {
    const statusText = document.getElementById("status_text").textContent.trim();

    console.log("Status:", statusText);  // Debugging: cek status

    const pasanganGroups = [
        document.getElementById("nama_pasangan_group"),
        document.getElementById("tempat_pasangan_group")
    ];

    const anakGroups = {
        TK1: ["nama_anak1_group", "tempat_anak1_group"],
        TK2: ["nama_anak1_group", "tempat_anak1_group", "nama_anak2_group", "tempat_anak2_group"],
        TK3: ["nama_anak1_group", "tempat_anak1_group", "nama_anak2_group", "tempat_anak2_group", "nama_anak3_group", "tempat_anak3_group"],
        K1: ["nama_anak1_group", "tempat_anak1_group"],
        K2: ["nama_anak1_group", "tempat_anak1_group", "nama_anak2_group", "tempat_anak2_group"],
        K3: ["nama_anak1_group", "tempat_anak1_group", "nama_anak2_group", "tempat_anak2_group", "nama_anak3_group", "tempat_anak3_group"],
    };

    pasanganGroups.forEach(group => group.style.display = "none");
    Object.values(anakGroups).flat().forEach(groupId => {
        const group = document.getElementById(groupId);
        if (group) {
            group.style.display = "none";
        }
    });

    if (statusText.startsWith("K") || !statusText.startsWith("TK")) {
        pasanganGroups.forEach(group => group.style.display = "block");
    }

    if (anakGroups[statusText]) {
        anakGroups[statusText].forEach(id => {
            const group = document.getElementById(id);
            if (group) {
                group.style.display = "block";
            }
        });
    }
}

document.addEventListener("DOMContentLoaded", () => {
    console.log("Document loaded");
    updateVisibility();
});

</script>


@stop

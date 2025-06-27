<div id="form-section">
    <!-- 2. Informasi Identitas -->
    <div class="form-section" id="section1">
        <h3>Informasi Identitas</h3>
        <div class="form-group">
            <label for="name">Nama</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control" 
                value="{{ old('name', isset($employee) ? $employee->name : '') }}" 
                {{ auth()->user()->role === 'Karyawan' && isset($employee) && $employee->name ? 'readonly' : '' }} 
                required>
        </div>

        <div class="form-group">
    <label for="nik">NIK Karyawan</label>
    <input type="text" name="nik" id="nik" class="form-control" 
        value="{{ old('nik', isset($employee) && $employee->nik ? Crypt::decryptString($employee->nik) : '') }}" 
        {{ auth()->user()->role === 'Karyawan' && isset($employee) && $employee->nik ? 'readonly' : '' }}>
    </div>
    <div class="form-group">
    <label for="nik_ktp">NIK KTP</label>
    <input 
        type="text" 
        name="nik_ktp" 
        id="nik_ktp" 
        class="form-control" 
        value="{{ old('nik_ktp', isset($employee) && $employee->nik_ktp ? Crypt::decryptString($employee->nik_ktp) : '') }}" 
        {{ auth()->user()->role === 'Karyawan' && isset($employee) && $employee->nik_ktp ? 'readonly' : '' }}
        pattern="\d+" 
        inputmode="numeric"
        title="NIK KTP harus berupa angka."
        onkeypress="return event.charCode >= 48 && event.charCode <= 57">
</div>
 <div class="form-group">
            <label for="alamat_ktp">Alamat KTP</label>
            <input type="text" name="alamat_ktp" id="alamat_ktp" class="form-control" value="{{ old('alamat_ktp', isset($employee) ? Crypt::decryptString($employee->alamat_ktp) : '') }}" {{ (auth()->user()->role === 'Karyawan' && isset($employee) && $employee->alamat_ktp) ? 'readonly' : '' }} required>
        </div>
        <div class="form-group">
            <label for="alamat_domisili">Alamat Domisili</label>
            <input type="text" name="alamat_domisili" id="alamat_domisili" class="form-control" value="{{ old('alamat_domisili', isset($employee) && $employee->alamat_domisili ? Crypt::decryptString($employee->alamat_domisili) : '') }}" {{ (auth()->user()->role === 'Karyawan' && isset($employee) && $employee->alamat_domisili) ? 'readonly' : '' }} required>
        </div>

    <div class="form-group">
        <label for="no_regkta">No REG KTA</label>
        <input type="text" name="no_regkta" id="no_regkta" class="form-control" 
            value="{{ old('no_regkta', isset($employee) && $employee->no_regkta ? Crypt::decryptString($employee->no_regkta) : '') }}" 
            {{ auth()->user()->role === 'Karyawan' && isset($employee) && $employee->no_regkta ? 'readonly' : '' }}>
    </div>
    <div class="form-group">
        <label for="no_npwp">No NPWP</label>
        <input type="text" name="no_npwp" id="no_npwp" class="form-control" 
            value="{{ old('no_npwp', isset($employee) && $employee->no_npwp ? Crypt::decryptString($employee->no_npwp) : '') }}" 
            {{ auth()->user()->role === 'Karyawan' && isset($employee) && $employee->no_npwp ? 'readonly' : '' }}>
    </div>
    <div class="form-group">
        <label for="bpjsket">No Kepesertaan BPJS Ketenagakerjaan</label>
        <input type="text" name="bpjsket" id="bpjsket" class="form-control" 
            value="{{ old('bpjsket', isset($employee) && $employee->bpjsket ? Crypt::decryptString($employee->bpjsket) : '') }}" 
            {{ auth()->user()->role === 'Karyawan' && isset($employee) && $employee->bpjsket ? 'readonly' : '' }}>
    </div>
    <div class="form-group">
        <label for="bpjskes">No Kepesertaan BPJS Kesehatan</label>
        <input type="text" name="bpjskes" id="bpjskes" class="form-control" 
            value="{{ old('bpjskes', isset($employee) && $employee->bpjskes ? Crypt::decryptString($employee->bpjskes) : '') }}" 
            {{ auth()->user()->role === 'Karyawan' && isset($employee) && $employee->bpjskes ? 'readonly' : '' }}>
    </div>

        <div class="form-group">
            <label for="tempat_lahir">Tempat Lahir</label>
            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" value="{{ old('tempat_lahir', isset($employee) ? $employee->tempat_lahir : '') }}" {{ auth()->user()->role === 'Karyawan' && isset($employee) && $employee->tempat_lahir ? 'readonly' : '' }} required>
        </div>

        <div class="form-group">
            <label for="ttl">Tanggal Lahir</label>
            <input type="date" name="ttl" id="ttl" class="form-control" value="{{ old('ttl', isset($employee) ? $employee->ttl : '') }}" {{ auth()->user()->role === 'Karyawan' && isset($employee) && $employee->ttl ? 'readonly' : '' }} required>
        </div>


    <!-- 3. Informasi Pekerjaan -->
<div class="form-section" id="section2">
    <h3>Informasi Pekerjaan</h3>

    <!-- Departemen -->
    <div class="form-group">
        <label for="departemen_id">Departemen</label>
        <select 
            name="departemen_id" 
            id="departemen_id" 
            class="form-control" 
            {{ (auth()->user()->role === 'Karyawan' && isset($employee) && $employee->departemen_id) ? 'readonly' : '' }} 
            required>
            <option value="">Pilih Departemen</option>
            @foreach($departemens as $departemen)
                <option value="{{ $departemen->id }}" 
                        {{ old('departemen_id', $employee->departemen_id ?? '') == $departemen->id ? 'selected' : '' }}>
                    {{ $departemen->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Jabatan -->
    <div class="form-group">
        <label for="jabatan_id">Jabatan</label>
        <select 
            name="jabatan_id" 
            id="jabatan_id" 
            class="form-control" 
            {{ (auth()->user()->role === 'Karyawan' && isset($employee) && $employee->jabatan_id) ? 'readonly' : '' }} 
            required>
            <option value="">Pilih Jabatan</option>
            @foreach($jabatans as $jabatan)
                <option value="{{ $jabatan->id }}" 
                        data-is-staff="{{ Str::contains(strtolower($jabatan->name), 'staff') ? 'true' : 'false' }}"
                        {{ old('jabatan_id', $employee->jabatan_id ?? '') == $jabatan->id ? 'selected' : '' }}>
                    {{ $jabatan->name }}
                </option>
            @endforeach
        </select>
    </div>
   <div class="form-group">
    <label for="pendidikan">Pendidikan</label>
    <select name="pendidikan" class="form-control"
         {{ (auth()->user()->role === 'Karyawan' && isset($employee) && $employee->pendidikan) ? 'readonly' : '' }}>
        <option value="">-- Semua pendidikan --</option>
        <option value="SD" {{ old('pendidikan', isset($employee) ? $employee->pendidikan : '') === 'SD' ? 'selected' : '' }}>SD</option>
        <option value="SMP" {{ old('pendidikan', isset($employee) ? $employee->pendidikan : '') === 'SMP' ? 'selected' : '' }}>SMP</option>
        <option value="SMA" {{ old('pendidikan', isset($employee) ? $employee->pendidikan : '') === 'SMA' ? 'selected' : '' }}>SMA</option>
        <option value="SLTP" {{ old('pendidikan', isset($employee) ? $employee->pendidikan : '') === 'SLTP' ? 'selected' : '' }}>SLTP</option>
        <option value="SMK" {{ old('pendidikan', isset($employee) ? $employee->pendidikan : '') === 'SMK' ? 'selected' : '' }}>SMK</option>
        <option value="D1" {{ old('pendidikan', isset($employee) ? $employee->pendidikan : '') === 'D!' ? 'selected' : '' }}>D1</option>
        <option value="D2" {{ old('pendidikan', isset($employee) ? $employee->pendidikan : '') === 'D2' ? 'selected' : '' }}>D2</option>
        <option value="D3" {{ old('pendidikan', isset($employee) ? $employee->pendidikan : '') === 'D3' ? 'selected' : '' }}>D3</option>
        <option value="S1" {{ old('pendidikan', isset($employee) ? $employee->pendidikan : '') === 'S!' ? 'selected' : '' }}>S1</option>
        <option value="S2" {{ old('pendidikan', isset($employee) ? $employee->pendidikan : '') === 'S2' ? 'selected' : '' }}>S2</option>
    </select>
</div>
    <!-- Sertifikasi -->
    <div class="form-group">
        <label for="sertifikasi">Sertifikasi</label>
        <div class="row">
            @for($i = 1; $i <= 3; $i++)
                <div class="col-md-4">
                    <select 
                        name="gada_id{{ $i }}" 
                        id="gada_id{{ $i }}" 
                        class="form-control" 
                        {{ (auth()->user()->role === 'Karyawan' && isset($employee->gadadetail[$i - 1])) ? 'readonly' : '' }}>
                        <option value="">Pilih Sertifikasi</option>
                        @foreach($gadas as $gada)
                            <option value="{{ $gada->id }}" 
                                    {{ old("gada_id{$i}", $employee->gadadetail[$i - 1]->gada_id ?? '') == $gada->id ? 'selected' : '' }}>
                                {{ $gada->name }}
                            </option>
                        @endforeach
                        <option value="other" {{ old("gada_id{$i}") == 'other' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    <input 
                        type="text" 
                        name="gada_id{{ $i }}_other_text" 
                        id="gada_id{{ $i }}_other_text" 
                        class="form-control mt-2" 
                        style="display: {{ old("gada_id{$i}") == 'other' ? 'block' : 'none' }};"
                        placeholder="Masukkan keterampilan lainnya" 
                        value="{{ old("gada_id{$i}_other_text") }}">
                </div>
            @endfor
        </div>
    </div>

    <!-- Lokasi Kerja -->
    <div class="form-group" id="lokasikerjaForm">
        <label for="lokasikerja">Lokasi Kerja</label>
        <select 
            name="lokasikerja" 
            id="lokasikerja" 
            class="form-control" 
            {{ (auth()->user()->role === 'Karyawan' && isset($employee) && $employee->lokasikerja) ? 'readonly' : '' }}>
            <option value="">Pilih Lokasi Kerja</option>
            @foreach($works as $work)
                <option value="{{ $work->name }}" 
                        {{ old('lokasikerja', $employee->lokasikerja ?? '') == $work->name ? 'selected' : '' }}>
                    {{ $work->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

    <!-- 4. Informasi Pribadi -->
    <div class="form-section" id="section3">
        <h3>Informasi Pribadi</h3>
        <div class="form-group">
            <label for="nama_ibu">Nama Ibu</label>
            <input type="text" name="nama_ibu" id="nama_ibu" class="form-control" value="{{ old('nama_ibu', isset($employee) ? Crypt::decryptString($employee->nama_ibu) : '') }}"   {{ (auth()->user()->role === 'Karyawan' && isset($employee) && $employee->nama_ibu) ? 'readonly' : '' }} required>
        </div>
        
       <div class="form-group" id="status_group">
    <label for="status">Status</label>
    <select name="status" class="form-control"
         {{ (auth()->user()->role === 'Karyawan' && isset($employee) && $employee->status) ? 'readonly' : '' }}>
        <option value="">-- Semua Status --</option>
        <option value="TK0" {{ old('status', isset($employee) ? $employee->status : '') === 'TK0' ? 'selected' : '' }}>TK 0</option>
        <option value="TK1" {{ old('status', isset($employee) ? $employee->status : '') === 'TK1' ? 'selected' : '' }}>TK 1</option>
        <option value="TK2" {{ old('status', isset($employee) ? $employee->status : '') === 'TK2' ? 'selected' : '' }}>TK 2</option>
        <option value="TK3" {{ old('status', isset($employee) ? $employee->status : '') === 'TK3' ? 'selected' : '' }}>TK 3</option>
        <option value="K0" {{ old('status', isset($employee) ? $employee->status : '') === 'K0' ? 'selected' : '' }}>K 0</option>
        <option value="K1" {{ old('status', isset($employee) ? $employee->status : '') === 'K1' ? 'selected' : '' }}>K 1</option>
        <option value="K2" {{ old('status', isset($employee) ? $employee->status : '') === 'K2' ? 'selected' : '' }}>K 2</option>
        <option value="K3" {{ old('status', isset($employee) ? $employee->status : '') === 'K3' ? 'selected' : '' }}>K 3</option>
    </select>
</div>
        @php
    function isReadonly($field, $employee) {
        return auth()->user()->role === 'Karyawan' && isset($employee) && $employee->$field ? 'readonly' : '';
    }
@endphp

<!-- Pasangan -->
<div class="form-group" id="nama_pasangan_group">
    <label for="nama_pasangan">Nama Istri/Suami</label>
    <input type="text" name="nama_pasangan" id="nama_pasangan" class="form-control" 
        value="{{ old('nama_pasangan', isset($employee) && $employee->nama_pasangan ? Crypt::decryptString($employee->nama_pasangan) : '') }}">
</div>

<div class="form-group" id="tempat_pasangan_group">
    <label for="tempatlahir_pasangan">Tempat Lahir Istri/Suami</label>
    <input type="text" name="tempatlahir_pasangan" id="tempatlahir_pasangan" class="form-control" 
        value="{{ old('tempatlahir_pasangan', isset($employee) ? $employee->tempatlahir_pasangan : '') }}" 
        {{ isReadonly('tempatlahir_pasangan', $employee) }} >
</div>

<div class="form-group" id="ttl_pasangan_group">
    <label for="ttl_pasangan">Tanggal Lahir Istri/Suami</label>
    <input type="date" name="ttl_pasangan" id="ttl_pasangan" class="form-control" 
        value="{{ old('ttl_pasangan', isset($employee) ? $employee->ttl_pasangan : '') }}" 
        {{ isReadonly('ttl_pasangan', $employee) }} >
</div>

<!-- Anak -->
@foreach (range(1, 3) as $i)
   <div class="form-group" id="nama_anak{{ $i }}_group">
    <label for="nama_anak{{ $i }}">Nama Anak {{ $i }}</label>
    <input type="text" name="nama_anak{{ $i }}" id="nama_anak{{ $i }}" class="form-control" 
        value="{{ old('nama_anak' . $i, isset($employee) && $employee->{'nama_anak' . $i} ? Crypt::decryptString(optional($employee)->{'nama_anak' . $i}) : '') }}" 
        {{ isReadonly('nama_anak' . $i, $employee) }} >
</div>

    <div class="form-group" id="tempat_anak{{ $i }}_group">
        <label for="tempatlahir_anak{{ $i }}">Tempat Lahir Anak {{ $i }}</label>
        <input type="text" name="tempatlahir_anak{{ $i }}" id="tempatlahir_anak{{ $i }}" class="form-control" 
            value="{{ old('tempatlahir_anak' . $i, isset($employee) ? $employee->{'tempatlahir_anak' . $i} : '') }}" 
            {{ isReadonly('tempatlahir_anak' . $i, $employee) }} >
    </div>
    <div class="form-group" id="ttl_anak{{ $i }}_group">
        <label for="ttl_anak{{ $i }}">Tanggal Lahir Anak {{ $i }}</label>
        <input type="date" name="ttl_anak{{ $i }}" id="ttl_anak{{ $i }}" class="form-control" 
            value="{{ old('ttl_anak' . $i, isset($employee) ? $employee->{'ttl_anak' . $i} : '') }}" 
            {{ isReadonly('ttl_anak' . $i, $employee) }} >
    </div>
@endforeach
    
       
    </div>

    <!-- 5. Informasi Kontak -->
    <div class="form-section" id="section4">
        <h3>Informasi Kontak</h3>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', isset($employee) ? $employee->email : '') }}"  {{ (auth()->user()->role === 'Karyawan' && isset($employee) && $employee->email) ? 'readonly' : '' }}  required>
        </div>
        <div class="form-group">
            <label for="telp">No Telepon</label>
            <input type="text" name="telp" id="telp" class="form-control" value="{{ old('telp', isset($employee) && $employee->telp ? Crypt::decryptString($employee->telp) : '') }}" {{ (auth()->user()->role === 'Karyawan' && isset($employee) && $employee->telp) ? 'readonly' : '' }} required>
        </div>
    </div>

    <!-- 6. Dokumen dan Sertifikat -->
    <div class="form-section" id="section5">
    <h3>Dokumen dan Sertifikat</h3>
 <div class="form-group">
        <label for="pict_diri">Foto Diri</label>
        <input type="file" name="pict_diri" id="pict_diri" class="form-control">
        @if(isset($employee) && $employee->pict_diri)
            <p><a href="{{ asset($employee->pict_diri) }}" target="_blank">Lihat Foto Diri</a></p>
        @elseif(!isset($employee))
            <p>Upload Foto Diri jika ada.</p>
        @else
            <p>Tidak ada foto Diri.</p>
        @endif
    </div>
    <div class="form-group">
        <label for="pict_ktp">Foto KTP</label>
        <input type="file" name="pict_ktp" id="pict_ktp" class="form-control">
        @if(isset($employee) && $employee->pict_ktp)
            <p><a href="{{ asset($employee->pict_ktp) }}" target="_blank">Lihat Foto KTP</a></p>
        @elseif(!isset($employee))
            <p>Upload Foto KTP jika ada.</p>
        @else
            <p>Tidak ada foto KTP.</p>
        @endif
    </div>
<div class="form-group">
        <label for="pict_kk">Foto KK</label>
        <input type="file" name="pict_kk" id="pict_ktp" class="form-control">
        @if(isset($employee) && $employee->pict_kk)
            <p><a href="{{ asset($employee->pict_kk) }}" target="_blank">Lihat Foto KK</a></p>
        @elseif(!isset($employee))
            <p>Upload Foto KK jika ada.</p>
        @else
            <p>Tidak ada foto KK.</p>
        @endif
    </div>
    <div class="form-group">
        <label for="pict_kta">Foto KTA</label>
        <input type="file" name="pict_kta" id="pict_kta" class="form-control">
        @if(isset($employee) && $employee->pict_kta)
            <p><a href="{{ asset($employee->pict_kta) }}" target="_blank">Lihat Foto KTA</a></p>
        @elseif(!isset($employee))
            <p>Upload Foto KTA jika ada.</p>
        @else
            <p>Tidak ada foto KTA.</p>
        @endif
    </div>

    <div class="form-group">
        <label for="pict_npwp">Foto NPWP</label>
        <input type="file" name="pict_npwp" id="pict_npwp" class="form-control">
        @if(isset($employee) && $employee->pict_npwp)
            <p><a href="{{ asset($employee->pict_npwp) }}" target="_blank">Lihat Foto NPWP</a></p>
        @elseif(!isset($employee))
            <p>Upload Foto NPWP jika ada.</p>
        @else
            <p>Tidak ada foto NPWP.</p>
        @endif
    </div>

    <div class="form-group">
        <label for="pict_bpjsket">Foto BPJS Ketenagakerjaan</label>
        <input type="file" name="pict_bpjsket" id="pict_bpjsket" class="form-control">
        @if(isset($employee) && $employee->pict_bpjsket)
            <p><a href="{{ asset($employee->pict_bpjsket) }}" target="_blank">Lihat Foto BPJS</a></p>
        @elseif(!isset($employee))
            <p>Upload Foto BPJS jika ada.</p>
        @else
            <p>Tidak ada foto BPJS.</p>
        @endif
    </div>
    
    <div class="form-group">
        <label for="pict_bpjskes">Foto BPJS Kesehatan</label>
        <input type="file" name="pict_bpjskes" id="pict_bpjskes" class="form-control">
        @if(isset($employee) && $employee->pict_bpjskes)
            <p><a href="{{ asset($employee->pict_bpjskes) }}" target="_blank">Lihat Foto BPJS</a></p>
        @elseif(!isset($employee))
            <p>Upload Foto BPJS jika ada.</p>
        @else
            <p>Tidak ada foto BPJS.</p>
        @endif
    </div>

    <div class="form-group">
        <label for="pict_ijasah">Foto Ijasah</label>
        <input type="file" name="pict_ijasah" id="pict_ijasah" class="form-control">
        @if(isset($employee) && $employee->pict_ijasah)
            <p><a href="{{ asset($employee->pict_ijasah) }}" target="_blank">Lihat Foto Ijasah</a></p>
        @elseif(!isset($employee))
            <p>Upload Foto Ijasah jika ada.</p>
        @else
            <p>Tidak ada foto Ijasah.</p>
        @endif
    </div>

     <div class="form-group">
    <label>Foto Sertifikat</label>
    <div class="row align-items-center">
        <!-- Elemen pertama tanpa nomor -->
        <div class="col-md-3">
            <input 
                type="file" 
                name="pict_sertifikat" 
                id="pict_sertifikat" 
                class="form-control"
            >
            @if(isset($employee) && $employee->pict_sertifikat)
                <small>
                    <a 
                        href="{{ asset($employee->pict_sertifikat) }}" 
                        target="_blank"
                    >
                        Lihat Sertifikat
                    </a>
                </small>
            @elseif(!isset($employee))
                <small>Upload Sertifikat jika ada.</small>
            @else
                <small>Tidak ada sertifikat.</small>
            @endif
        </div>

        <!-- Elemen berikutnya dengan nomor -->
        @for($i = 1; $i <= 3; $i++)
            <div class="col-md-3">
                <input 
                    type="file" 
                    name="pict_sertifikat{{ $i }}" 
                    id="pict_sertifikat{{ $i }}" 
                    class="form-control"
                >
                @if(isset($employee) && $employee->{"pict_sertifikat$i"})
                    <small>
                        <a 
                            href="{{ asset($employee->{"pict_sertifikat$i"}) }}" 
                            target="_blank"
                        >
                            Lihat Sertifikat {{ $i }}
                        </a>
                    </small>
                @elseif(!isset($employee))
                    <small>Upload Sertifikat {{ $i }} jika ada.</small>
                @else
                    <small>Tidak ada sertifikat.</small>
                @endif
            </div>
        @endfor
    </div>
</div>
<div class="form-group">
        <label for="pict_jobapp">Foto Lamaran Kerja</label>
        <input type="file" name="pict_jobapp" id="pict_jobapp" class="form-control">
        @if(isset($employee) && $employee->pict_jobapp)
            <p><a href="{{ asset($employee->pict_jobapp) }}" target="_blank">Lihat Foto Lamaran Kerja</a></p>
        @elseif(!isset($employee))
            <p>Upload Foto Lamaran Kerja jika ada.</p>
        @else
            <p>Tidak ada foto Lamaran Kerja.</p>
        @endif
    </div>



    @if(auth()->user()->role === 'Admin' || auth()->user()->role === 'Manager')
    <div class="form-section" id="section6">
        <h3>Informasi Tambahan</h3>
        <div class="form-group">
            <label for="keterangan">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control">{{ old('keterangan', isset($employee) ? $employee->keterangan : '') }}</textarea>
        </div>
      <div class="form-group">
            <label for="status_kepegawaian">Status Kepegawaian</label>
            <select name="status_kepegawaian" id="status_kepegawaian" class="form-control" onchange="updateFields()">
                <option value="">-- Semua Status Kepegawaian --</option>
                <option value="Karyawan Tetap" {{ old('status_kepegawaian', isset($employee) ? $employee->status_kepegawaian : '') === 'Karyawan Tetap' ? 'selected' : '' }}>Karyawan Tetap</option>
                <option value="Karyawan Tidak Tetap" {{ old('status_kepegawaian', isset($employee) ? $employee->status_kepegawaian : '') === 'Karyawan Tidak Tetap' ? 'selected' : '' }}>Karyawan Tidak Tetap</option>
                <option value="Karyawan Magang" {{ old('status_kepegawaian', isset($employee) ? $employee->status_kepegawaian : '') === 'Karyawan Magang' ? 'selected' : '' }}>Karyawan Magang</option>
                <option value="Karyawan Temporal" {{ old('status_kepegawaian', isset($employee) ? $employee->status_kepegawaian : '') === 'Karyawan Temporal' ? 'selected' : '' }}>Karyawan Temporal</option>
                <option value="Karyawan PKL" {{ old('status_kepegawaian', isset($employee) ? $employee->status_kepegawaian : '') === 'Karyawan PKL' ? 'selected' : '' }}>Karyawan PKL</option>
            </select>
        </div>
        
        <div class="form-group" id="masa_pkwt_group" >
            <label for="berlaku">Masa Berlaku PKWT</label>
            <input type="date" name="berlaku" id="berlaku" class="form-control" value="{{ old('berlaku', isset($employee) ? $employee->berlaku : '') }}">
        </div>
        <div class="form-group" id="tanggal_mulai_group" style = "display: none;">
            <label for="date_start">Tanggal Mulai</label>
            <input type="date" name="date_start" id="date_start" class="form-control" value="{{ old('date_start', isset($employee) ? $employee->date_start : '') }}">
        </div>
        <div class="form-group" id="tanggal_selesai_group">
            <label for="date_end">Tanggal Selesai</label>
            <input type="date" name="date_end" id="date_end" class="form-control" value="{{ old('date_end', isset($employee) ? $employee->date_end : '') }}">
        </div>
        <div class="form-group" id="tmt_group">
            <label for="tmt">TMT</label>
            <input type="date" name="tmt" id="tmt" class="form-control" value="{{ old('tmt', isset($employee) ? $employee->tmt : '') }}" >
        </div>
    </div>
    @endif
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Dropdown IDs for "Lainnya" feature
    const dropdownIds = ['gada_id1', 'gada_id2', 'gada_id3'];

    // Update "Lainnya" dropdown visibility and selection
    dropdownIds.forEach(function (id) {
        const selectElement = document.getElementById(id);
        const textElement = document.getElementById(`${id}_other_text`);

        selectElement.addEventListener('change', function () {
            if (this.value === 'other') {
                textElement.style.display = 'block';
            } else {
                textElement.style.display = 'none';
                textElement.value = ''; // Reset input value
            }
            updateDropdownOptions(); // Update options when selection changes
        });
    });

    function updateDropdownOptions() {
        const selectedValues = new Set(
            dropdownIds.map(id => document.getElementById(id).value).filter(value => value !== '' && value !== 'other')
        );

        dropdownIds.forEach(function (id) {
            const dropdown = document.getElementById(id);
            Array.from(dropdown.options).forEach(option => {
                if (selectedValues.has(option.value) && option.value !== dropdown.value) {
                    option.style.display = 'none'; // Hide option if already selected
                } else {
                    option.style.display = 'block'; // Show option otherwise
                }
            });
        });
    }

    // Initialize the dropdown options visibility
    updateDropdownOptions();

    // Restrict input to numbers for NIK/KTP
    const nikKtpInput = document.getElementById('nik_ktp');
    if (nikKtpInput) {
        nikKtpInput.addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
        });
    }
    // Update fields based on employee status
function updateFields() {
    const statusKepegawaian = document.getElementById("status_kepegawaian").value;
    const masaPkwtGroup = document.getElementById("masa_pkwt_group");
    const tanggalMulaiGroup = document.getElementById("tanggal_mulai_group");
    const tanggalSelesaiGroup = document.getElementById("tanggal_selesai_group");
    const tmtGroup = document.getElementById("tmt_group");
    const berlakuInput = document.getElementById("berlaku");
    const dateStartInput = document.getElementById("date_start");
    const dateEndInput = document.getElementById("date_end");
    const tmtInput = document.getElementById("tmt");
    // Default: Hide all groups
    masaPkwtGroup.style.display = "none";
    tanggalMulaiGroup.style.display = "none";
    tanggalSelesaiGroup.style.display = "none";
    tmtGroup.style.display = "none";
    
    berlakuInput.value = "";
    dateStartInput.value = "";
    dateEndInput.value = "";
    tmtInput.value = "";

    if (statusKepegawaian === "Karyawan Tetap") {
        tmtGroup.style.display = "block";
    } else if (statusKepegawaian === "Karyawan Tidak Tetap") {
        masaPkwtGroup.style.display = "block";
        tmtGroup.style.display = "block";
    } else if (statusKepegawaian === "Karyawan Magang" || statusKepegawaian === "Karyawan Temporal" || statusKepegawaian === "Karyawan PKL") {
        tanggalMulaiGroup.style.display = "block";
        tanggalSelesaiGroup.style.display = "block";
    }
}

// Attach event listener for status kepegawaian
const statusKepegawaianDropdown = document.getElementById('status_kepegawaian');
if (statusKepegawaianDropdown) {
    statusKepegawaianDropdown.addEventListener('change', updateFields);
}

// Update visibility of pasangan and anak fields based on selected status
const statusSelect = document.querySelector('select[name="status"]');
const pasanganGroups = [
    document.getElementById("nama_pasangan_group"),
    document.getElementById("tempat_pasangan_group"),
    document.getElementById("ttl_pasangan_group"),
];
const anakGroups = {
    TK1: ["nama_anak1_group", "tempat_anak1_group", "ttl_anak1_group"],
    TK2: ["nama_anak1_group", "tempat_anak1_group", "ttl_anak1_group", "nama_anak2_group", "tempat_anak2_group", "ttl_anak2_group"],
    TK3: ["nama_anak1_group", "tempat_anak1_group", "ttl_anak1_group", "nama_anak2_group", "tempat_anak2_group", "ttl_anak2_group", "nama_anak3_group", "tempat_anak3_group", "ttl_anak3_group"],
    K1: ["nama_anak1_group", "tempat_anak1_group", "ttl_anak1_group"],
    K2: ["nama_anak1_group", "tempat_anak1_group", "ttl_anak1_group", "nama_anak2_group", "tempat_anak2_group", "ttl_anak2_group"],
    K3: ["nama_anak1_group", "tempat_anak1_group", "ttl_anak1_group", "nama_anak2_group", "tempat_anak2_group", "ttl_anak2_group", "nama_anak3_group", "tempat_anak3_group", "ttl_anak3_group"],
};

function updateVisibility() {
    const selectedStatus = statusSelect.value;
    console.log("Selected Status:", selectedStatus); // Log selected status to browser console

    // Hide all pasangan groups
    pasanganGroups.forEach(group => group.style.display = "none");

    // Hide all anak groups
    Object.values(anakGroups).flat().forEach(groupId => {
        const group = document.getElementById(groupId);
        if (group) {
            group.style.display = "none";
        }
    });
 // If status is null, empty, or invalid, stop here
    if (!selectedStatus) {
        console.log("No valid status selected. All fields hidden.");
        return;
    }
    // Show pasangan groups if the status starts with "K"
    if (selectedStatus.startsWith("K") || !selectedStatus.startsWith("TK")) {
        pasanganGroups.forEach(group => group.style.display = "block");
    }

    // Show anak groups based on the selected status
    if (anakGroups[selectedStatus]) {
        console.log("Displaying groups for:", anakGroups[selectedStatus]); // Log groups to display
        anakGroups[selectedStatus].forEach(id => {
            const group = document.getElementById(id);
            if (group) {
                group.style.display = "block";
            }
        });
    }
}

// Initialize visibility on page load
updateVisibility();

// Attach event listener for status change
statusSelect.addEventListener("change", () => {
    console.log("Status changed to:", statusSelect.value);
    updateVisibility();
});

// Initialize field visibility based on current value
updateFields();

// Handle uppercase input for 'name' field based on user role
const nameInput = document.getElementById('name');
const userRole = "{{ auth()->user()->role }}"; // Get user role from server
if (userRole === 'Admin' || userRole === 'Manager') {
    nameInput.addEventListener('input', function () {
        this.value = this.value.toUpperCase(); // Convert input to uppercase
    });
}


});

</script>








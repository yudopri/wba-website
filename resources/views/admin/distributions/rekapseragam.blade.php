<h2>Daftar File Rekap Seragam</h2>
<ul>
@forelse($fileNames as $file)
    <li>
        <a href="{{ asset('assets/rekapseragam/' . $file) }}" target="_blank">{{ $file }}</a>
    </li>
@empty
    <li>Tidak ada file rekap.</li>
@endforelse
</ul>

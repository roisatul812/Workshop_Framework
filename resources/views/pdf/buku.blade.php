<h2>Data Buku</h2>

<p>
    Berikut adalah data buku terbaru yang tersedia pada sistem.
</p>

<p>
    Tanggal cetak : {{ date('d F Y') }}
</p>

<table border="1" width="100%" cellpadding="5">

    <tr>
        <th>No</th>
        <th>ID Buku</th>
        <th>Judul</th>
        <th>Pengarang</th>
        <th>Kategori</th>
    </tr>

    @foreach($data as $index => $b)

        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $b->id_buku }}</td>
            <td>{{ $b->judul }}</td>
            <td>{{ $b->pengarang }}</td>
            <td>{{ $b->kategori->nama_kategori ?? '-' }}</td>
        </tr>

    @endforeach

</table>
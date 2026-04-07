<h2>Data Kategori</h2>

<p>
    Berikut adalah data kategori terbaru yang tersedia pada sistem.
</p>

<p>
    Tanggal cetak : {{ date('d F Y') }}
</p>

<table border="1" width="100%" cellpadding="5">

    <tr>
        <th>ID</th>
        <th>Nama Kategori</th>
    </tr>

    @foreach($data as $index => $k)

        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $k->nama_kategori }}</td>
        </tr>

    @endforeach

</table>
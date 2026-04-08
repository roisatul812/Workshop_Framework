<!DOCTYPE html>
<html>

<head>

    <style>
        @page {
            margin-top: 4mm;
            margin-left: 4mm;
            margin-right: 4mm;
            margin-bottom: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        table {
            border-collapse: separate;
            border-spacing: 3mm 2mm;
        }

        td {
            width: 37.5mm;
            height: 17.8mm;
            border: 0.3mm solid #bbb;
            text-align: center;
            vertical-align: middle;
        }

        .nama {
            font-size: 9px;
            font-weight: bold;
        }

        .harga {
            font-size: 10px;
            color: red;
        }
    </style>

</head>

<body>

    <table>

        @php
            $i = 0;
        @endphp

        @foreach($labels as $label)

            @if($i % 5 == 0)
                <tr>
            @endif

                <td>
                    @if($label)

                        <div>
                            <img src="data:image/png;base64,{{ $label->barcode }}" style="height:18px;">
                        </div>

                        <div class="nama">
                            {{ $label->nama_barang }}
                        </div>

                        <div class="harga">
                            Rp {{ number_format($label->harga, 0, ',', '.') }}
                        </div>
                    @endif
                </td>

                @php $i++; @endphp

                @if($i % 5 == 0)
                    </tr>
                @endif

        @endforeach

    </table>

</body>

</html>
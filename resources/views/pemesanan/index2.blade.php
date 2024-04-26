@extends('template.layout')
@section('content')
    <section class="content">
        <main id="main" class="main">
            <div class="c">
                <div class="pagetitle">
                    <h1 style="font-family: arial; font-weight: bold;">Pemesanan</h1>
                </div>
                {{-- <form onsubmit="(e)=>{e.preventDefault()}" action="" method="post"> --}}
                @csrf
                <div class="container-fluid">
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <select class="form-select" onchange="changeJenis(this)" style="pointer: cursor">
                                @foreach ($jenis as $j)
                                    <option value="{{ strtolower($j->nama_jenis) }}">{{ $j->nama_jenis }}
                                    </option>
                                @endforeach
                            </select>
                            <ul class="menu-container">
                                @foreach ($jenis as $j)
                                    <div
                                        class="card jenis  {{ strtolower($j->nama_jenis) }} {{ $loop->index == 0 ? 'active' : 'hide' }}">
                                        <div style="background-color: rgb(20, 85, 189); color:white;" class="card-header">
                                            {{ $j->nama_jenis }}
                                        </div>
                                        <br>
                                        <br>
                                        <div class="menu-container-aw flex flex-wrap "
                                            style="display:flex;flex-wrap:wrap;gap:1rem">
                                            @foreach ($j->menu as $menu)
                                                <!-- Product List -->
                                                <br>
                                                <div class="col-md-3" style="">
                                                    <div class="card text-center"
                                                        style="background-color:beige;width:200px; height:250px; ">
                                                        <div>
                                                            <img class="mt-4 mx-auto d-block" width="50px"
                                                                src="{{ asset('images/' . $menu->image) }}">
                                                        </div>
                                                        <div class="h-100 d-flex flex-column pb-2 "
                                                            style="align-items:center">
                                                            <h5>{{ $menu->nama_menu }}</h5>
                                                            <p>Rp.{{ $menu->harga }}</p>
                                                            <button class="btn btn-success w-75"
                                                                style="margin-top:auto;">Add to
                                                                Cart</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            </div>
            <div class="item content" style="margin-top: 72px;">
                <!-- Card -->
                <div class="card" style="width: 400px; margin: auto;">
                    <div class="card-body">
                        <h5 class="card-title">Order</h5>
                        <ul class="ordered-list">
                            <!-- Daftar pesanan bisa dimasukkan di sini jika diperlukan -->
                        </ul>
                        <p class="card-text"
                            style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif; font-size: 15px;">
                            Total Bayar : <span id="total">0</span></p>
                        <div>
                            <button id="btn-bayar" class="btn btn-primary"
                                style="background-color: #007bff; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Bayar</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </form> --}}
            <!-- /.card-footer-->
            </div>
            <!-- /.card -->
        </main><!-- End #main -->
    </section>
@endsection

@push('script')
    <script>
        function changeJenis(e) {
            console.log(e.value)
            $('.jenis').removeClass('active')
            $('.jenis').addClass('hide')
            console.log($('.jenis.' + e.value))
            $('.jenis.' + e.value).removeClass('hide')
            $('.jenis.' + e.value).addClass('active')
        }
    </script>
@endpush
@push('style')
    <style>
        #jenis-filter {
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .ordered-item-container {
            display: flex;
            align-items: center;
        }

        .ordered-item-details {
            margin-left: 10px;
        }

        .ordered-item-image {
            width: 100px;
            /* Sesuaikan lebar gambar sesuai kebutuhan */
            height: auto;
            /* Biarkan tinggi gambar disesuaikan secara otomatis */
            border-radius: 5px;
            /* Berikan sudut yang melengkung pada gambar */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Tambahkan bayangan untuk efek ketinggian */
            margin-right: 10px;
            /* Jarak antara gambar dan teks detail */
        }


        .ordered-item-name {
            font-weight: bold;
        }

        .ordered-item-actions {
            margin-top: 10px;
        }

        .ordered-item-actions button {
            margin-right: 5px;
        }

        /* Stylizing Swal.fire dialog */
        .swal2-popup {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        .swal2-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }

        .swal2-content {
            font-size: 18px;
            color: #555;
        }

        .swal2-confirm,
        .swal2-deny {
            font-size: 16px;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .swal2-confirm {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        .swal2-confirm:hover {
            background-color: #0056b3;
        }

        .swal2-deny {
            background-color: #dc3545;
            color: #fff;
            border: none;
        }

        .swal2-deny:hover {
            background-color: #c82333;
        }

        .ordered-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .ordered-item-container {
            display: flex;
            align-items: center;
        }

        .ordered-item-image {
            width: 50px;
            margin-right: 10px;
        }

        .ordered-item-details {
            flex: 1;
        }

        .ordered-item-name {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
        }

        .ordered-item-price {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .ordered-item-actions {
            display: flex;
            align-items: center;
        }

        .qty-item {
            width: 40px;
            text-align: center;
            margin: 0 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        .subtotal {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }

        .remove-item,
        .btn-dec,
        .btn-inc {
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            padding: 5px 10px;
            margin-left: 5px;
        }

        .remove-item:hover,
        .btn-dec:hover,
        .btn-inc:hover {
            background-color: #c82333;
        }

        .pagetitle {
            text-align: center;
            /* Pusatkan teks */
            margin-bottom: 20px;
            /* Berikan ruang bawah */
        }

        .pagetitle h1 {
            font-size: 36px;
            /* Ukuran font yang lebih besar */
            color: #333;
            /* Warna teks */
            text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.1);
            /* Bayangan teks */
        }

        /* Style untuk item menu */
        .menu-item li {
            cursor: pointer;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .menu-item li:hover {
            background-color: #f0f0f0;
        }

        /* Style untuk tombol hapus dan tombol kuantitas */
        .btn-dec,
        .btn-inc {
            background-color: #bebe4f;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            padding: 5px 10px;
            margin-left: 5px;
            transition: all 0.3s ease;
        }

        .remove-item {
            background-color: #7b00ff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            padding: 5px 10px;
            margin-left: 5px;
            transition: all 0.3s ease;
        }

        .btn-dec:hover,
        .btn-inc:hover {
            background-color: #c82333;
        }

        /* Style untuk subtotal */
        .subtotal {
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            margin-left: 10px;
        }

        /* Style untuk input kuantitas */
        .qty-item {
            width: 50px;
            text-align: center;
            margin: 0 5px;
        }

        .main {
            display: flex;
            gap: 2rem;
        }

        .c {
            width: 700px;
            display: flex;
            flex-direction: column;
        }

        .container {
            border: 2px solid rgb(9, 3, 4);
            border-radius: 10px;
            /* Menambahkan sedikit efek rounded pada border */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Menambahkan bayangan */
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 20px;
            transition: box-shadow 0.3s;
            /* Efek transisi untuk bayangan */
        }

        .container:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            /* Meningkatkan bayangan saat hover */
        }



        .item-content {
            width: 400px;
        }

        .menu-container {
            padding: 0px;
            list-style-type: none;
        }

        .menu-container li h3 {
            text-transform: uppercase;
            font-weight: bold;
            font-size: 20px;
            /* Menyesuaikan ukuran font */
            background-color: aliceblue;
            padding: 10px 20px;
            /* Menyesuaikan padding */
            margin: 5px 0;
            /* Menambahkan margin atas dan bawah */
            border-radius: 5px;
            /* Memberikan sedikit efek rounded */
            transition: background-color 0.3s;
            /* Efek transisi ketika hover */
        }

        .menu-container li h3:hover {
            background-color: lightblue;
            /* Mengubah warna latar belakang saat hover */
        }

        .card-title {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 25px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
            text-transform: uppercase;
            border-bottom: 2px solid #d0c258;
            padding-bottom: 10px;
        }



        .menu-item {
            list-style-type: none;
            display: flex;
            gap: 1em;
        }

        .menu-item li {
            display: flex;
            flex-direction: column;
            padding: 10px 20px;

        }

        .item.content {
            text-align: center;
            /* Pusatkan konten */
            margin-top: 72px;
        }

        .card {
            width: 400px;
            margin: auto;
            background-color: #f9f9f9;
            /* Warna latar belakang */
            border-radius: 10px;
            /* Efek rounded pada card */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Bayangan */
            transition: box-shadow 0.3s;
            /* Efek transisi saat hover */
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            /* Meningkatkan bayangan saat hover */
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 24px;
            /* Ukuran font yang lebih besar */
            color: #333;
            /* Warna teks */
            margin-bottom: 15px;
            /* Ruang bawah */
        }

        .ordered-list {
            list-style: none;
            /* Menghapus bullet points */
            padding: 0;
        }

        .card-text {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 15px;
            margin-bottom: 10px;
            /* Tambahkan margin bawah */
        }

        .total-container {
            display: flex;
            justify-content: space-between;
            /* Ratakan ke kanan */
            align-items: center;
            /* Pusatkan vertikal */
            border-top: 1px solid #ccc;
            /* Garis atas */
            padding-top: 10px;
            /* Padding atas */
        }

        #total {
            font-weight: bold;
            /* Teks tebal */
            font-size: 18px;
            /* Ukuran teks */
            color: #333;
            /* Warna teks */
        }

        #btn-bayar {
            background-color: #b6c557;
            /* Warna latar belakang */
            color: #fff;
            /* Warna teks */
            border: none;
            /* Tanpa border */
            padding: 10px 20px;
            /* Padding */
            border-radius: 5px;
            /* Sudut bulat */
            cursor: pointer;
            /* Kursor tangan saat dihover */
            transition: background-color 0.3s;
            /* Efek transisi */
        }

        #btn-bayar:hover {
            background-color: #0056b3;
            /* Warna latar belakang saat dihover */
        }
    </style>
@endpush

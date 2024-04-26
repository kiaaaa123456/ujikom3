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
                <div class="container">
                    <div class="item">
                        <select id="jenis-filter" class="col-md-12 mb-2">
                            <option value="">Semua Jenis</option>
                            @foreach ($jenis as $j)
                                <option value="{{ $j->id }}">{{ $j->nama_jenis }}</option>
                            @endforeach
                        </select>
                        <ul class="menu-container">
                            @foreach ($jenis as $j)
                                <li class="jenis-menu" data-jenis="{{ $j->id }}">
                                    <h3>{{ $j->nama_jenis }}</h3>
                                    <ul class="menu-item" style="cursor: pointer;">
                                        @foreach ($j->menu as $menu)
                                            <li style="{{ $menu->stok->first()->jumlah < 1 ? 'pointer-events: none; opacity: .8' : '' }}"
                                                data-harga="{{ $menu->harga }}"data-id="{{ $menu->id }}"
                                                data-image="{{ $menu->image }}">
                                                <img width="50" src="{{ asset('images') }}/{{ $menu->image }}"
                                                    alt="">
                                                <div style="font-family: calibri;">
                                                    Nama : {{ $menu->nama_menu }}<br>
                                                    Stok : {{ $menu->stok->jumlah }}<br>
                                                    Deskripsi : {{ $menu->deskripsi }}
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
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
        $(function() {
            // Inisialisasi
            const orderedList = [];
            let total = 0;

            const sum = () => {
                return orderedList.reduce((accumulator, object) => {
                    return accumulator + (object.harga * object.qty);
                }, 0);
            };

            const changeQty = (el, inc) => {
                // Ubah di array
                const id = $(el).closest('li')[0].dataset.id;
                const index = orderedList.findIndex(list => list.menu_id == id);
                orderedList[index].qty += orderedList[index].qty == 1 && inc == -1 ? 0 : inc;

                // Ubah qty dan ubah subtotal
                const txt_subtotal = $(el).closest('li').find('.subtotal')[0];
                const txt_qty = $(el).closest('li').find('.qty-item')[0];
                txt_qty.value = parseInt(txt_qty.value) == 1 && inc == -1 ? 1 : parseInt(txt_qty.value) + inc;
                txt_subtotal.innerHTML = orderedList[index].harga * orderedList[index].qty;

                // Ubah jumlah total
                $('#total').html(sum());
            };

            // Events
            $('.ordered-list').on('click', '.btn-dec', function() {
                changeQty(this, -1);
            });

            $('.ordered-list').on('click', '.btn-inc', function() {
                changeQty(this, 1);
            });

            $('.ordered-list').on('click', '.remove-item', function() {
                const item = $(this).closest('li')[0];
                let index = orderedList.findIndex(list => list.id == parseInt(item.dataset.id));
                orderedList.splice(index, 1);
                $(this).closest('li').remove();
                $('#total').html(sum());
            });

            $('#jenis-filter').on('change', function() {
                const selectedJenis = $(this).val();
                if (selectedJenis) {
                    $('.jenis-menu').hide(); // sembunyikan semua jenis makanan
                    $(`.jenis-menu[data-jenis="${selectedJenis}"]`).show(); // tampilkan jenis yang dipilih
                } else {
                    $('.jenis-menu').show(); // jika pilihan kosong, tampilkan semua jenis makanan
                }
            });


            $('#btn-bayar').on('click', function() {
                $.ajax({
                    url: "{{ route('transaksi.store') }}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "orderedList": orderedList,
                        "total": sum()
                    },
                    success: function(data) {
                        console.log(data)
                        if (data.status) {
                            Swal.fire({
                                title: data.message,
                                showDenyButton: true,
                                confirmButtonText: "Cetak Nota",
                                denyButtonText: `OK`,
                                showCloseButton: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.open("{{ url('nota') }}/" + data.notrans);
                                    location.reload();
                                } else if (result.isDenied) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire('Pemesanan Gagal!', '', 'error');
                        }
                    },
                    error: function(request, status, error) {
                        console.log(request.responseText);
                        Swal.fire('Pemesanan Gagal!', '', 'error');
                    }
                });
            });

            $(".menu-item li").click(function() {
                // Mengambil data
                const menu_clicked = $(this).text();
                const data = $(this)[0].dataset;
                const harga = parseFloat(data.harga);
                const id = parseInt(data.id);
                const imageUrl = $(this).find('img').attr('src'); // Ambil URL gambar

                if (orderedList.every(list => list.id !== id)) {
                    let dataN = {
                        'menu_id': id, // Menggunakan kunci 'menu_id' di sini
                        'menu': menu_clicked,
                        'harga': harga,
                        'qty': 1,
                        'image': imageUrl // Simpan URL gambar dalam orderedList
                    };
                    orderedList.push(dataN);
                    let listOrder = `<li data-id="${id}" class="ordered-item">`;
                    listOrder += `<div class="ordered-item-container">`;
                    listOrder +=
                        `<img src="${imageUrl}" alt="${menu_clicked}" class="ordered-item-image">`; // Tampilkan gambar
                    listOrder += `<div class="ordered-item-details">`;
                    listOrder += `<h3 class="ordered-item-name">${menu_clicked}</h3>`;
                    listOrder += `<p class="ordered-item-price">Harga: Rp. ${harga}</p>`;
                    listOrder += `<div class="ordered-item-actions">`;
                    listOrder += `<button class='remove-item'>hapus</button>`;
                    listOrder += `<button class="btn-dec">-</button>`;
                    listOrder += `<input class="qty-item" type="number" value="1" readonly>`;
                    listOrder += `<button class="btn-inc">+</button>`;
                    listOrder += `</div></div></div>`;
                    listOrder += `<h2 class="subtotal">${harga * 1}</h2>`;
                    listOrder += `</li>`;
                    $('.ordered-list').append(listOrder);

                    // Nonaktifkan event click setelah ditambahkan ke ordered list
                    $(this).off('click');
                }
                $('#total').html(sum());
            });


        });
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

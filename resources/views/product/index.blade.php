@extends('template.layout')

@push('style')
@endpush
@section('content')
    <div id="main" class='layout-navbar'>
        <header class='mb-3'>
            <nav class="navbar navbar-expand navbar-light navbar-top">
                <div class="container-fluid">
                    <a href="#" class="burger-btn d-block">
                        <i class="bi bi-justify fs-3"></i>
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-lg-0">
                        </ul>
                        <div class="dropdown">
                            <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-menu d-flex">
                                    <div class="user-name text-end me-3">
                                        <h6 class="mb-0 text-gray-600">D I N O</h6>
                                        <p class="mb-0 text-sm text-gray-600">Administrator</p>
                                    </div>
                                    <div class="user-img d-flex align-items-center">
                                        <div class="avatar avatar-md">
                                            <img src="{{ asset('mazer') }}/assets/images/faces/1.jpg">
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton"
                                style="min-width: 11rem;">
                                <li>
                                    <h6 class="dropdown-header">Hello, Sann!</h6>
                                </li>
                                <hr class="dropdown-divider">
                                <li>
                                    <a class="dropdown-item" href="#"><i
                                            class="icon-mid bi bi-box-arrow-left me-2"></i>
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        <div id="main-content">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>DATA PRODUCT</h3>
                    </div>
                    <div class="col-12 col-md-6 order-md-2 order-first">
                        <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Layout Vertical Navbar
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <h4 class="card-title">Data Produk Titipan</h4>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#modalFormProduct">
                            <i class="bi bi-plus"></i>Tambah
                        </button>
                        <a href="{{ url('pdfproduct') }}" target="_blank" class="btn btn-danger">
                            <i class="bi bi-file-pdf"></i>PDF
                        </a>
                        <a href="{{ route('exportproduct') }}" class="btn btn-success">
                            <i class="bi bi-file-excel"></i>Export
                        </a>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#formImport">
                            <i class="bi bi-cloud-upload"></i>Import
                        </button>

                        <div class="mt-3">
                            @include('product.data')
                        </div>
                    </div>
                </div>
                @include('product.form')
            </section>
        @endsection

        @push('script')
            <script>
                $('#tbl-jenis').DataTable()
                $('.alert-success').fadeTo(2000, 500).slideUp(500, function() {
                    $('.alert-success').slideUp(500)
                })
                $('.alert-danger').fadeTo(2000, 500).slideUp(500, function() {
                    $('.alert-danger').slideUp(500)
                })
                console.log($('.delete-data'))
                $('.delete-data').on('click', function(e) {
                    e.preventDefault()
                    const data = $(this).closest('tr').find('td:eq(1)').text()
                    Swal.fire({
                        title: `Apakah data <span style="color:red">${data}</span> akan dihapus?`,
                        text: "Data tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus data ini!'
                    }).then((result) => {
                        if (result.isConfirmed)
                            $(e.target).closest('form').submit()
                        else swal.close()
                    })
                })


                $(document).ready(function() {
                    // Fungsi untuk menghitung harga jual otomatis saat input harga beli diubah
                    $('#harga_beli').on('input', function() {
                        var hargaBeli = $(this).val();
                        var keuntungan = hargaBeli * 1.7;
                        var hargaJual = Math.ceil(keuntungan / 500) * 500;
                        $('#harga_jual').val(hargaJual);
                    });

                    // Fungsi untuk menangani logika modal
                    $('#modalFormProduct').on('show.bs.modal', function(e) {
                        const btn = $(e.relatedTarget);
                        const mode = btn.data('mode');
                        const nama_produk = btn.data('nama_produk');
                        const nama_suplier = btn.data('nama_suplier');
                        const harga_beli = btn.data('harga_beli');
                        const harga_jual = btn.data('harga_jual');
                        const stok = btn.data('stok');
                        const keterangan = btn.data('keterangan');
                        const id = btn.data('id');
                        const modal = $(this);

                        if (mode === 'edit') {
                            modal.find('.modal-title').text('Edit Data Product');
                            modal.find('#nama_produk').val(nama_produk);
                            modal.find('#nama_suplier').val(nama_suplier);
                            modal.find('#harga_beli').val(harga_beli);
                            modal.find('#harga_jual').val(harga_jual);
                            modal.find('#stok').val(stok);
                            modal.find('#keterangan').val(keterangan);
                            modal.find('.modal-body form').attr('action', '{{ url('produk-titipan') }}/' + id);
                            modal.find('#method').html('@method('PATCH')');
                        } else {
                            modal.find('.modal-title').text('Input Data Product');
                            modal.find('#nama_produk').val('');
                            modal.find('#nama_suplier').val('');
                            modal.find('#harga_beli').val('');
                            modal.find('#harga_jual').val('');
                            modal.find('#stok').val('');
                            modal.find('#keterangan').val('');
                            modal.find('#method').html('');
                            modal.find('.modal-body form').attr('action', '{{ url('produk-titipan') }}');
                        }
                    });
                });
            </script>
        @endpush

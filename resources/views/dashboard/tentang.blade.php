@extends('template.layout')
@push('style')
    <style>
        /* Gaya untuk navbar menu */
        .navbar-menu {
            background-color: #007bff;
            padding: 10px 0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .navbar-menu .nav-item {
            list-style: none;
            display: inline-block;
            margin-right: 20px;
        }

        .navbar-menu .nav-item:last-child {
            margin-right: 0;
        }

        .navbar-menu .nav-link {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .navbar-menu .nav-link:hover {
            color: #f8f9fa;
        }

        /* Gaya untuk konten utama */
        .page-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            /* Tambahkan margin atas agar terpisah dari menu */
        }

        .page-content h4 {
            color: #333;
            margin-top: 0;
            margin-bottom: 20px;
        }

        .page-content p {
            color: #666;
            line-height: 1.6;
        }

        /* Gaya untuk tombol burger pada tampilan mobile */
        .burger-btn {
            color: #333;
            cursor: pointer;
        }

        /* Gaya untuk tombol kembali ke atas */
        .back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            display: none;
            /* Sembunyikan tombol secara default */
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .back-to-top:hover {
            opacity: 0.8;
        }

        /* Gaya untuk konten pada tampilan mobile */
        @media (max-width: 768px) {
            .navbar-menu {
                padding: 5px 0;
            }

            .navbar-menu .nav-item {
                display: block;
                margin: 10px 0;
            }

            .navbar-menu .nav-item:last-child {
                margin-bottom: 0;
            }

            .page-content {
                padding: 10px;
            }
        }
    </style>
@endpush
@section('content')
    <div id="main">
        <header class="mb-3">
            <nav class="navbar-menu">
                <ul class="nav">
                    <li class="nav-item"><a class="nav-link" href="#tentang">Tentang Aplikasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#layanan">Layanan Aplikasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#sejarah">Sejarah Pembuatan</a></li>
                </ul>
            </nav>
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="row">
            <div class="col-md-12">
                <div id="tentang" class="page-content mb-4">
                    <h4>Tentang Aplikasi</h4>
                    <p>
                        Aplikasi kasir merupakan sebuah perangkat lunak yang dirancang untuk membantu pengelolaan
                        transaksi pembelian dan penjualan di berbagai jenis bisnis. Aplikasi ini dapat digunakan untuk
                        menghitung total belanja, mencetak struk pembayaran, mengelola inventaris, serta melacak
                        penjualan.
                    </p>
                </div>
                <div id="layanan" class="page-content mb-4">
                    <h4>Layanan Aplikasi</h4>
                    <p>
                        Aplikasi kami menyediakan layanan lengkap untuk memenuhi kebutuhan pengelolaan toko atau bisnis
                        Anda. Mulai dari manajemen inventaris hingga laporan penjualan, semua dapat diakses dengan mudah
                        dan cepat melalui aplikasi kami.
                    </p>
                </div>
                <div id="sejarah" class="page-content">
                    <h4>Sejarah Pembuatan</h4>
                    <p>
                        Aplikasi kasir kami telah dikembangkan dengan dedikasi dan keahlian oleh tim kami selama
                        bertahun-tahun. Kami terus melakukan pembaruan dan peningkatan berdasarkan umpan balik pengguna
                        untuk memastikan aplikasi kami tetap menjadi solusi terbaik dalam mengelola bisnis Anda.
                    </p>
                </div>
            </div>
        </div>
        <!-- Tombol Kembali ke Atas -->
        <a href="#" class="back-to-top" id="backToTop">Kembali ke Atas</a>
    </div>
@endsection

@push('scripts')
    <script>
        // Script untuk menampilkan tombol kembali ke atas saat halaman di-scroll
        window.addEventListener('scroll', function() {
            var backToTopButton = document.getElementById('backToTop');
            if (window.pageYOffset > 100) {
                // Jika halaman di-scroll lebih dari 100px, tampilkan tombol kembali ke atas
                backToTopButton.style.display = 'block';
            } else {
                // Jika tidak, sembunyikan tombol kembali ke atas
                backToTopButton.style.display = 'none';
            }
        });

        // Script untuk menangani klik tombol burger pada tampilan mobile
        document.querySelector('.burger-btn').addEventListener('click', function() {
            document.querySelector('.menu-sidebar').classList.toggle('show');
        });

        // Script untuk menangani klik tombol kembali ke atas
        document.getElementById('backToTop').addEventListener('click', function(e) {
            e.preventDefault(); // Mencegah aksi default dari link
            window.scrollTo({
                top: 0, // Gulir ke atas halaman
                behavior: 'smooth' // Gulir halus
            });
        });
    </script>
@endpush

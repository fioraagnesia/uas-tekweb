<?php
// Menghubungkan koneksi database yang sudah ada
include('koneksi.php');

// Fungsi untuk mencari produk berdasarkan kode barang
function cariProduk($kode_barang) {
    global $conn;

    // Query untuk mengambil produk berdasarkan kode_barang
    $query = "SELECT p.id_barang, p.kode_barang, u.ukuran, p.harga, dp.id_detprod 
              FROM produk p
              JOIN detail_produk dp ON p.id_barang = dp.id_barang
              JOIN ukuran u ON dp.id_ukuran = u.id_ukuran
              WHERE p.kode_barang = ? AND dp.status_aktif = 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $kode_barang);
    $stmt->execute();
    $result = $stmt->get_result();

    $produk = [];
    while ($row = $result->fetch_assoc()) {
        $produk[] = $row; // Menyimpan produk yang ditemukan dalam array
    }
    $stmt->close();
    return $produk;
}

// Fungsi untuk mengecek ketersediaan stok gudang berdasarkan id_detprod
function cekStokGudang($id_detprod) {
    global $conn;
    $query = "SELECT stok_gudang FROM detail_produk WHERE id_detprod = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_detprod);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['stok_gudang'];
    } else {
        return 0; // Tidak ditemukan
    }
}

// Fungsi untuk memindahkan stok dari gudang ke toko
// Fungsi untuk memindahkan stok dari gudang ke toko
function pindah_stokGudang($id_detprod, $jumlah) {
    global $conn;

    // Cek stok gudang sebelum dipindahkan
    $stok_gudang = cekStokGudang($id_detprod);
    if ($stok_gudang >= $jumlah) {
        // Kurangi stok dari gudang
        $query_update_gudang = "UPDATE detail_produk SET stok_gudang = stok_gudang - ? WHERE id_detprod = ?";
        $stmt = $conn->prepare($query_update_gudang);
        $stmt->bind_param("ii", $jumlah, $id_detprod);
        $stmt->execute();
        $stmt->close();

        // Tambahkan stok ke toko
        $query_update_toko = "UPDATE detail_produk SET stok_toko = stok_toko + ? WHERE id_detprod = ?";
        $stmt = $conn->prepare($query_update_toko);
        $stmt->bind_param("ii", $jumlah, $id_detprod);
        $stmt->execute();
        $stmt->close();

        // Simpan transaksi ke laporanTransaksi
        $status_in_out = 'Out';  // Karena stok dipindahkan dari gudang (out)
        $tanggal_in_out = date('Y-m-d H:i:s');  // Waktu saat transaksi dilakukan

        // Query untuk menyimpan transaksi
        $query_laporan = "INSERT INTO detail_laporan (id_detprod, quantity, status_in_out, tanggal_in_out) 
                          VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query_laporan);
        $stmt->bind_param("iiss", $id_detprod, $jumlah, $status_in_out, $tanggal_in_out);
        $stmt->execute();
        $stmt->close();

        return true; // Stok berhasil dipindahkan dan laporan dibuat
    } else {
        return false; // Stok gudang tidak cukup
    }
}


// Proses jika form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_detprod']) && isset($_POST['jumlah'])) {
        $id_detprod = $_POST['id_detprod']; // Mendapatkan id_detprod yang dipilih
        $jumlah = $_POST['jumlah'];

        // Pindahkan stok
        $berhasil = pindah_stokGudang($id_detprod, $jumlah);

        // Menampilkan notifikasi
        if ($berhasil) {
            echo "<div class='notification success'>Stok telah berhasil dipindahkan ke toko.</div>";
        } else {
            echo "<div class='notification error'>Stok gudang tidak cukup untuk dipindahkan.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memindah Stok Barang ke Toko</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 14px;
            background-color: #007bff; /* Warna Biru */
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3; /* Warna Biru Tua saat hover */
        }

        .notification {
            padding: 15px;
            margin-top: 20px;
            text-align: center;
            border-radius: 6px;
            font-size: 16px;
        }

        .notification.success {
            background-color: #4CAF50;
            color: #fff;
        }

        .notification.error {
            background-color: #f44336;
            color: #fff;
        }

        select {
            font-size: 16px;
        }

        .form-group input[type="number"] {
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
        }
        footer {
            background-color: #332D2D; /* Warna latar belakang footer */
            color: white; /* Warna teks footer */
            margin-top: auto; /* Membuat footer menempel di bawah */
            padding: 20px 0;
            width: 100%;
        }
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            width: 100%;
            margin: 0;
            padding: 0;
            background-color: #343a40;
        }

        .navbar .container-fluid {
            max-width: 100%;
            padding: 0;
        }

        .navbar-brand {
            color: white;
            font-size: 1.5rem;
        }

        .navbar-nav {
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        .navbar-nav .nav-item {
            list-style: none;
        }

        .navbar-nav .nav-item .nav-link {
            color: white;
            padding: 15px 20px;
            display: block;
            text-align: center;
        }

        .navbar-nav .nav-item .nav-link:hover {
            background-color: #007bff;
            border-radius: 5px;
        }

        .dropdown-menu {
            left: 0;
            right: auto;
        }

        .dropdown-submenu {
            position: relative;
        }

        .dropdown-submenu .dropdown-menu {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
        }

        .dropdown-submenu:hover .dropdown-menu {
            display: block;
        }

        .dropdown-item {
            color: #333;
            padding: 10px 20px;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        .navbar-nav .nav-item .nav-link[href="loginPage.php"]:hover {
        background-color: red;
        border-radius: 5px; /* Opsional, untuk konsistensi dengan hover lainnya */
        }

      @media (min-width: 992px) {
          .dropdown-submenu:hover .dropdown-menu {
              display: block;
          }
      }

      .dropdown-submenu.show .dropdown-menu {
          display: block;
      }

      @media (max-width: 991px) {
          .dropdown-menu .show {
              display: block !important;
          }

          .dropdown-submenu .dropdown-menu {
              position: relative;
              left: 0;
              top: 0;
              margin-left: 1rem;
          }
      }

       .navbar-toggler-icon {
        background-image: none;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 24px;
        position: relative;
    }
    .navbar-toggler-icon::before,
    .navbar-toggler-icon::after,
    .navbar-toggler-icon div {
        content: '';
        background-color: white; /* Warna garis putih */
        width: 100%;
        height: 3px;
        position: absolute;
        left: 0;
    }
    .navbar-toggler-icon::before {
        top: 0;
    }
    .navbar-toggler-icon div {
        top: 50%;
        transform: translateY(-50%);
    }
    .navbar-toggler-icon::after {
        bottom: 0;
    }

    </style>
      <script>
      document.addEventListener('DOMContentLoaded', function () {
          document.querySelectorAll('.dropdown-submenu > a').forEach(function (dropdownToggle) {
              dropdownToggle.addEventListener('click', function (e) {
                  var submenu = this.nextElementSibling;
                  if (submenu) {
                      submenu.classList.toggle('show');
                  }
                  e.preventDefault();
                  e.stopPropagation(); // Mencegah penutupan dropdown utama
              });
          });

          // Menutup dropdown saat klik di luar
          document.addEventListener('click', function (e) {
              document.querySelectorAll('.dropdown-menu .show').forEach(function (openSubmenu) {
                  openSubmenu.classList.remove('show');
              });
          });
      });
  </script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">
          <img src="/img/logomuse.jpg" style="height: 50px; width: auto;"> MUSE COLLECTION
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon">
            <div></div>
          </span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="dashboard.php"><i class="fas fa-home"></i> Home</a></li>
                <li class="nav-item"><a class="nav-link" href="menambahProdukBaru.php"><i class="fas fa-box"></i> Produk</a></li>
                <li class="nav-item"><a class="nav-link" href="pageHarga.php"><i class="fas fa-tags"></i> Harga</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-store-alt"></i> Stok
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="pageStokToko.php">Toko</a></li>
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle" href="#">Gudang</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="lihatStokHargaBarangGudang.php">Lihat Stok</a></li>
                                <li><a class="dropdown-item" href="tambahStokGudang.php">Tambah Stok</a></li>
                                <li><a class="dropdown-item" href="pindah_stokGudang.php">Pindah Stok</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="halamanTransaksi.php"><i class="fas fa-exchange-alt"></i> Transaksi</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-users"></i> Karyawan</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="absensi.php">Absensi</a></li>
                        <li><a class="dropdown-item" href="perhitunganGaji.php">Perhitungan Gaji</a></li>
                        <li><a class="dropdown-item" href="MelihatAbsensiPage.php">List Absensi</a></li>
                        <li><a class="dropdown-item" href="pageKaryawan.php">Manajemen Karyawan</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-file-alt"></i> Laporan</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="pageLaporan.php">Transaksi</a></li>
                        <li><a class="dropdown-item" href="membuatLaporanStok.php">Stok Gudang</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="loginPage.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </li>
            </ul>
        </div>
    </div>
  </nav>
    <h1>Memindah Stok Barang ke Toko</h1>

    <div class="container">
        <!-- Form untuk memasukkan kode barang -->
        <form method="POST" action="pindah_stokGudang.php">
            <div class="form-group">
                <label for="kode_barang">Kode Barang:</label>
                <input type="text" id="kode_barang" name="kode_barang" value="<?php echo isset($_POST['kode_barang']) ? htmlspecialchars($_POST['kode_barang']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Cari Produk">
            </div>
        </form>

        <?php
        // Cek apakah kode_barang telah di-submit
        if (isset($_POST['kode_barang'])) {
            $kode_barang = $_POST['kode_barang'];

            // Cari produk berdasarkan kode_barang
            $produk_list = cariProduk($kode_barang);

            if (count($produk_list) > 0) {
                echo '<form method="POST" action="pindah_stokGudang.php">';
                echo '<div class="form-group">';
                echo '<label for="id_detprod">Pilih Produk:</label>';
                echo '<select name="id_detprod" required>';
                foreach ($produk_list as $produk) {
                    echo '<option value="' . $produk['id_detprod'] . '">' . $produk['kode_barang'] . ' - ' . $produk['ukuran'] . ' - Rp ' . number_format($produk['harga'], 0, ',', '.') . '</option>';
                }
                echo '</select>';
                echo '</div>';

                echo '<div class="form-group">';
                echo '<label for="jumlah">Jumlah Stok yang Dipindahkan:</label>';
                echo '<input type="number" id="jumlah" name="jumlah" value="' . (isset($_POST['jumlah']) ? $_POST['jumlah'] : '') . '" required>';
                echo '</div>';

                echo '<div class="form-group">';
                echo '<input type="submit" value="Konfirmasi Pemindahan">';
                echo '</div>';
                echo '</form>';
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Kode barang tidak ditemukan.'
                    });
                </script>";
            }
        }
        ?>
    </div>
    <footer class="text-center py-3">
  <div class="container1">
    <p class="mb-0">&copy; <?php echo date("Y"); ?> MUSE COLLECTION. All rights reserved.</p>
    <p class="mb-0">Email: info@musecollection.com | Phone: (123) 456-7890</p>
  </div>
</footer>
</body>
</html>
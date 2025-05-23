-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Bulan Mei 2025 pada 08.14
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpus`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `id_kat` int(11) NOT NULL,
  `judul_buku` varchar(150) NOT NULL,
  `pengarang` varchar(100) NOT NULL,
  `tahun_terbit` year(4) NOT NULL,
  `jumlah_buku` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `buku`
--

INSERT INTO `buku` (`id_buku`, `id_kat`, `judul_buku`, `pengarang`, `tahun_terbit`, `jumlah_buku`) VALUES
(1, 10, 'sadadda', 'sdadsadadad', '1904', 5),
(12, 12, 'eghjk', 'yhj', '1909', 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bukuv2`
--

CREATE TABLE `bukuv2` (
  `id_bukuV2` int(11) NOT NULL,
  `judul_buku` varchar(150) NOT NULL,
  `id_penerbit` int(11) DEFAULT NULL,
  `id_penulis` int(11) DEFAULT NULL,
  `id_kat` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `thn_terbit` year(4) DEFAULT NULL,
  `deskripsi_buku` text DEFAULT NULL,
  `cover` text DEFAULT NULL,
  `id_rak` int(11) DEFAULT NULL,
  `status` enum('tersedia','tidak tersedia') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bukuv2`
--

INSERT INTO `bukuv2` (`id_bukuV2`, `judul_buku`, `id_penerbit`, `id_penulis`, `id_kat`, `stok`, `thn_terbit`, `deskripsi_buku`, `cover`, `id_rak`, `status`) VALUES
(17, 'Aku Siap Aku Siap', 1, 1, 11, 13, '1903', 'SIAPSIAPSIAPSIAPSIAPSIAP', 'Screenshot (66).png', 1, ''),
(18, 'dadad', 1, 1, 10, 12, '1999', 'efsfdfs', 'Banana.jpg', 1, ''),
(20, 'ASSA', 1, 1, 11, 14, '2001', 'adadadadadsaaddadasdasdads', 'Screenshot (101).png', 1, ''),
(22, 'dadad', 1, 1, 4, 5, '1923', 'DHHFHFIDSHFISFHSIHDFHSIFHSIUHFI', 'WhatsApp Image 2024-05-10 at 20.40.41_410bf9d5.jpg', 1, 'tersedia'),
(23, 'Bagus', 1, 1, 10, 1, '1902', 'dasda', '1070087967294631976-e85edd2b-199c-43bb-b8e0-a08c2f5b7be5-3069619.3.png', 1, 'tidak tersedia'),
(24, 'Valorant Check', 1, 1, 10, 12, '2011', 'Aku siap dan wow', 'WhatsApp Image 2023-09-22 at 03.32.17.jpg', 1, 'tersedia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_peminjaman`
--

CREATE TABLE `detail_peminjaman` (
  `id_detail` int(11) NOT NULL,
  `id_peminjaman` int(11) NOT NULL,
  `id_bukuV2` int(11) NOT NULL,
  `status_buku` enum('dipinjam','dikembalikan','rusak','hilang') NOT NULL DEFAULT 'dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_peminjaman`
--

INSERT INTO `detail_peminjaman` (`id_detail`, `id_peminjaman`, `id_bukuV2`, `status_buku`) VALUES
(1, 1, 17, 'dikembalikan'),
(2, 2, 18, 'hilang'),
(4, 4, 20, 'dikembalikan'),
(6, 6, 20, 'dikembalikan'),
(7, 7, 23, 'dikembalikan'),
(8, 8, 23, 'dikembalikan'),
(9, 9, 22, 'dikembalikan'),
(11, 11, 22, 'rusak'),
(12, 11, 23, 'rusak'),
(13, 12, 22, 'dipinjam'),
(15, 14, 22, 'dipinjam'),
(16, 15, 22, 'dipinjam'),
(17, 16, 23, 'dikembalikan'),
(18, 17, 23, 'dipinjam');

--
-- Trigger `detail_peminjaman`
--
DELIMITER $$
CREATE TRIGGER `kurangi_stok_buku` AFTER INSERT ON `detail_peminjaman` FOR EACH ROW BEGIN 
Update bukuV2 set stok = stok - 1 where id_bukuV2 = NEW.id_bukuV2;
  -- Jika stok habis, ubah status buku
    UPDATE bukuV2
    SET status = 'tidak tersedia'
    WHERE id_bukuV2 = NEW.id_bukuV2 AND stok = 0;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kat` int(11) NOT NULL,
  `nama_kat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kat`, `nama_kat`) VALUES
(4, 'Komik'),
(9, 'sda'),
(10, 'Ada'),
(11, 'Documentasi'),
(12, 'Manga');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `level` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `login`
--

INSERT INTO `login` (`id`, `name`, `username`, `password`, `level`, `status`) VALUES
(1024, 'Sultan', 'admin', 'admin', 1, 0),
(1044, 'Aku Hebat', 'petugas', 'adadadad', 2, 1),
(1046, 'hijau', 'hijau', 'hijau', 3, 1),
(1057, 'dad', 'daa', 'daa', 1, 1),
(1058, 'dsad', 'das', 'dasd', 1, 1),
(1059, 'Petugas', 'sultan', 'admin', 1, 1),
(1061, 'fsfd', 'sfdfs', 'ffs', 3, 0),
(1062, 'waewe', 'ewewewe', 'eweweweewee', 2, 1),
(1063, 'petugasSATU', 'petugas', 'petugas', 2, 0),
(1064, 'Ghatan Abie Library', 'ghatan', '123', 3, 1),
(1065, 'Navies Gadgetin', 'nvsnox', '1234', 1, 1),
(1066, 'Dava Weka', 'dava', '12345', 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL,
  `tgl_peminjaman` date NOT NULL,
  `tgl_pengembalian` date NOT NULL,
  `tgl_dikembalikan` date DEFAULT NULL,
  `denda` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_siswa`, `id_petugas`, `tgl_peminjaman`, `tgl_pengembalian`, `tgl_dikembalikan`, `denda`) VALUES
(1, 1046, 1044, '2025-05-20', '2025-05-20', '2025-05-22', 15000),
(2, 1046, 1062, '2025-05-20', '2025-05-20', '2025-05-22', 15000),
(4, 1046, 1062, '2025-05-21', '2025-05-25', '2025-05-22', 0),
(5, 1046, 1044, '2025-05-22', '2025-05-24', '2025-05-22', 0),
(6, 1046, 1062, '2025-05-22', '2025-05-24', '2025-05-22', 0),
(7, 1046, 1044, '2025-05-22', '2025-05-23', '2025-05-22', 0),
(8, 1046, 1044, '2025-05-22', '2025-05-31', '2025-05-22', 0),
(9, 1046, 1044, '2025-05-22', '2025-05-25', '2025-05-22', 0),
(11, 1046, 1044, '2025-05-24', '2025-05-28', '2025-05-23', 0),
(12, 1046, 1044, '2025-05-22', '2025-05-24', NULL, 0),
(14, 1046, 1062, '2025-05-23', '2025-05-25', NULL, 0),
(15, 1046, 1044, '2025-05-23', '2025-05-25', NULL, 0),
(16, 1064, 1066, '2025-05-23', '2025-05-24', '2025-05-23', 0),
(17, 1064, 1044, '2025-05-23', '2025-05-24', NULL, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penerbit`
--

CREATE TABLE `penerbit` (
  `id_penerbit` int(11) NOT NULL,
  `nama_penerbit` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `noHp` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penerbit`
--

INSERT INTO `penerbit` (`id_penerbit`, `nama_penerbit`, `alamat`, `noHp`) VALUES
(1, 'Deo Nando Vanci', 'sadfghjkl', '1234567890');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penulis`
--

CREATE TABLE `penulis` (
  `id_penulis` int(11) NOT NULL,
  `nama_penulis` varchar(100) NOT NULL,
  `alamat` text DEFAULT NULL,
  `noHp` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penulis`
--

INSERT INTO `penulis` (`id_penulis`, `nama_penulis`, `alamat`, `noHp`) VALUES
(1, 'Mishiki Mototosd', 'dsfghjkl;\'rtyghjkl.', '987654312456780');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rak`
--

CREATE TABLE `rak` (
  `id_rak` int(11) NOT NULL,
  `nama_rak` varchar(50) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rak`
--

INSERT INTO `rak` (`id_rak`, `nama_rak`, `lokasi`) VALUES
(1, 'A-1', 'Atasss');

-- --------------------------------------------------------

--
-- Struktur dari tabel `request_peminjaman`
--

CREATE TABLE `request_peminjaman` (
  `id_request` int(11) NOT NULL,
  `id_siswa` int(11) DEFAULT NULL,
  `id_buku` int(11) DEFAULT NULL,
  `tanggal_request` datetime DEFAULT current_timestamp(),
  `status_request` enum('pending','approved','rejected') DEFAULT 'pending',
  `catatan_siswa` text DEFAULT NULL,
  `catatan_petugas` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `request_peminjaman`
--

INSERT INTO `request_peminjaman` (`id_request`, `id_siswa`, `id_buku`, `tanggal_request`, `status_request`, `catatan_siswa`, `catatan_petugas`) VALUES
(1, 1046, 22, '2025-05-22 22:20:59', 'approved', 'dada', NULL),
(2, 1046, 22, '2025-05-23 06:49:58', 'pending', 'BAng', NULL),
(3, 1046, 22, '2025-05-23 07:03:54', 'approved', 'Halo Petugas', NULL),
(4, 1046, 22, '2025-05-23 07:17:16', 'pending', 'fsfd', NULL),
(5, 1046, 22, '2025-05-23 07:25:13', 'pending', 'dada', NULL),
(6, 1046, 22, '2025-05-23 10:36:51', 'approved', 'Apa tuh', NULL),
(7, 1064, 23, '2025-05-23 11:38:59', 'approved', 'Saya akan ambil nanti pagi jam 10', NULL),
(8, 1064, 23, '2025-05-23 11:49:28', 'pending', 'Saya akan ambil nanti pagi jam 10', NULL),
(9, 1064, 24, '2025-05-23 13:56:16', 'pending', 'dada', NULL),
(10, 1064, 23, '2025-05-23 14:01:10', 'approved', 'Saya akan ambil nanti pagi jam 10', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `fk_kategori` (`id_kat`);

--
-- Indeks untuk tabel `bukuv2`
--
ALTER TABLE `bukuv2`
  ADD PRIMARY KEY (`id_bukuV2`),
  ADD KEY `id_penerbit` (`id_penerbit`),
  ADD KEY `id_penulis` (`id_penulis`),
  ADD KEY `id_rak` (`id_rak`),
  ADD KEY `fk_buku_kategori` (`id_kat`);

--
-- Indeks untuk tabel `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_peminjaman` (`id_peminjaman`),
  ADD KEY `id_bukuV2` (`id_bukuV2`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kat`);

--
-- Indeks untuk tabel `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indeks untuk tabel `penerbit`
--
ALTER TABLE `penerbit`
  ADD PRIMARY KEY (`id_penerbit`);

--
-- Indeks untuk tabel `penulis`
--
ALTER TABLE `penulis`
  ADD PRIMARY KEY (`id_penulis`);

--
-- Indeks untuk tabel `rak`
--
ALTER TABLE `rak`
  ADD PRIMARY KEY (`id_rak`);

--
-- Indeks untuk tabel `request_peminjaman`
--
ALTER TABLE `request_peminjaman`
  ADD PRIMARY KEY (`id_request`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_buku` (`id_buku`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `bukuv2`
--
ALTER TABLE `bukuv2`
  MODIFY `id_bukuV2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1067;

--
-- AUTO_INCREMENT untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `penerbit`
--
ALTER TABLE `penerbit`
  MODIFY `id_penerbit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `penulis`
--
ALTER TABLE `penulis`
  MODIFY `id_penulis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `rak`
--
ALTER TABLE `rak`
  MODIFY `id_rak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `request_peminjaman`
--
ALTER TABLE `request_peminjaman`
  MODIFY `id_request` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `fk_kategori` FOREIGN KEY (`id_kat`) REFERENCES `kategori` (`id_kat`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `bukuv2`
--
ALTER TABLE `bukuv2`
  ADD CONSTRAINT `bukuv2_ibfk_1` FOREIGN KEY (`id_penerbit`) REFERENCES `penerbit` (`id_penerbit`),
  ADD CONSTRAINT `bukuv2_ibfk_2` FOREIGN KEY (`id_penulis`) REFERENCES `penulis` (`id_penulis`),
  ADD CONSTRAINT `bukuv2_ibfk_3` FOREIGN KEY (`id_rak`) REFERENCES `rak` (`id_rak`),
  ADD CONSTRAINT `fk_buku_kategori` FOREIGN KEY (`id_kat`) REFERENCES `kategori` (`id_kat`);

--
-- Ketidakleluasaan untuk tabel `detail_peminjaman`
--
ALTER TABLE `detail_peminjaman`
  ADD CONSTRAINT `detail_peminjaman_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`),
  ADD CONSTRAINT `detail_peminjaman_ibfk_2` FOREIGN KEY (`id_bukuV2`) REFERENCES `bukuv2` (`id_bukuV2`);

--
-- Ketidakleluasaan untuk tabel `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_petugas`) REFERENCES `login` (`id`);

--
-- Ketidakleluasaan untuk tabel `request_peminjaman`
--
ALTER TABLE `request_peminjaman`
  ADD CONSTRAINT `request_peminjaman_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `login` (`id`),
  ADD CONSTRAINT `request_peminjaman_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `bukuv2` (`id_bukuV2`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

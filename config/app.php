<?php
include('koneksi.php');

//============================================================================//
//================Akun========================================================//
//============================================================================//

// Start untuk menampilkan data
function tampilkanDataAkun($query)
{
    global $db;
    $result = mysqli_query($db, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
// END untuk menampilkan data


// start function untuk menampilkan filter akun berdasarkan level di list.php
function getFilteredAkun($level = '')
{
    global $db;

    $query = "SELECT * FROM login";

    if ($level !== '') {
        $level = mysqli_real_escape_string($db, $level);
        $query .= " WHERE level = '$level'";
    }

    return tampilkanDataAkun($query);
}
// End function untuk menampilkan filter akun berdasarkan level di list.php


// start function untuk menampilkan dan mengambil 5 akun terbaru
function getRecentAkun($limit = 5)
{
    global $db;
    $query = "SELECT * FROM login ORDER BY id DESC LIMIT " . intval($limit);
    $result = mysqli_query($db, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
//end function untuk menampilkan dan mengambil 5 akun terbaru


// Start createAkun
function registerAkun($post)
{
    global $db;

    // Ambil data dari form dan bersihkan
    $name = strip_tags($post['name']);
    $username = strip_tags($post['username']);
    $password = strip_tags($post['password']);

    // Tetapkan level dan status secara otomatis
    $level = 3; // level 3 = siswa
    $status = 0; // 0 = belum aktif

    // Query untuk insert data ke tabel login
    $query = "INSERT INTO login VALUES (null, '$name', '$username','$password','$level','$status')";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
// End createAkun


// Start untuk create akun khusus admin
function createAkunAdmin($post)
{
    global $db;

    $name = strip_tags($post['name']);
    $username = strip_tags($post['username']);
    $password = strip_tags($post['password']);
    $level = (int)$post['level'];
    $status = (int)$post['status'];

    $query = "INSERT INTO login VALUES (null, '$name', '$username','$password','$level' ,'$status')";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
// End untuk create akun khusus admin


// Start Update akun
function updateAkun($post)
{
    global $db;

    $id = strip_tags($post['id']);
    $name = strip_tags($post['name']);
    $username = strip_tags($post['username']);
    $password = strip_tags($post['password']);
    $level = strip_tags($post['level']);
    $status = strip_tags($post['status']);

    $query = "UPDATE login SET name = '$name',
                           username = '$username',
                           password = '$password',
                              level = '$level',
                             status = '$status'
                           WHERE id = '$id'";

    // Update session jika yang diupdate adalah user yang sedang login
    if (isset($_SESSION['username']) && $_SESSION['username'] == $post['old_username']) {
        $_SESSION['username'] = $username;
    }

    mysqli_query($db, $query) or die(mysqli_error($db));
    return mysqli_affected_rows($db);
}
// End Update akun


// Start Delete akun
function deleteAkun($id)
{
    global $db;

    $query = "DELETE FROM login WHERE id = '$id'";
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
// End Delete Akun


// Start check level dan status untuk ditampilkan
function getLevelName($level)
{
    switch ($level) {
        case 1:
            return 'Admin';
        case 2:
            return 'Petugas';
        case 3:
            return 'Siswa';
        default:
            return 'Unknown';
    }
}


function getStatusText($status)
{
    return $status == 1 ? 'Aktif' : 'Nonaktif';
}
//END check level dan status

//============================================================================//
//================END Akun====================================================//
//============================================================================//


//============================================================================//
//================Buku========================================================//
//============================================================================//
// Start kategori
function getAllKategori()
{
    global $db;
    $query = "SELECT * FROM kategori ORDER BY nama_kat ASC";
    $result = mysqli_query($db, $query);
    return $result;
}
// End kategori


//start function menampilkan data buku
function getAllBuku($id = null)
{
    global $db;
    $query = "SELECT bukuV2.id_bukuV2,
                     bukuV2.judul_buku,
                     penerbit.nama_penerbit,
                     penulis.nama_penulis,
                     kategori.nama_kat,
                     bukuV2.stok,
                     bukuV2.thn_terbit,
                     bukuV2.deskripsi_buku,
                     bukuV2.cover,
                     rak.nama_rak,
                     CASE 
                        WHEN bukuV2.stok > 0 THEN 'tersedia'
                        ELSE 'habis'
                     END as status
              FROM bukuV2
              JOIN penerbit ON bukuV2.id_penerbit = penerbit.id_penerbit
              JOIN penulis ON bukuV2.id_penulis = penulis.id_penulis
              JOIN kategori ON bukuV2.id_kat = kategori.id_kat
              JOIN rak ON bukuV2.id_rak = rak.id_rak";

    if ($id !== null) {
        $id = (int)$id;
        $query .= " WHERE bukuV2.id_bukuV2 = $id";
    } else {
        $query .= " ORDER BY bukuV2.judul_buku ASC";
    }

    $result = mysqli_query($db, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
//end function menampilkan data buku


//======================================================================
//Start function menambah buku
//ada function penerbit, penulis, kategori, rak, status
//======================================================================
function createBuku($post)
{
    global $db;

    // Ambil data dari form
    $judulBuku = strip_tags($post['judul_buku']);
    $penerbitBuku = strip_tags($post['id_penerbit']);
    $penulisBuku = strip_tags($post['id_penulis']);
    $kategoriBuku = strip_tags($post['id_kat']);
    $tahunTerbit = strip_tags($post['tahun_terbit']);
    $stokBuku = strip_tags($post['stok']);
    $deskripsiBuku = strip_tags($post['deskripsi_buku']);
    $fileCoverName = $_FILES['cover']['name'];
    // Upload file ke folder uploads
    $fileCoverTmp = $_FILES['cover']['tmp_name'];
    $rak = strip_tags($post['id_rak']);
    $status = strip_tags($post['status']);


    // Pindahkan file ke folder uploads
    move_uploaded_file($fileCoverTmp, '../uploads/' . $fileCoverName);

    // Insert ke database
    $query = "INSERT INTO bukuV2 (judul_buku, id_penerbit, id_penulis, id_kat, thn_terbit, stok, deskripsi_buku, cover, id_rak, status) 
             VALUES ('$judulBuku', '$penerbitBuku', '$penulisBuku', '$kategoriBuku', '$tahunTerbit', '$stokBuku', '$deskripsiBuku', '$fileCoverName', '$rak', '$status')";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}
//end function menambah buku


// Start fungsi untuk mengambil data penerbit
function getAllPenerbit()
{
    global $db;
    $query = "SELECT * FROM penerbit ORDER BY nama_penerbit ASC";
    $result = mysqli_query($db, $query);
    return $result;
}
// end function untuk mengambil data penerbit


// Start fungsi untuk mengambil data penulis
function getAllPenulis()
{
    global $db;
    $query = "SELECT * FROM penulis ORDER BY nama_penulis ASC";
    $result = mysqli_query($db, $query);
    return $result;
}
// end function untuk mengambil data penulis


// Start fungsi untuk mengambil data rak
function getAllRak()
{
    global $db;
    $query = "SELECT * FROM rak ORDER BY nama_rak ASC";
    $result = mysqli_query($db, $query);
    return $result;
}
// end function untuk mengambil data rak


// start function untuk update buku
function updateBuku($post)
{
    global $db;

    // Validasi ID
    if (!isset($post['id_bukuV2']) || empty($post['id_bukuV2'])) {
        error_log("Error: ID buku tidak valid");
        return false;
    }

    // Ambil data dari form dengan sanitasi
    $id = (int)$post['id_bukuV2'];
    $judul = mysqli_real_escape_string($db, $post['judul_buku']);
    $penerbit = (int)$post['penerbit'];
    $penulis = (int)$post['penulis'];
    $kategori = (int)$post['kategori'];
    $stok = (int)$post['stok'];
    $tahun = (int)$post['tahun_terbit'];
    $deskripsi = mysqli_real_escape_string($db, $post['deskripsi_buku']);
    $rak = (int)$post['rak'];
    $status = mysqli_real_escape_string($db, $post['status']);

    // Handle cover
    $cover_lama = isset($post['cover_lama']) ? $post['cover_lama'] : '';
    $cover_baru = $cover_lama;

    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {
        $file_name = basename($_FILES['cover']['name']);
        $target_file = '../uploads/' . $file_name;

        // Pindahkan file yang diupload
        if (move_uploaded_file($_FILES['cover']['tmp_name'], $target_file)) {
            $cover_baru = $file_name;

            // Hapus cover lama jika ada dan bukan default
            if ($cover_lama && $cover_lama !== 'default.jpg' && file_exists('../uploads/' . $cover_lama)) {
                @unlink('../uploads/' . $cover_lama);
            }
        }
    }

    // Query update dengan prepared statement untuk keamanan
    $query = "UPDATE bukuV2 SET 
        judul_buku = ?,
        id_penerbit = ?,
        id_penulis = ?,
        id_kat = ?,
        stok = ?,
        thn_terbit = ?,
        deskripsi_buku = ?,
        id_rak = ?,
        status = ?,
        cover = ?
        WHERE id_bukuV2 = ?";

    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param(
        $stmt,
        'siiiiissssi',
        $judul,
        $penerbit,
        $penulis,
        $kategori,
        $stok,
        $tahun,
        $deskripsi,
        $rak,
        $status,
        $cover_baru,
        $id
    );

    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        error_log("Error updating buku: " . mysqli_error($db));
    }

    mysqli_stmt_close($stmt);
    return $result;
}
// end function untuk update buku


// start function untuk delete buku
function deleteBuku($id)
{
    global $db;
    
    // Mulai transaction
    mysqli_begin_transaction($db);
    
    try {
        // Hapus data dari detail_peminjaman terlebih dahulu
        $query_detail = "DELETE FROM detail_peminjaman WHERE id_bukuV2 = ?";
        $stmt_detail = mysqli_prepare($db, $query_detail);
        mysqli_stmt_bind_param($stmt_detail, 'i', $id);
        mysqli_stmt_execute($stmt_detail);
        
        // Kemudian hapus dari tabel bukuV2
        $query_buku = "DELETE FROM bukuV2 WHERE id_bukuV2 = ?";
        $stmt_buku = mysqli_prepare($db, $query_buku);
        mysqli_stmt_bind_param($stmt_buku, 'i', $id);
        mysqli_stmt_execute($stmt_buku);
        
        // Jika semua berhasil, commit transaction
        mysqli_commit($db);
        return true;
        
    } catch (Exception $e) {
        // Jika terjadi error, rollback transaction
        mysqli_rollback($db);
        error_log("Error deleting buku: " . $e->getMessage());
        return false;
    }
}
// end function untuk delete buku

//============================================================================//
//================END Buku====================================================//
//============================================================================//

//============================================================================//
//================Peminjaman==================================================//
//============================================================================//
// Start function untuk menampilkan data peminjaman yang belum dikembalikan
function getPeminjamanAktif() {
    global $db;
    
    $query = "SELECT p.*, 
              s.name as nama_siswa,
              pt.name as nama_petugas,
              GROUP_CONCAT(b.judul_buku SEPARATOR ', ') as buku_dipinjam,
              dp.status_buku,
              DATEDIFF(CURRENT_DATE, p.tgl_pengembalian) as keterlambatan
              FROM peminjaman p
              JOIN login s ON p.id_siswa = s.id
              JOIN login pt ON p.id_petugas = pt.id
              JOIN detail_peminjaman dp ON p.id_peminjaman = dp.id_peminjaman
              JOIN bukuV2 b ON dp.id_bukuV2 = b.id_bukuV2
              WHERE dp.status_buku = 'dipinjam'
              GROUP BY p.id_peminjaman
              ORDER BY p.tgl_peminjaman DESC";
              
    $result = mysqli_query($db, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Start function untuk menampilkan data peminjaman yang sudah dikembalikan
function getPeminjamanSelesai() {
    global $db;
    
    $query = "SELECT p.*, 
              s.name as nama_siswa,
              pt.name as nama_petugas,
              GROUP_CONCAT(b.judul_buku SEPARATOR ', ') as buku_dipinjam,
              dp.status_buku,
              p.denda,
              p.tgl_dikembalikan
              FROM peminjaman p
              JOIN login s ON p.id_siswa = s.id
              JOIN login pt ON p.id_petugas = pt.id
              JOIN detail_peminjaman dp ON p.id_peminjaman = dp.id_peminjaman
              JOIN bukuV2 b ON dp.id_bukuV2 = b.id_bukuV2
              WHERE dp.status_buku IN ('dikembalikan', 'rusak', 'hilang')
              GROUP BY p.id_peminjaman
              ORDER BY p.tgl_dikembalikan DESC";
              
    $result = mysqli_query($db, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Start function untuk mengembalikan buku
function kembalikanBuku($id_peminjaman, $tgl_dikembalikan, $status_buku, $denda) {
    global $db;
    
    // Update status buku di detail_peminjaman
    $query_detail = "UPDATE detail_peminjaman 
                    SET status_buku = '$status_buku' 
                    WHERE id_peminjaman = $id_peminjaman";
    mysqli_query($db, $query_detail);
    
    // Update data peminjaman
    $query_peminjaman = "UPDATE peminjaman 
                        SET tgl_dikembalikan = '$tgl_dikembalikan',
                            denda = $denda
                        WHERE id_peminjaman = $id_peminjaman";
    mysqli_query($db, $query_peminjaman);
    
    return mysqli_affected_rows($db);
}

// Start function untuk simpan peminjaman
function simpanPeminjaman($db, $id_siswa, $id_petugas, $tgl_peminjaman, $tgl_pengembalian, $buku_list)
{
    // Validasi input
    if (empty($id_siswa) || empty($id_petugas) || empty($tgl_peminjaman) || empty($tgl_pengembalian) || empty($buku_list)) {
        return false;
    }

    // Validasi tanggal
    if (strtotime($tgl_peminjaman) > strtotime($tgl_pengembalian)) {
        return false;
    }

    $denda = 0;

    // Insert ke tabel peminjaman
    $query_peminjaman = "INSERT INTO peminjaman 
        (id_siswa, id_petugas, tgl_peminjaman, tgl_pengembalian, tgl_dikembalikan, denda) 
        VALUES 
        ('$id_siswa', '$id_petugas', '$tgl_peminjaman', '$tgl_pengembalian', NULL, $denda)";

    mysqli_query($db, $query_peminjaman);
    $id_peminjaman = mysqli_insert_id($db);

    // Insert ke detail_peminjaman dan update status buku
    foreach ($buku_list as $id_buku) {
        // Insert ke detail_peminjaman
        $query_detail = "INSERT INTO detail_peminjaman (id_peminjaman, id_bukuV2, status_buku) 
                        VALUES ($id_peminjaman, $id_buku, 'dipinjam')";
        mysqli_query($db, $query_detail);

    }

    return true;
}
// End function untuk simpan peminjaman

// Start function untuk update tanggal pengembalian
function updateTanggalPengembalian($id_peminjaman, $tgl_pengembalian) {
    global $db;
    
    // Validasi tanggal
    if (empty($id_peminjaman) || empty($tgl_pengembalian)) {
        return false;
    }
    
    // Update tanggal pengembalian
    $query = "UPDATE peminjaman 
              SET tgl_pengembalian = '$tgl_pengembalian'
              WHERE id_peminjaman = $id_peminjaman";
              
    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

// Start function untuk hapus peminjaman
function hapusPeminjaman($id_peminjaman) {
    global $db;
    
    // Validasi ID
    if (empty($id_peminjaman)) {
        return false;
    }
    
    // Hapus dari detail_peminjaman terlebih dahulu (karena foreign key)
    $query_detail = "DELETE FROM detail_peminjaman WHERE id_peminjaman = $id_peminjaman";
    mysqli_query($db, $query_detail);
    
    // Hapus dari tabel peminjaman
    $query_peminjaman = "DELETE FROM peminjaman WHERE id_peminjaman = $id_peminjaman";
    mysqli_query($db, $query_peminjaman);
    
    return mysqli_affected_rows($db);
}

//============================================================================//
//================END Peminjaman==============================================//
//============================================================================//


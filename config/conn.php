<?php
require __DIR__ . '/url.php';
$host = 'localhost';
$dbname = 'bk_poliklinik';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$conn = mysqli_connect($host, $username, $password, $dbname);

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

function ubahDokter($data)
{
    global $conn;

    $id = $data["id"];
    $nama = mysqli_real_escape_string($conn, $data["nama"]);
    $alamat = mysqli_real_escape_string($conn, $data["alamat"]);
    $no_hp = mysqli_real_escape_string($conn, $data["no_hp"]);

    $query = "UPDATE dokter SET nama = '$nama', alamat = '$alamat', no_hp = '$no_hp' WHERE id = $id ";

    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn); // Return the number of affected rows
    } else {
        // Handle the error
        echo "Error updating record: " . mysqli_error($conn);
        return -1; // Or any other error indicator
    }
}

// Jadwal Periksa Sisi Dokter
function tambahJadwalPeriksa($data)
{
    try {
        global $conn;

        $id_dokter = $data["id_dokter"];
        $hari = mysqli_real_escape_string($conn, $data["hari"]);
        $jam_mulai = mysqli_real_escape_string($conn, $data["jam_mulai"]);
        $jam_selesai = mysqli_real_escape_string($conn, $data["jam_selesai"]);

        $query = "INSERT INTO jadwal_periksa VALUES ('', '$id_dokter', '$hari', '$jam_mulai', '$jam_selesai')";

        if (mysqli_query($conn, $query)) {
            return mysqli_affected_rows($conn); // Return the number of affected rows
        } else {
            // Handle the error
            echo "Error updating record: " . mysqli_error($conn);
            return -1; // Or any other error indicator
        }
    } catch (\Exception $e) {
        var_dump($e->getMessage());
    }
}

function updateJadwalPeriksa($data, $id)
{
    try {
        global $conn;

        $hari = mysqli_real_escape_string($conn, $data["hari"]);
        $jam_mulai = mysqli_real_escape_string($conn, $data["jam_mulai"]);
        $jam_selesai = mysqli_real_escape_string($conn, $data["jam_selesai"]);

        $query = "UPDATE jadwal_periksa SET hari = '$hari', jam_mulai = '$jam_mulai', jam_selesai = '$jam_selesai' WHERE id = $id ";

        if (mysqli_query($conn, $query)) {
            return mysqli_affected_rows($conn); // Return the number of affected rows
        } else {
            // Handle the error
            echo "Error updating record: " . mysqli_error($conn);
            return -1; // Or any other error indicator
        }
    } catch (\Exception $e) {
        var_dump($e->getMessage());
        die();
    }
}

function hapusJadwalPeriksa($id)
{
    try {
        global $conn;

        $query = "DELETE FROM jadwal_periksa WHERE id = $id";

        if (mysqli_query($conn, $query)) {
            return mysqli_affected_rows($conn); // Return the number of affected rows
        } else {
            // Handle the error
            echo "Error updating record: " . mysqli_error($conn);
            return -1; // Or any other error indicator
        }
    } catch (\Exception $e) {
        var_dump($e->getMessage());
    }
}

function TambahPeriksa($data){
    global $conn;
     // ambil data dari tiap elemen dalam form
     $tgl_periksa = htmlspecialchars($data["tgl_periksa"]);
     $catatan = htmlspecialchars($data["catatan"]);
     

      // query insert data
    $query = "INSERT INTO periksa
                VALUES
                ('', '$tgl_periksa','$catatan');
            ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// ini belum selesai mau dilanjutin vander :v
function TambahDetailPeriksa($data){
    global $conn;
     // ambil data dari tiap elemen dalam form
     $tgl_periksa = htmlspecialchars($data["tgl_periksa"]);
     $catatan = htmlspecialchars($data["catatan"]);
     

      // query insert data
    $query = "INSERT INTO detail_periksa
                VALUES
                ('', '$tgl_periksa','$catatan');
            ";
            
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

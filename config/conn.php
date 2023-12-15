<?php
require __DIR__ . '/url.php';
$conn = mysqli_connect("localhost", "root", "", "bk_poliklinik");

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

function ubah($data)
{
    global $conn;
    // ambil data dari tiap elemen dalam form
    $id = $data["id"];
    $nama = htmlspecialchars($data["nama"]);
    $alamat = htmlspecialchars($data["alamat"]);
    $nohp = htmlspecialchars($data["no_hp"]);

    // query insert data
    $query = "UPDATE dokter SET
                    nama = '$nama',
                    alamat = '$alamat',
                    no_hp = '$nohp',
                    WHERE id = $id
                ";
                
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

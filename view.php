<?php
include('koneksi.php');
include('cek.php');
$id_barang = $_GET['id'];
$get = mysqli_query($conn, "select * from stok where id_barang = '$id_barang'");
$fetch = mysqli_fetch_assoc($get);
$nama_barang = $fetch['nama_barang'];
$deskripsi = $fetch['deskripsi'];
$stock = $fetch['stock'];
$foto = $fetch['foto'];
//cek gambar ada atau tidak
$gambar = $fetch['foto'];
if($gambar==null){
    //jika tidak ada gambar
    $img = 'No Photo';
}else{
    //jika ada gambar
   $img = '<img class="card-img-top img-fluid" src="images/'.$gambar.'" alt="Card image" style="max-height:350px; object-fit:contain;">';

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Menampilkan barang</title>
</head>
<body>
    <div class="container">
            <h2>Detail Barang:</h2>
            <div class="card" style="width:400px">
                <?= $img; ?>
                <div class="card-body">
                <h4 class="card-title"><?= $nama_barang; ?></h4>
                <p class="card-text"><?= $deskripsi; ?></p>
                <p class="card-text"><?= $stock; ?></p>
                
                </div>
            </div>
            <br>
    </div>
</body>
</html>
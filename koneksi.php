<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "stokbrg")
    or die("Koneksi ke database gagal: " . mysqli_connect_error());


    //Tambah Barang
    if(isset($_POST['addnew'])){
        $nama_barang = $_POST['nama_barang'];
        $deskripsi = $_POST['deskripsi'];
        $stock = $_POST['stock'];
        //gambar
        // Proses upload gambar
        $allowed_extension = array('png', 'jpg');

        // Mengambil informasi file
        $nama     = $_FILES['file']['name'];        // nama file gambar
        $dot      = explode('.', $nama);
        $ekstensi = strtolower(end($dot));           // mengambil ekstensi file
        $ukuran   = $_FILES['file']['size'];         // mengambil ukuran file
        $file_tmp = $_FILES['file']['tmp_name'];     // mengambil lokasi sementara file

        // Penamaan file dengan enkripsi
        $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi;  // membuat nama unik

                // proses upload gambar
        if (in_array($ekstensi, $allowed_extension) === true) {

            // validasi ukuran filenya
            if ($ukuran < 1500000) {

                // memindahkan file ke folder images
                move_uploaded_file($file_tmp, 'images/' . $image);
                 $addketabel = mysqli_query($conn,"insert into stok (nama_barang, deskripsi, stock, foto) values ('$nama_barang','$deskripsi','$stock', '$image')");
                  if($addketabel){
                      echo "<script>
                      alert('Barang berhasil ditambahkan!');
                      window.location = 'index.php';
                    </script>";
                  }else{
                       echo "<script>
                      alert('Barang gagal ditambahkan!');
                      window.location = 'index.php';
                    </script>";
                  } 

            } else {
                echo "Ukuran file terlalu besar!";
            }

        } else {
            echo "Ekstensi file tidak diperbolehkan!";
        }

        
    };

    //Tambah barang masuk
    if(isset($_POST['barangmasuk'])){
      $barangnya = $_POST['barangnya'];
      $penerima = $_POST['penerima'];
      $qty = $_POST['qty'];

      $cekstokskrg = mysqli_query($conn, "select * from stok where id_barang = '$barangnya'");
      $ambildatanya = mysqli_fetch_array($cekstokskrg);

      $stokskrng = $ambildatanya['stock'];
      $tambahkanstokskrngdanqty = $stokskrng+$qty;

      $addkemasuk = mysqli_query($conn, "insert into masuk (id_barang, penerima, qty) values ('$barangnya','$penerima','$qty')");
      $updatestokmasuk = mysqli_query($conn, "update stok set stock = '$tambahkanstokskrngdanqty' where id_barang = '$barangnya'");

      if($addkemasuk&&$updatestokmasuk){
            echo "<script>
            alert('Barang berhasil ditambahkan!');
            window.location = 'masuk.php';
          </script>";
        }else{
             echo "<script>
            alert('Barang gagal ditambahkan!');
            window.location = 'masuk.php';
          </script>";
        }
    };

    //Tambah barang keluar
    if(isset($_POST['addkeluar'])){
      $barangnya = $_POST['barangnya'];
      $keterangan = $_POST['keterangan'];
      $qty = $_POST['qty'];

      $cekstokskrg = mysqli_query($conn, "select * from stok where id_barang = '$barangnya'");
      $ambildatanya = mysqli_fetch_array($cekstokskrg);

      $stokskrg = $ambildatanya['stock'];

      if($stokskrg >= $qty){
        //kalau stok cukup
      $kurangistokskrngdanqty = $stokskrg-$qty;

      $addtokeluar = mysqli_query($conn, "insert into keluar (id_barang, keterangan, qty) values ('$barangnya','$keterangan','$qty')");
      $updatestokkeluar = mysqli_query($conn, "update stok set stock = '$kurangistokskrngdanqty' where id_barang = '$barangnya'");

      if($addtokeluar&&$updatestokkeluar){
            echo "<script>
            alert('Barang berhasil ditambahkan!');
            window.location = 'keluar.php';
          </script>";
        }else{
             echo "<script>
            alert('Barang gagal ditambahkan!');
            window.location = 'keluar.php';
          </script>";
        }
      }else{
        //kalau barang keluar melebihi stok
         echo "<script>
            alert('Stok barang saat ini tidak mencukupi!');
            window.location = 'keluar.php';
          </script>";
      }
    };

    //update stok
    if(isset($_POST['updatebrg'])){
      $idb = $_POST['idb'];
      $nama_barang = $_POST['nama_barang'];
      $deskripsi = $_POST['deskripsi'];
      // Proses upload gambar
      $allowed_extension = array('png', 'jpg');

      // Mengambil informasi file
      $nama     = $_FILES['file']['name'];        // nama file gambar
      $dot      = explode('.', $nama);
      $ekstensi = strtolower(end($dot));           // mengambil ekstensi file
      $ukuran   = $_FILES['file']['size'];         // mengambil ukuran file
      $file_tmp = $_FILES['file']['tmp_name'];     // mengambil lokasi sementara file

      // Penamaan file dengan enkripsi
      $image = md5(uniqid($nama, true) . time()) . '.' . $ekstensi;  // membuat nama unik
      if($ukuran==0){
        //jika tidak ingin upload
        $update = mysqli_query($conn, "update stok set nama_barang='$nama_barang', deskripsi='$deskripsi', foto='$image' where id_barang = '$idb'");
      if($update){
        echo "<script>
            alert('Barang berhasil diupdate!');
            window.location = 'index.php';
          </script>";
        }else{
             echo "<script>
            alert('Barang gagal diupdate!');
            window.location = 'index.php';
          </script>";
        }
      }else{
        //jika ingin
        move_uploaded_file($file_tmp, 'images/' . $image);
        $update = mysqli_query($conn, "update stok set nama_barang='$nama_barang', deskripsi='$deskripsi', foto='$image' where id_barang = '$idb'");
      if($update){
        echo "<script>
            alert('Barang berhasil diupdate!');
            window.location = 'index.php';
          </script>";
        }else{
             echo "<script>
            alert('Barang gagal diupdate!');
            window.location = 'index.php';
          </script>";
        }
      }
      };

//menghapus barang dari stok
   if(isset($_POST['hapusbrg'])){
    $idb = $_POST['idb'];

    //ambil data gambar
    $get = mysqli_query($conn, "SELECT foto FROM stok WHERE id_barang = '$idb'");
    $foto = mysqli_fetch_array($get);
    $img = 'images/'.$foto['foto'];

    //hapus file gambar jika ada
    if(file_exists($img)){
        unlink($img);
    }

    //hapus data dari database
    $hapus = mysqli_query($conn, "DELETE FROM stok WHERE id_barang = '$idb'");

    if($hapus){
        echo "<script>
            alert('Barang berhasil dihapus!');
            window.location = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Barang gagal dihapus!');
            window.location = 'index.php';
        </script>";
    }
}



           
            // Update barang masuk
      if(isset($_POST['updatebrgmsk'])){
          $idb = $_POST['idb'];
          $idm = $_POST['id_masuk'];
          $penerima = $_POST['penerima'];
          $qty = $_POST['qty'];

          // Ambil stok sekarang
          $lihatstok = mysqli_query($conn, "SELECT stock FROM stok WHERE id_barang='$idb'");
          $stoknya = mysqli_fetch_array($lihatstok);
          $stokskrg = $stoknya['stock'];

          // Ambil qty lama dari tabel masuk
          $ambilqtybaru = mysqli_query($conn, "SELECT qty FROM masuk WHERE id_masuk='$idm'");
          $dataqtybaru = mysqli_fetch_array($ambilqtybaru);
          $qtybaru = $dataqtybaru['qty'];

          // Hitung perubahan stok
          if($qty > $qtybaru){
              // qty baru lebih besar, stok harus ditambah
              $selisih = $qty - $qtybaru;
              $stokbaru = $stokskrg + $selisih;
          } else {
              // qty baru lebih kecil, stok harus dikurangi
              $selisih = $qtybaru - $qty;
              $stokbaru = $stokskrg - $selisih;
          }


          // Update stok dan tabel masuk
          $updatestok = mysqli_query($conn, "UPDATE stok SET stock='$stokbaru' WHERE id_barang='$idb'");
          $updatemasuk = mysqli_query($conn, "UPDATE masuk SET qty='$qty', penerima='$penerima' WHERE id_masuk='$idm'");


          if($updatestok && $updatemasuk){
              echo "<script>
            alert('Barang masuk berhasil diedit!');
            window.location = 'masuk.php';
          </script>";
        }else{
             echo "<script>
            alert('Barang masuk gagal diedit!');
            window.location = 'masuk.php';
          </script>";
        }
      }

      //menghapus barang masuk
      if(isset($_POST['hapusbrgmsk'])){
          $idb = $_POST['idb'];
          $idm = $_POST['id_masuk'];
          $qty = $_POST['qty'];

          $getdatastok = mysqli_query($conn, "select * from stok where id_barang='$idb'");
          $data = mysqli_fetch_array($getdatastok);
          $stok = $data['stock'];

          $selisih = $stok - $qty;
          $update = mysqli_query($conn, "UPDATE stok set stock ='$selisih' where id_barang='$idb'");
          $hapusdata = mysqli_query($conn, "DELETE from masuk where id_masuk='$idm'");

          if($update&&$hapusdata){
            echo "<script>
            alert('Barang masuk berhasil dihapus!');
            window.location = 'masuk.php';
          </script>";
        }else{
             echo "<script>
            alert('Barang masuk gagal dihapus!');
            window.location = 'masuk.php';
          </script>";
          }

      }

      //Mengubah data barang keluar
      if(isset($_POST['updatebrgklr'])){
          $idb = $_POST['idb'];
          $idk = $_POST['id_keluar'];
          $keterangan = $_POST['keterangan'];
          $qty = $_POST['qty'];

          // Ambil stok sekarang
          $lihatstok = mysqli_query($conn, "SELECT stock FROM stok WHERE id_barang='$idb'");
          $stoknya = mysqli_fetch_array($lihatstok);
          $stokskrg = $stoknya['stock'];

          // Ambil qty lama dari tabel masuk
          $ambilqtylama = mysqli_query($conn, "SELECT qty FROM keluar WHERE id_keluar='$idk'");
          $dataqtylama = mysqli_fetch_array($ambilqtylama);
          $qtylama = $dataqtylama['qty'];

          // Hitung perubahan stok
          if($qty > $qtylama){
              $selisih = $qty - $qtylama;
              $stokbaru = $stokskrg - $selisih;   // stok dikurangi
          } else {
              $selisih = $qtylama - $qty;
              $stokbaru = $stokskrg + $selisih;   // stok ditambah
          }

          // Update stok dan tabel masuk
          $updatestok = mysqli_query($conn, "UPDATE stok SET stock='$stokbaru' WHERE id_barang='$idb'");
          $updatekeluar = mysqli_query($conn, "UPDATE keluar SET qty='$qty', keterangan='$keterangan' WHERE id_keluar='$idk'");


          if($updatestok && $updatekeluar){
              echo "<script>
            alert('Barang keluar berhasil diedit!');
            window.location = 'keluar.php';
          </script>";
        }else{
             echo "<script>
            alert('Barang keluar gagal diedit!');
            window.location = 'keluar.php';
          </script>";
        }
      }

      //menghapus barang keluar
      if(isset($_POST['hapusbrgklr'])){
          $idb = $_POST['idb'];
          $idk = $_POST['id_keluar'];
          $qty = $_POST['qty'];

          $getdatastok = mysqli_query($conn, "select * from stok where id_barang='$idb'");
          $data = mysqli_fetch_array($getdatastok);
          $stok = $data['stock'];

          $selisih = $stok + $qty;
          $update = mysqli_query($conn, "UPDATE stok set stock ='$selisih' where id_barang='$idb'");
          $hapusdata = mysqli_query($conn, "DELETE from keluar where id_keluar='$idk'");

          if($update&&$hapusdata){
            echo "<script>
            alert('Barang keluar berhasil dihapus!');
            window.location = 'keluar.php';
          </script>";
        }else{
             echo "<script>
            alert('Barang keluar gagal dihapus!');
            window.location = 'keluar.php';
          </script>";
          }

      }

      //menambah admin baru
      if(isset($_POST['addadmin'])){
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $queryinsert = mysqli_query($conn, "INSERT into login(email, password) values('$email','$password')");

        if($queryinsert){
          //jika berhasil
          echo "<script>
            alert('Tambah admin berhasil!');
            window.location = 'admin.php';
          </script>";
        }else{
             echo "<script>
            alert('Tambah admin gagal!');
            window.location = 'admin.php';
          </script>";
          }
      }

      //update admin
      if(isset($_POST['updateadmin'])){
        $emailbaru = $_POST['emailadmin'];
        $passwordbaru = md5($_POST['passwordbaru']);
        $idnya = $_POST['id_user'];

        $queryupdate = mysqli_query($conn, "UPDATE login set email='$emailbaru', password='$passwordbaru' where id_user='$idnya'");

        if($queryupdate){
          echo "<script>
            alert('Update admin berhasil!');
            window.location = 'admin.php';
          </script>";
        }else{
          echo "<script>
            alert('Update admin gagal!');
            window.location = 'admin.php';
          </script>";
        }
      }

      //hapus admin
      if(isset($_POST['hapusadmin'])){
        $id_user = $_POST['id_user'];

        $querydelete = mysqli_query($conn, "DELETE FROM login where id_user = '$id_user'");

        if($querydelete){
          echo "<script>
            alert('Delete admin berhasil!');
            window.location = 'admin.php';
          </script>";
        }else {
          echo "<script>
            alert('Delete admin gagal!');
            window.location = 'admin.php';
          </script>";
        }
      }
?>

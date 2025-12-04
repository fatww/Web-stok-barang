<?php
include('koneksi.php');
include('cek.php');
// Query ambil data barang masuk untuk chart
$ambilChart = mysqli_query($conn, "SELECT tanggal_masuk, SUM(qty) AS total FROM masuk GROUP BY tanggal_masuk ORDER BY tanggal_masuk ASC");

$tanggalMasuk = [];
$totalQty = [];

while ($row = mysqli_fetch_assoc($ambilChart)) {
    $tanggalMasuk[] = $row['tanggal_masuk'];
    $totalQty[] = (int)$row['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Barang Masuk</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Fatwa Skuy</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                                Stok Barang
                            </a>
                            <a class="nav-link" href="masuk.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cart-arrow-down"></i></div>
                                Barang Masuk
                            </a>
                            <a class="nav-link" href="keluar.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-truck-loading"></i></div>
                                Barang Keluar
                            </a>
                            <a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                                Kelola Admin
                            </a>
                        
                            <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                                        Authentication
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="login.php">Login</a>
                                            <a class="nav-link" href="register.html">Register</a>
                                            <a class="nav-link" href="password.html">Forgot Password</a>
                                        </nav>
                                    </div>
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                                        Error
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            <a class="nav-link" href="401.html">401 Page</a>
                                            <a class="nav-link" href="404.html">404 Page</a>
                                            <a class="nav-link" href="500.html">500 Page</a>
                                        </nav>
                                    </div>
                                </nav>
                            </div>
   
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                         <?php echo $_SESSION['email']; ?>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Barang Masuk</h1>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-chart-line"></i> Grafik Barang Masuk
                            </div>
                            <div class="card-body">
                                <canvas id="chartMasuk" width="100%" height="30"></canvas>
                            </div>
                        </div>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Data</li>
                        </ol>
                        <div class="card mb-4">
                            <button type="button" class="btn btn-primary btn-custom" data-bs-toggle="modal" data-bs-target="#myModal">
                            Barang Masuk
                            </button>
                            <form method="post">
                                <input type="date" name="tgl_mulai" class form-control>
                                <input type="date" name="tgl_selesai" class form-control>
                                <button type="submit" name="filter_tgl" class="btn btn-info">Filter</button>
                            </form>

                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Keterangan</th>
                                            <th>Penerima</th>
                                            <th>Quantity</th>
                                            <th>Foto</th>
                                            <th>Aksi</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        if(isset($_POST['filter_tgl'])){
                                            $mulai = $_POST['tgl_mulai'];
                                            $selesai = $_POST['tgl_selesai'];
                                            if($mulai!=null || $selesai!=null){
                                                $ambilsemuadatastok = mysqli_query($conn, "select * from masuk m, stok s where s.id_barang = m.id_barang 
                                            and tanggal_masuk BETWEEN '$mulai' and DATE_ADD('$selesai', INTERVAL 1 DAY) order by id_masuk DESC");
                                            }else{
                                                $ambilsemuadatastok = mysqli_query($conn, "select * from masuk m, stok s where s.id_barang = m.id_barang");
                                            }
                                            
                                        } else{
                                            $ambilsemuadatastok = mysqli_query($conn, "select * from masuk m, stok s where s.id_barang = m.id_barang");
                                        }
                                        
                                        $i = 1;
                                        while($data = mysqli_fetch_array($ambilsemuadatastok)){
                                            $idb = $data['id_barang'];
                                            $idm = $data['id_masuk'];
                                            $tanggal_masuk = $data['tanggal_masuk'];
                                            $nama_barang = $data['nama_barang'];
                                            $penerima = $data['penerima'];
                                            $qty = $data['qty'];
                                            //cek gambar ada atau tidak
                                            $gambar = $data['foto'];
                                            if($gambar==null){
                                                //jika tidak ada gambar
                                                $img = 'No Photo';
                                            }else{
                                                //jika ada gambar
                                               $img = '<a href="images/'.$gambar.'" target="_blank">Lihat Gambar</a>';
                                            }
                                        
                                        ?>



                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $tanggal_masuk; ?></td>
                                            <td><?= $nama_barang; ?></td>
                                            <td><?= $penerima; ?></td>
                                            <td><?= $qty; ?></td>
                                            <td><?= $img; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-aksi" data-bs-toggle="modal" data-bs-target="#update<?= $idm; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <button type="button" class="btn btn-danger btn-aksi" data-bs-toggle="modal" data-bs-target="#hapus<?= $idm; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td> 
                                        </tr>

                                         <!-- Update Modal -->
                                            <div class="modal" id="update<?= $idm; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Update Barang</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                               <form method="post">
                                                <div class="modal-body">
                                                    <input type="text" name="penerima" value="<?= $penerima; ?>" class="form-control" required>
                                                    <br>
                                                    <input type="number" name="qty" value="<?= $qty; ?>" class="form-control" required>
                                                    <br>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                        <input type="hidden" name="id_masuk" value="<?= $idm; ?>">

                                                        <button type="submit" class="btn btn-primary" name="updatebrgmsk">Update</button>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </form>


                                                <!-- Modal footer -->
                                                </div>
                                            </div>
                                            </div>


                                            <!-- Hapus Modal -->
                                            <div class="modal" id="hapus<?= $idm; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Hapus Barang</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <form method="post">
                                                    <div class="modal-body">
                                                        Apakah anda yakin ingin menghapus <?= $nama_barang; ?> ?
                                                        <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                        <input type="hidden" name="qty" value="<?= $qty; ?>">
                                                        <input type="hidden" name="id_masuk" value="<?= $idm; ?>">
                                                        <br>
                                                        <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="hapusbrgmsk">Hapus</button>
                                                        <br>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                        </div>

                                                    </div>
                                                </form>

                                                <!-- Modal footer -->
                                                </div>
                                            </div>
                                            </div>

                                        <?php
                                        };
                                        
                                        ?>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
        <script>
        var ctx = document.getElementById("chartMasuk").getContext("2d");
        var chartMasuk = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($tanggalMasuk) ?>,
                datasets: [{
                    label: 'Jumlah Barang Masuk',
                    data: <?= json_encode($totalQty) ?>,
                    fill: true,
                    borderWidth: 2,
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0, 123, 255, 0.25)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        </script>
    </body>
    <!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Barang Masuk</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
    <form method="post">
        <div class="modal-body">
            <select name="barangnya" class="form-select">
                <?php
                    $ambilsemuadatanya = mysqli_query($conn,"select * from stok");
                    while($fetcharray = mysqli_fetch_array($ambilsemuadatanya)){
                        $namabarangnya = $fetcharray['nama_barang'];
                        $idbarangnya = $fetcharray['id_barang'];
                ?>
                    <option value="<?= $idbarangnya; ?>"><?= $namabarangnya; ?></option>
                <?php
                    }
                ?>
            </select>
            <br>
            <input type="number" name="qty" class="form-control" placeholder="Quantity" required>
            <br>
            <input type="text" name="penerima" class="form-control" placeholder="Penerima" required>
            <br>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="barangmasuk">Submit</button>
            <br>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
             </div>

        </div>
    </form>

      <!-- Modal footer -->
    </div>
  </div>
</div>

</html>

<style>
.btn-custom {
  width: 150px;
  height: 45px;
  border-radius: 8px; /* biar sudutnya lembut */
  font-weight: 500;
}
</style>
</html>

<?php
include('koneksi.php');
include('cek.php');

// QUERY DATA UNTUK CHART
$ambil = mysqli_query($conn, "SELECT nama_barang, stock FROM stok");
$namaBarang = [];
$stokBarang = [];

while ($row = mysqli_fetch_assoc($ambil)) {
    $namaBarang[] = $row['nama_barang'];
    $stokBarang[] = $row['stock'];
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
        <title>Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            a{
                text-decoration: none;
                color: black;
            }
        </style>
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
                        <h1 class="mt-4">Stok Barang</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <div class="card mb-4">
                            <button type="button" class="btn btn-primary btn-custom" data-bs-toggle="modal" data-bs-target="#myModal">
                            Tambah Barang
                            </button>
                            <a type="button" href="export.php" class="btn btn-info btn-custom" >
                            Export Data
                            </a>
                            <button type="button" class="btn btn-success btn-custom" id="showChartBtn">
                                Lihat Grafik Stok
                            </button>

                            <div class="card-body">
                            <?php
                            $ambildatastok = mysqli_query($conn, "select * from stok where stock < 1");
                            while($fetch = mysqli_fetch_array($ambildatastok)){
                                $barang = $fetch['nama_barang'];
                            

                            ?>
                            <div class="alert alert-warning alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <strong>Perhatian!</strong> Stok <?= $barang; ?> telah habis!
                            </div>

                            <?php
                            }
                            ?>
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Deskripsi</th>
                                            <th>Stok</th>
                                            <th>Foto</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ambilsemuadatastok = mysqli_query($conn, "select * from stok");
                                        $i = 1;
                                        while($data = mysqli_fetch_array($ambilsemuadatastok)){
                                            $nama_barang = $data['nama_barang'];
                                            $deskripsi = $data['deskripsi'];
                                            $stock = $data['stock'];
                                            $idb = $data['id_barang'];

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
                                            <td><strong><a href="detail.php?id=<?= $idb; ?>"><?= $nama_barang; ?></a></strong></td>
                                            <td><?= $deskripsi; ?></td>
                                            <td><?= $stock; ?></td>
                                            <td><?= $img; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning btn-aksi" data-bs-toggle="modal" data-bs-target="#update<?= $idb; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                <button type="button" class="btn btn-danger btn-aksi" data-bs-toggle="modal" data-bs-target="#hapus<?= $idb; ?>">
                                                    <i class="fas fa-trash"></i>
                                                </button>

                                            </td>
                                        </tr>

                                           <!-- Update Modal -->
                                            <div class="modal" id="update<?= $idb; ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Update Barang</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <!-- Modal body -->
                                                <form method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <input type="text" name="nama_barang" value="<?= $nama_barang; ?>" class="form-control" required>
                                                        <br>
                                                        <input type="text" name="deskripsi" value="<?= $deskripsi; ?>" class="form-control" required>
                                                        <br>
                                                        <input type="file" name="file" class="form-control">
                                                        <br>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="idb" value="<?= $idb; ?>">
                                                        <button type="submit" class="btn btn-primary" name="updatebrg">Update</button>
                                                        <br>
                                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                        </div>

                                                    </div>
                                                </form>

                                                <!-- Modal footer -->
                                                </div>
                                            </div>
                                            </div>


                                            <!-- Hapus Modal -->
                                            <div class="modal" id="hapus<?= $idb; ?>">
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
                                                        <br>
                                                        <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary" name="hapusbrg">Hapus</button>
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
                                <div class="mt-4" id="chartContainer" style="display:none;">
                                    <h3 class="text-center">Grafik Stok Barang</h3>
                                    <canvas id="stokChart"></canvas>
                                </div>
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
            document.getElementById('showChartBtn').addEventListener('click', function() {
                document.getElementById('chartContainer').style.display = 'block';
            });

            var ctx = document.getElementById("stokChart").getContext("2d");
            var stokChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: <?php echo json_encode($namaBarang); ?>,
                    datasets: [{
                        label: 'Jumlah Stok',
                        data: <?php echo json_encode($stokBarang); ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 2
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
        <h4 class="modal-title">Tambah Barang</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
    <form method="post" enctype="multipart/form-data">
        <div class="modal-body">
            <input type="text" name="nama_barang" placeholder="Nama Barang" class="form-control" required>
            <br>
            <input type="text" name="deskripsi" placeholder="Deskripsi barang" class="form-control" required>
            <br>
            <input type="number" name="stock" class="form-control" placeholder="Stock" required>
            <br>
            <input type="file" name="file" class="form-control">
            <br>
            <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="addnew">Submit</button>
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
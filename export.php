<?php
include('koneksi.php');
include('cek.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Stock Barang</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- DATATABLES CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

</head>

<body>
<div class="container mt-4">
    <h2>Stock Bahan</h2>
    <h4>(Inventory)</h4>
    
    <div class="data-tables datatable-dark">

        <table id="mauexport" class="display table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Deskripsi</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $ambilsemuadatastok = mysqli_query($conn, "SELECT * FROM stok");
            $no = 1;
            while($data = mysqli_fetch_array($ambilsemuadatastok)){
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $data['nama_barang']; ?></td>
                    <td><?= $data['deskripsi']; ?></td>
                    <td><?= $data['stock']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>

<!-- Datatables JS & Buttons -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
$(document).ready(function() {
    $('#mauexport').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>

</body>
</html>

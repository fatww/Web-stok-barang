<?php
//untuk mengecek jika ada user yang belum login

if(isset($_SESSION['log'])){

}else {
    header('location:login.php');
}
?>
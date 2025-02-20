<?php
session_start();

// Menghapus session login
session_unset();
session_destroy();

// Redirect ke halaman login setelah logout
header("Location: Masuk.php");
exit();
?>

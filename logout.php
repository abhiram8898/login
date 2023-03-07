<?php require 'connection.php'; ?>
<?php require 'header.php'; ?>

<?php
session_start();
session_destroy();
header("location:index.php");

?>
<?php require 'footer.php'; ?>
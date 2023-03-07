
<?php

$dsn = "mysql:host=localhost;dbname=login";
$username = 'root';
$password = '';
$options = [];
try {
    $connection = new PDO($dsn, $username, $password, $options);
    // echo "Connection succesfull";
} catch (PDOException) {
    // echo "Connection failed";
}
?>
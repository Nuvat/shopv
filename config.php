<?php
// $servername = "bo35vnjsi1uvz3jbrfqu-mysql.services.clever-cloud.com"; //Host o url del server
// $username = "ubt2vsftfwt96m6v";
// $password = "Keg3w3mqayd1kT7m5WDO";
// $dbname = "bo35vnjsi1uvz3jbrfqu"; 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shopv";  

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>

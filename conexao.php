<?php



//ambiente marcosvirgilio.online
$servername = 'mysql-vendacarro-prog3pl.g.aivencloud.com';
$port=26767;
$username = 'avnadmin';
$password = 'AVNS_x-yKrb3iLp8-N2R26Z5';
$dbname = 'vendacarro';

// Create connection
$con = new mysqli($servername, $username, $password, $dbname, $port);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

?>
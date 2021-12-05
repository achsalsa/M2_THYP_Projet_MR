<?php
function bdd_connect_f(){
  $servername = "localhost";
  $username = "root";
  $password = "root";
  $conn="";
  try {
    $conn = new PDO("mysql:host=$servername;dbname=moteur_recherche", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    echo $conn="Connection failed";
  }
  return $conn;
}
?>
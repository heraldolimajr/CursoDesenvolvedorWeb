<?php 
  
  $host = "localhost";
  $user = "root";
  $password = "";
  $dbname = "projetoweb";

  $conn = new PDO("mysql:host=".$host.";dbname=".$dbname,$user,$password);

  if(!$conn){
    echo "A conexão falhou!";
  }

?>

<?php 
  include "../connection.php";
  $nome = "João da Silva";
  $login = "admin";
  //A função md5() criptografa a senha
  $senha = md5("admin123");
  $sql = "INSERT INTO usuarios (nome, login, senha) VALUES (:nome, :login, :senha)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam( ':nome', $nome );
  $stmt->bindParam( ':login', $login );
  $stmt->bindParam( ':senha', $senha );    
  $result = $stmt->execute(); 

  if ($result){
    echo "<h4>Usuário $nome cadastrado com sucesso!</h4>";
  }else{
    echo "<h4>Usuário não cadastrado...</h4>";
  }
?>



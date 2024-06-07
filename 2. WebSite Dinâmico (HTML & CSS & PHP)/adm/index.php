<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Heraldo Gonçalves">
    <title>WebExemplo Cursos</title>
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <style>
      .form-signin{
        width: 300px;
        margin: 0 auto;
        margin-top: 100px;
      }
    </style>

  </head>
 <body class="text-center">
 <div class="container">  
<main class="form-signin">
  <?php
    include_once("../connection.php");
    $entrar = filter_input(INPUT_POST,'entrar', FILTER_SANITIZE_STRING);
    if(!empty($entrar)){
      $usuario = filter_input(INPUT_POST,'usuario', FILTER_SANITIZE_STRING);
      $senha = filter_input(INPUT_POST,'senha', FILTER_SANITIZE_STRING);
      //var_dump($usuario);
      //var_dump($senha);
      if(!empty($usuario) AND !empty($senha)){
        $query_usuario = "SELECT * FROM usuarios WHERE login='".$usuario."' LIMIT 1";
        $result_usuario = $conn->prepare($query_usuario);
        $result_usuario->execute();
          if(($result_usuario) AND ($result_usuario->rowCount() != 0)){
            $row_usuario = $result_usuario->fetch(PDO::FETCH_ASSOC);
            if(md5($senha) == $row_usuario['senha']){
              session_start();
              $_SESSION['id'] = $row_usuario['id'];
              $_SESSION['nome'] = $row_usuario['nome'];
              header("Location:painel_home.php");
            }else{
              echo "Senha incorreta!";  
            }
          }else{
            echo "Usuário não cadastrado!";
          }
      }else{
        echo "Os campos usuário e senha são obrigatórios!";
      }
    }
  ?>
  <form method="POST" action="">
    <img class="mb-4" src="../img/logo.png" alt="">
    <h1 class="h3 mb-3 fw-normal">Login</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="floatingInput" placeholder="Usuário" name="usuario">
      <label for="floatingInput">Usuário</label>
    </div>
    <div class="form-floating mt-3">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="senha">
      <label for="floatingPassword">Senha</label>
    </div>

   
    <input class="mt-3 w-100 btn btn-lg btn-primary" type="submit" value="Entrar" name="entrar">
    
  </form>
</main>
</div>

    </html>

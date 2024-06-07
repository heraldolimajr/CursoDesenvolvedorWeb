<?php 
session_start();

if(empty($_SESSION['id']) OR empty($_SESSION['nome'])){
    header("Location:index.php");
}
  include_once '../connection.php';
  $id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_NUMBER_INT);
  $query_curso = "SELECT * FROM cursos WHERE id = ".$id." LIMIT 1";
  $result_curso = $conn->prepare($query_curso);
  $result_curso->execute();
?>
<!doctype html>
  <html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Heraldo Gonçalves">
    <title>WebExemplo Cursos</title>
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link href="../css/style.css" rel="stylesheet">

    <style>

    </style>


    <!-- Custom styles for this template -->
    <link href="css/carousel.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
  </head>
  <body class="d-flex flex-column h-100">

    <div class="container">
      <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
          <img src="../img/logo.png">
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
          <li><a href="painel_home.php" class="nav-link px-2 link-secondary">Página Inicial</a></li>
          <li><a href="painel_cursos.php" class="nav-link px-2 link-secondary">Cursos</a></li>
        </ul>

        <div class="col-md-3 text-end">
          <button type="button" class="btn btn-primary">Sair</button>
        </div>
      </header>
    </div>

    <!-- Begin page content -->
    <main class="flex-shrink-0">
      <div class="container bg-light rounded p-5">
        <?php
          if(($result_curso) AND ($result_curso->rowCount() != 0)){
              $query_delete_curso = "DELETE FROM cursos WHERE id = ".$id;
              $result_delete_curso = $conn->prepare($query_delete_curso);
              $result_delete_curso->execute();
              if($result_delete_curso){
                echo "<h4>Curso deletado com sucesso!</h4>";
                echo "<meta http-equiv='refresh' content='3;url=painel_cursos.php'>";
              }else{
                echo "<h4>ERRO: Não foi possível excluir.</h4>";
                echo "<meta http-equiv='refresh' content='3;url=painel_cursos.php'>";
              }
          }else{
            echo "<h4>ERRO: Não foi possível excluir. Nenhum curso cadastrado para este ID!</h4>";
            echo "<meta http-equiv='refresh' content='3;url=painel_cursos.php'>";
          }
        ?>
      </div>
    </div>
  </main>



  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script><script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script><script src="dashboard.js"></script>


  <!--Faz a página rolar suavemente ao clicar no menu-->
  <script type="text/javascript">
    $('nav a').click(function(e){
      e.preventDefault();
      var id = $(this).attr('href').slice(10),
      targetOffset = $(id).offset().top,
      menuHeight = $('nav').innerHeight();

      console.log(menuHeight);

      $('html, body').animate({
        scrollTop: targetOffset - menuHeight-50
      }, 200);
    });
  </script>

</body>
</html>

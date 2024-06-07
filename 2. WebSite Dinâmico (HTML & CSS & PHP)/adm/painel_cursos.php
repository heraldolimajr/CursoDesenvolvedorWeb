<?php 
session_start();

if(empty($_SESSION['id']) OR empty($_SESSION['nome'])){
    header("Location:index.php");
}
  include_once '../connection.php';
  $query_cursos = "SELECT id, nome, descricao, imagem FROM cursos";
  $result_cursos = $conn->prepare($query_cursos);
  $result_cursos->execute();
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
        <h1>Cursos Cadastrados</h1>
        <hr/>
          <a class="btn btn-primary" href="cad_curso.php">Cadastrar Novo Curso</a>
        <hr/>


        <form>

          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col-1">Id</th>
                <th scope="col-2">Nome</th>
                <th scope="col-6">Descrição</th>
                <th scope="col-1">Imagem</th>
                <th scope="col">Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php
                 if(($result_cursos) AND ($result_cursos->rowCount() != 0)){
                    while ($row_curso = $result_cursos->fetch(PDO::FETCH_ASSOC)) {
                      echo "<tr>
                              <th scope='row'>".$row_curso['id']."</th>
                              <td>".$row_curso['nome']."</td>
                              <td>".$row_curso['descricao']."</td>
                              <td><a href='../img/cursos/".$row_curso['imagem']."' target='_blank'>".$row_curso['imagem']."</a></td>
                              <td>
                                <a href='delete_cursos.php?id=".$row_curso['id']."'><button type='button' class='btn btn-outline-danger' title='Excluir'><i class='bi bi-trash3-fill'></a></i>
                                </button>
                                <a href='edit_curso.php?id=".$row_curso['id']."'><button type='button' class='btn btn-primary' title='Editar'><i class='bi bi-pencil-fill'></i></button></a>
                              </td>
                            </tr>";
                      
                    }
                 }
              ?>
              

            </tbody>
          </table>

        </form>
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

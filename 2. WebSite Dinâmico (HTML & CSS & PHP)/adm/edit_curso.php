<?php
session_start();

if(empty($_SESSION['id']) OR empty($_SESSION['nome'])){
    header("Location:index.php");
}
  include_once("../connection.php");
  $id = filter_input(INPUT_GET,"id", FILTER_SANITIZE_NUMBER_INT);
  $query_curso = "SELECT * FROM cursos WHERE id = ".$id;
  $result_curso = $conn->prepare($query_curso);
  $result_curso->execute();

  if(($result_curso) AND ($result_curso->rowCount() != 0)){
    $row_curso = $result_curso->fetch(PDO::FETCH_ASSOC);
    //var_dump($row_curso);
  }
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
          <li><a href="#" class="nav-link px-2 link-secondary">Página Inicial</a></li>
          <li><a href="#" class="nav-link px-2 link-dark">Cursos</a></li>
        </ul>

        <div class="col-md-3 text-end">
          <button type="button" class="btn btn-primary">Sair</button>
        </div>
      </header>
    </div>

    <!-- Begin page content -->
    <main class="flex-shrink-0">
      <div class="container bg-light rounded p-5">
        <h1>Dados do Curso</h1>
        <hr/>

        <?php
          $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
          //var_dump($dados);
          if(!empty($dados['salvar'])){
            
            if(!isset($dados['destaque'])){
              $destaque = 0;
            }else{
              $destaque = 1;
            }

            $query_atualiza_curso = "UPDATE cursos SET nome=:nome, descricao=:descricao, destaque=:destaque WHERE id=:id";
            $editar_curso = $conn->prepare($query_atualiza_curso);
            $editar_curso->bindParam(":nome", $dados['nome']);
            $editar_curso->bindParam(":descricao", $dados['descricao']);
            $editar_curso->bindParam(":destaque", $dados['destaque']);
            $editar_curso->bindParam(":id", $id);

            
            if($editar_curso->execute()){   
                if(!empty($_FILES['imagem']['name'])){
                  $query_atualiza_imagem = "UPDATE cursos SET imagem=:imagem WHERE id=:id";
                  $editar_imagem = $conn->prepare($query_atualiza_imagem);
                  $editar_imagem->bindParam(":imagem", $_FILES['imagem']['name']);
                  $editar_imagem->bindParam(":id", $id);
                  $editar_imagem->execute();

                  $diretorio = "../img/cursos/";
                  move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$_FILES['imagem']['name']);
                }
                echo "Curso atualizado com sucesso!";
            }else{
              echo "ERRO: Não foi possível atualizar o curso.";
            }

          }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
        <div class="row g-2 mb-3">
              <div class="col-md">
                <div class="form-floating">
                  <input type="text" class="form-control" id="floatingInputGrid" placeholder="Nome do curso" name="nome" value="<?php
                    if(isset($dados['nome'])){echo $dados['nome'];}elseif(isset($row_curso['nome'])){echo $row_curso['nome'];}
                  ?>">
                  <label for="floatingInputGrid">Nome do Curso</label>
                </div>
              </div>
            <div class="col-md">            
              <label class="form-check-label mt-2" for="flexCheckDefault">
              Mostrar nos destaques
              </label>
              <input class="form-check-input mt-3" type="checkbox" value="1" <?php if(isset($dados['destaque'])){ echo "checked";}elseif((!isset($dados)) && ($row_curso['destaque']==1)){echo "checked";}?> id="flexCheckDefault" name="destaque">
            </div>
        </div>
        <div class="row g-2 mb-3">
            <div class="col-md">
              <div class="form-floating">
                <textarea class="form-control" placeholder="Descrição Quem Somos" id="floatingTextarea2" name="descricao" style="height: 100px"><?php if(isset($dados['descricao'])){echo $dados['descricao'];}elseif(isset($row_curso['descricao'])){echo $row_curso['descricao'];}?></textarea>
                <label for="floatingTextarea2">Descrição</label>
              </div>
            </div>
            <div class="col-md">
              <span>Imagem atual: <a href="../img/cursos/<?php if(isset($row_curso['imagem'])){echo $row_curso['imagem'];} ?>" target="_blank"><?php if(isset($row_curso['imagem'])){echo $row_curso['imagem'];} ?></a></span><br>
              <label for="formFile" class="form-label">Alterar Imagem</label>
              <input class="form-control" type="file" name="imagem" id="formFile">
            </div>
        </div>
        <hr/>
        <div class="row g-2">
              <div class="d-grid gap-2 col-6 mx-auto">
                <input type="reset" class="btn btn-outline-secondary" value="Cancelar">
              </div>
              <div class="d-grid gap-2 col-6 mx-auto">
                <input type="submit" class="btn btn-primary" value="Salvar" name="salvar">
              </div>
            </div>

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

<?php
session_start();

if(empty($_SESSION['id']) OR empty($_SESSION['nome'])){
    header("Location:index.php");
}
  include_once("../connection.php");

  
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
          if(!empty($dados['cadastrar'])){
              $empty_input = false;
              $dados = array_map('trim',$dados);
              if((empty($dados['nome'])) OR (empty($dados['descricao'])) OR (empty($_FILES['imagem']['name']))){
                  $empty_input = true;
                  echo "ERRO: Algum campo obrigatório não preenchido!";
              }
              if(!$empty_input){

                $query_curso = "INSERT INTO cursos (nome, descricao, imagem, destaque) VALUES (:nome, :descricao, :imagem, :destaque)";
                $cadastrar_curso = $conn->prepare($query_curso);
                $destaque = 1;
                if(empty($dados['destaque'])){
                  $destaque = 0;
                }
                $cadastrar_curso->bindParam(":nome",$dados['nome']);
                $cadastrar_curso->bindParam(":descricao",$dados['descricao']);
                $cadastrar_curso->bindParam(":imagem",$_FILES['imagem']['name']);
                $cadastrar_curso->bindParam(":destaque",$destaque);
                if($cadastrar_curso->execute()){
                  echo "Curso cadastrado com sucesso!";
                  $diretorio = "../img/cursos/";
                  move_uploaded_file($_FILES['imagem']['tmp_name'], $diretorio.$_FILES['imagem']['name']);
                }else{
                  echo "Erro: Não foi possível cadastrar!";
                }
              }

          }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">
        <div class="row g-2 mb-3">
              <div class="col-md">
                <div class="form-floating">
                  <input type="text" class="form-control" id="floatingInputGrid" placeholder="Nome do curso" name="nome" value="<?php if(isset($dados['nome'])){echo $dados['nome'];}?>">
                  <label for="floatingInputGrid">Nome do Curso</label>
                </div>
              </div>
            <div class="col-md">            
              <label class="form-check-label mt-2" for="flexCheckDefault">
              Mostrar nos destaques
              </label>
              <input class="form-check-input mt-3" type="checkbox" value="1" <?php if(isset($dados['destaque'])){ echo "checked";} ?> id="flexCheckDefault" name="destaque">
            </div>
        </div>
        <div class="row g-2 mb-3">
            <div class="col-md">
              <div class="form-floating">
                <textarea class="form-control" placeholder="Descrição Quem Somos" id="floatingTextarea2" name="descricao" style="height: 100px"><?php if(isset($dados['descricao'])){echo $dados['descricao'];}?></textarea>
                <label for="floatingTextarea2">Descrição</label>
              </div>
            </div>
            <div class="col-md">
              
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
                <input type="submit" class="btn btn-primary" value="Cadastrar" name="cadastrar">
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

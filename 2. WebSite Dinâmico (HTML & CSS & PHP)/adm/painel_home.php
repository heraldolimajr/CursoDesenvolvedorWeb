<?php 
session_start();

if(empty($_SESSION['id']) OR empty($_SESSION['nome'])){
    header("Location:index.php");
}
  include_once '../connection.php';
  $query_home = "SELECT descricao_quemsomos, imagem_quemsomos, texto_contato, mapa_contato, telefone_contato, email_contato FROM info_home LIMIT 1";
  $result_home = $conn->prepare($query_home);
  $result_home->execute();
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
      <header class="d-flex flex-wrap pt-5 align-items-center justify-content-center justify-content-md-between mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
          <img src="../img/logo.png">
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
          <li><a href="painel_home.php" class="nav-link px-2 link-secondary">Página Inicial</a></li>
          <li><a href="painel_cursos.php" class="nav-link px-2 link-secondary">Cursos</a></li>
        </ul>

        <div class="col-md-3 text-end">
          <?php echo "Logado como <b>".$_SESSION['nome']."</b>";?> <a href="sair.php" class="btn btn-primary">Sair</a>
        </div>
      </header>
    </div>

    <!-- Begin page content -->
    <main class="flex-shrink-0 pb-5">
      <div class="container bg-light rounded p-5">
        <h1>Informações da Página Inicial</h1>
        <hr/>
        <?php 

            if(($result_home) AND ($result_home->rowCount() != 0)){
              $row_home = $result_home->fetch(PDO::FETCH_ASSOC);
              //var_dump($row_home);              
            }else{
              echo "<div class='alert alert-danger mt-3 mb-3' role='alert'>
                      ERRO: Nenhum conteúdo cadastrado!
                    </div>";
            }

            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            //var_dump($dados);
            if(!empty($dados['salvar'])){
              $empty_input = false;
              $dados = array_map('trim', $dados);
              if(in_array("", $dados)){
                $empty_input = true;
                echo "Erro: Algum campo está vazio!";
              }
              if(!$empty_input){

              $imagem = $_FILES['imagem_quemsomos']['name'];

              $query_update_home = "UPDATE info_home SET descricao_quemsomos=:descricao_quemsomos, imagem_quemsomos=:imagem_quemsomos, texto_contato=:texto_contato, mapa_contato=:mapa_contato, telefone_contato=:telefone_contato, email_contato=:email_contato";
              $update_home = $conn->prepare($query_update_home);
              $update_home->bindParam(':descricao_quemsomos', $dados['descricao_quemsomos']);
              $update_home->bindParam(':imagem_quemsomos', $imagem);
              $update_home->bindParam(':texto_contato', $dados['texto_contato']);
              $update_home->bindParam(':mapa_contato', $dados['mapa_contato']);
              $update_home->bindParam(':telefone_contato', $dados['telefone_contato']);
              $update_home->bindParam(':email_contato', $dados['email_contato']);
              if($update_home->execute()){
                  echo "Dados atualizados com sucesso!";
                  $diretorio = "../img/";
                  move_uploaded_file($_FILES['imagem_quemsomos']['tmp_name'], $diretorio.$imagem);
              }else{
                  echo "Não foi possível atualizar os dados!";
              }
            }
            }


        ?>
        <form method="POST" action="#" enctype="multipart/form-data">
          <div class="row g-2">
            <h4>Quem Somos</h4>
            <hr/>
            <div class="col-md">
              <div class="form-floating">
                <textarea class="form-control" placeholder="Descrição Quem Somos" id="floatingTextarea2" style="height: 100px" name="descricao_quemsomos" required><?php 
                    if(isset($dados['descricao_quemsomos'])){
                      echo $dados['descricao_quemsomos'];
                    }elseif(isset($row_home['descricao_quemsomos'])){
                      echo $row_home['descricao_quemsomos'];
                    } 
                  ?></textarea>
                <label for="floatingTextarea2">Descrição Quem Somos </label>
              </div>
            </div>
            <div class="col-md">
              <span>Imagem atual: <a href="../img/<?php if(isset($row_home['imagem_quemsomos'])){echo $row_home['imagem_quemsomos'];}?>" target="_blank"><?php if(isset($row_home['imagem_quemsomos'])){echo $row_home['imagem_quemsomos'];}?></a></span><br>
              <label for="formFile" class="form-label">Alterar Imagem</label>
              <input class="form-control" type="file" id="formFile" name="imagem_quemsomos">
            </div>

            <div class="row g-2">
              <h4>Contato</h4>
              <hr/>
              <div class="col-md">
                <div class="form-floating">
                  <textarea class="form-control" placeholder="Descrição Quem Somos" id="floatingTextarea2" style="height: 100px" name="texto_contato"><?php 
                  if(isset($dados['texto_contato'])){
                    echo $dados['texto_contato'];
                  }elseif(isset($row_home['texto_contato'])){echo $row_home['texto_contato'];} 
                  ?></textarea>
                  <label for="floatingTextarea2">Descrição Contato </label>
                </div>
              </div>  

              <div class="col-md">
                <div class="form-floating">
                  <textarea class="form-control" placeholder="Descrição Quem Somos" id="floatingTextarea2" style="height: 100px" name='mapa_contato'><?php if(isset($dados['mapa_contato'])) {
                      echo $dados['mapa_contato'];
                  }elseif(isset($row_home['mapa_contato'])){echo $row_home['mapa_contato'];} ?></textarea>
                  <label for="floatingTextarea2">Mapa Contato </label>
                </div>
              </div> 
            </div>
            <div class="row g-2">
              <div class="col-md">
                <div class="form-floating">
                  <input type="email" class="form-control" id="floatingInputGrid" placeholder="name@example.com" name="email_contato" value=" <?php 
                  if(isset($dados['email_contato'])){
                    echo $dados['email_contato'];
                  }elseif(isset($row_home['email_contato'])){echo $row_home['email_contato'];} ?>">
                  <label for="floatingInputGrid">E-mail</label>
                </div>
              </div>
              <div class="col-md">
                <div class="form-floating">
                  <input type="tel" class="form-control" id="floatingInputGrid" placeholder="name@example.com" name="telefone_contato" value=" <?php if(isset($dados['telefone_contato'])){
                       echo $dados['telefone_contato'];
                      }elseif(isset($row_home['telefone_contato'])){echo $row_home['telefone_contato'];} ?>">
                  <label for="floatingInputGrid">Telefone</label>
                </div>
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

<?php
  include_once "connection.php";

  $query_info_home = "SELECT * FROM info_home";
  $result_info_home = $conn->prepare($query_info_home);
  $result_info_home->execute();
  $row_info_home = $result_info_home->fetch(PDO::FETCH_ASSOC);
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
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/carousel.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

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

  </head>
  <body class='py-0'>

    <header>
      <div class="navbar blue-top navbar-expand-lg navbar-dark bg-blue fixed-top py-1" aria-label="Tenth navbar example">

        <div class=" container-fluid justify-content-md-center" id="navbarsExample08">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#"><img src="img/icon-mail.png"> <?php echo $row_info_home['email_contato'] ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><img src="img/icon-phone.png"> <?php echo $row_info_home['telefone_contato']?></a>
            </li>

          </ul>
        </div>

      </div>

      <nav class="navbar navbar-expand-lg navbar-dark bg-yellow fixed-top mt-5 py-3" aria-label="Eighth navbar example">
        <div class="container">
          <a class="navbar-brand" href="#"><img src="img/logo.png"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarsExample07">
            <ul class="navbar-nav w-100 justify-content-end">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="index.php#inicio">Início</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="index.php#quemsomos">Quem Somos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="index.php#cursos">Cursos</a>
              </li>
              <li class="nav-item">
                <a class="nav-link"href="index.php#contato">Contato</a>
              </li>
            </ul>

          </div>
        </div>
      </nav>

    </header>
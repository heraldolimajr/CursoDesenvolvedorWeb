<?php 
include "header.php";

$query_cursos_destaque = "SELECT * FROM cursos WHERE destaque=1";
$result_cursos_destaque = $conn->prepare($query_cursos_destaque);
$result_cursos_destaque->execute();

$query_cursos = "SELECT id, nome, imagem FROM cursos";
$result_cursos = $conn->prepare($query_cursos);
$result_cursos->execute();

?>

<main class='pt-5'>
  <section id="inicio"> 
    <div id="myCarousel" class="carousel slide mt-5" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">

        <?php
          if(($result_cursos_destaque) AND ($result_cursos_destaque->rowCount() != 0)){
            $count = 0;
            while($row_cursos_destaque = $result_cursos_destaque->fetch(PDO::FETCH_ASSOC)){

            ?>

             <div class="carousel-item <?php if($count==0) echo 'active'?>">
              <a href="curso.php?id=<?php echo $row_cursos_destaque['id']?>"><img class="img-fluid" src="img/cursos/<?php echo $row_cursos_destaque['imagem']?>"></a>            
            </div>

            <?php
              $count++;
            }
          }else{
          echo "<h3>Nenhum curso encontrado...</h3>";
        }
        ?>
       

      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>

  <div class='container'>

    <section id="quemsomos">
      <div class="row featurette" >
        <div class="col-md-7">
          <h2 class="featurette-heading">Quem Somos</h2>
          <p class="lead"><?php echo $row_info_home['descricao_quemsomos']?></p>
        </div>
        <div class="col-md-5">
          <img src="img/<?php echo $row_info_home['imagem_quemsomos']?>" class='img-fluid'>

        </div>
      </div>
    </section>

  </div><!-- /.container -->

  <section id="cursos">
    <div class='cursos bg-light py-5 my-5'>
      <div class='container'>
        <h2 class="titulo text-center mb-5">Cursos</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4">

          <?php 
            if(($result_cursos) AND ($result_cursos->rowCount() != 0)){
              while ($row_cursos = $result_cursos->fetch(PDO::FETCH_ASSOC)) {
                ?>

                  <div class="col">
                    <div class="card">
                      <a href="curso.php?id=<?php echo $row_cursos['id']?>"><img src="img/cursos/<?php echo $row_cursos['imagem']?>" class='img-fluid'>
                        <div class="card-body">
                          <h5 class="card-title text-center"><?php echo $row_cursos['nome']?></h5>                
                        </div></a>
                      </div>
                    </div>

                <?php
              }
            }else{
          echo "<h3>Nenhum curso encontrado...</h3>";
        }

          ?>
          

                  </div>

                </div>
              </section>

              <section id="contato">
                <div class='contato py-5 my-5'  id="contato">
                  <div class='container'>
                    <div class="row featurette">
                      <div class="col-lg-6">
                        <h2 class="titulo">Contato</h2>
                        <p class="lead"> <?php echo $row_info_home['texto_contato']?></p>  

                        <iframe class="mt-3" src="<?php echo $row_info_home['mapa_contato']?>" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>      

                      </div>
                      <div class="col-lg-6">
                        <form>
                          <div class='form-contato py-4 px-4'>
                            <div class="mb-3">
                              <label for="inputNome" class="form-label">Nome</label>
                              <input type="text" class="form-control" id="inputNome">
                            </div>
                            <div class="mb-3">
                              <label for="inputEmail" class="form-label">E-mail</label>
                              <input type="email" class="form-control" id="inputEmail">
                            </div>
                            <div class="mb-3">
                              <label for="inputMensagem" class="form-label">Mensagem</label>
                              <textarea class="form-control" id="inputMensagem" rows="3"></textarea>
                            </div>
                            <input type="submit" class="btn btn-primary w-100">
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </main>


          <?php 
          include "footer.php";
        ?>

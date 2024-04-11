<?php 
  include "header.php";

  $id = $_GET['id'];

  if(empty($id)){
    header("Location:index.php");
  }

  $query_cursos = "SELECT * FROM cursos WHERE id=$id";
  $result_cursos = $conn->prepare($query_cursos);
  $result_cursos->execute();
  $row_cursos = $result_cursos->fetch(PDO::FETCH_ASSOC);

?>


    <main class='pt-5 mt-5'>    

      <div class='container my-5'>
      <?php
        if(($result_cursos) AND ($result_cursos->rowCount() != 0)){
      ?>

        <div class="row featurette">
          <div class="col-md-12">
            <img src="img/cursos/<?php echo $row_cursos['imagem']?>" class='img-fluid'>

          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <h2 class="featurette-heading text-center pb-5 pt-0"><?php echo $row_cursos['nome']?></h2>        
            <p class="lead"><?php echo $row_cursos['descricao']?></p>
          </div>
        </div>


      <?php
        }else{
          echo "<h3>Nenhum curso encontrado...</h3>";
        }
      ?>

      </div><!-- /.container -->


       </main>

     
<?php 
  include "footer.php";
?>

<?php
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//INICIO UNA SESSION
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
session_start();

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//SI NO HAY UNA SESSION INICIADA EN $_SESSION['usuario'] ME REDIRECCIONA A EL LOGIN 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (!isset($_SESSION['usuario'])) {
  header("location: login/index.html");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <title>PHP CRUD usando PDO y Bootstrap/Modal</title>
  <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="bootstrap/css/custom.css">
  <link rel="stylesheet" type="text/css" href="bootstrap/css/font-awesome.css">
</head>

<body >
  <div class="container">
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
      <a class="navbar-brand" href="code.html" target="_blank">AnthonCode</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02"
        aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="https://www.youtube.com/channel/UCoBEy_rD5FsKHFHtTPTimjQ/videos?spfreload=10"
              target="_blank">Más Proyectos</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" id="download"
              aria-expanded="false">Redes Sociales <span class="caret"></span></a>
            <div class="dropdown-menu" aria-labelledby="download">
              <a class="dropdown-item" href="https://www.facebook.com/AnthonCode" target="_blank">facebook</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="https://www.youtube.com/c/AnthonCode" target="_blank">youtube</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="https://AnthonCode.blogspot.com" target="_blank">Blog</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://facebook.com/anthoncode" target="_blank"><i
                class="fa fa-facebook-official"></i> Like</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-warning" href="code.html" target="_blank"><i class="fa fa-code"></i>
              Sistemas en PHP</a>
        </ul>
        <a href="login/cerrarsession.php"><input type="button" class="btn btn-warning" value="cerrar session"></a>
      </div>
    </nav>
    <h1 class="page-header text-center">PHP CRUD usando PDO</h1>
    <div class="row">
      <div class="col-sm-12">
        <a href="#addnew" class="btn btn-primary" data-toggle="modal"><span class="fa fa-plus"></span> Nuevo</a>
        <a href="#addnewdifusion" class="btn btn-primary" data-toggle="modal"><span class="fa fa-plus"></span>
          Nueva
          difusión</a>

        <?php
            
            if (isset($_SESSION['message'])) {
                ?>
        <div class="alert alert-dismissible alert-success" style="margin-top:20px;">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <?php echo $_SESSION['message']; ?>
        </div>
        <?php

                unset($_SESSION['message']);
            }
            ?>
        <table class="table table-bordered table-striped" style="margin-top:20px;">
          <?php $privi = $_SESSION['privilegio']; ?>
          <thead>
            <th>ID</th>
            <th>Usuario</th>

            <th>Detalle</th>
            <th>fecha y hora</th>
            <th>Estado</th>
            <?php 
                if ($privi == 0) {
                    echo "<th>Acción</th>";
                }elseif ($privi == 1) {
                    
                }
                ?>
          </thead>
          <tbody>
            <?php
                   // incluye la conexión
                   include_once('connection.php');
                   //echo $_SESSION['privilegio'];
   
                   $database = new Connection();
                   $db = $database->open();
                   $contador = 0;
                   $array=[];
                   try {
                     $sql = "SELECT * FROM members ORDER BY id desc";
                     //$sql = 'SELECT * FROM members ORDER BY id desc limit 3';
                     if ($_SESSION['privilegio'] == 0) {
                       $privi = $_SESSION['privilegio'];
                       foreach ($db->query($sql) as $row) {
                               
                               array_push($array, $row['estado']);
                               $items= $row['estado']."".(string)$contador
                               ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['usuario']; ?></td>
              <td><?php echo $row['detalle']; ?></td>
              <td><?php echo $row['fechaHora']; ?></td>

              <td id="<?php echo $items; ?>"><?php echo $row['estado']; ?></td>

              <td>
                <a href="#edit_<?php echo $row['id']; ?>" class="btn btn-success btn-sm" data-toggle="modal"><span
                    class="fa fa-edit"></span> Editar</a>
                <a href="#delete_<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" data-toggle="modal"><span
                    class="fa fa-trash"></span> Eliminar</a>

                <!-- CHAT BUTTON -->
                <a href="chat_ajax/index.php" class="btn btn-primary btn-sm">Chat!</a>

              </td>
              <?php include('edit_delete_modal.php'); ?>
            </tr>
            <?php $contador+=1; ?>

            <?php
                        }
                    }elseif ($_SESSION['privilegio'] == 1) {
                        $privi = $_SESSION['privilegio'];
                        foreach ($db->query($sql) as $row) {
                            ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['usuario']; ?></td>
              <td><?php echo $row['detalle']; ?></td>
              <td><?php echo $row['fechaHora']; ?></td>
              <td id="<?php echo $row['estado']; ?>"><?php echo $row['estado']; ?></td>

            </tr>
            <?php
                        }
                    }
                    
                } catch (PDOException $e) {
                    echo "There is some problem in connection: " . $e->getMessage();
                }

                //cerrar conexión
                $database->close();

                ?>
          </tbody>
        </table>

      </div>
      <?php include('add_modal.php'); ?>
      <script src="bootstrap/js/jquery.min.js"></script>
      <script src="bootstrap/js/bootstrap.js"></script>
      <script src="bootstrap/js/custom.js"></script>
</body>
<script>
//https://stackoverflow.com/questions/6621231/passing-php-variable-in-onclick-function
/* function viewData() {
  $.ajax({
    type: "GET",
    url: "http://localhost/chatticketsmuni/crud_pdo/ajax_index.php",
    success: function(response) {

      console.log("sadsad")

      const sda2 = JSON.parse(response)
      const sda = sda2.reverse();
      for (const [key, value] of Object.entries(sda)) {
        //console.log(value+key);

        if (value == 'finalizado') {
          // console.log("finalizado")
          $('#' + value + key).html(value).css('background-color', '#c1d5e0');

        } else if (value == 'curso') {
          //console.log(value+key)
          $('#' + value + key).html("en curso").css('background-color', '#64dd17');

        } else if (value == 'pendiente') {
          // console.log("pendiete")
          $('#' + value + key).html(value).css('background-color', '#ffd600');

        } else if (value == 'cancelado') {
          //console.log("cancelado")
          $('#' + value + key).html(value).css('background-color', '#ff5252');
        }
      }

      //});  
    },
    error: function() {
      alert("Error");
    }
  });
} */
/* setInterval(function() {
  viewData();
}, 1300); */
//https://material.io/resources/color/#!/?view.left=0&view.right=0&primary.color=FF5252
</script>

</html>
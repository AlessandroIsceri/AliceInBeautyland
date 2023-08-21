<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizza le categorie</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/757bd903a3.js"></script>
    <link rel="icon" href="../../../../images/logo.png">
</head>
<body>
<!--Barra di navigazione-->
<?php
    $posizione = -2;
    //require('../../../static/php/funzioni.php');
    include('../../../static/navbar.php');
    if(isset($_SESSION['email'])&&($_SESSION['ruolo'] == 'admin'))
    {
        
    ?>
    <br>
    <div class="container">
      <a href="../../gestioneShop.php">
        <i class="fa fa-angle-double-left fa-3x" style="color:#ff33cc;">Gestione shop</i>
      </a>
      <br>
      <?php
        $percorsoFile = "../../../../images/categorieProdotti/";
        //connessione al db
        $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
        $query = "SELECT * FROM categoria";  //prendo dati categoria
        $risCategoria = mysqli_query($link,$query) or die("Impossibile eseguire query categoria");
        
        $i = 0;
        //stampo categoria
        while($rigaCategoria = mysqli_fetch_array($risCategoria))
        {
            $nomeCategoria = $rigaCategoria['nome'];
            $codCategoria = $rigaCategoria['codCategoria'];
            $nomeFoto = $rigaCategoria['nomeFoto'];
            if($i % 3 == 0)
                echo '<div class="row">';
            echo '<div class="col-md-3 my-3 mx-auto">';
            echo '<img src="'.$percorsoFile.$nomeFoto.'" width="200vh" height="200vh"><br>';
            echo 'Nome Categoria: '.$nomeCategoria;
            echo '<br>';
            echo '</div>';

            $i++;
            if($i % 3 == 0)
                echo '</div>';
        }
        mysqli_close($link);
    }
    else
    {
        echo 'Utente non riconosciuto';
    }
    ?>
    </div>
    </body>
<script src="./scripts/modifica.js"></script>
<link rel="stylesheet" href="../../../static/style.css">
</html>
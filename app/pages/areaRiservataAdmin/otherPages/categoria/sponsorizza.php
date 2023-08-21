<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sponsorizza categoria</title>
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
        $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
        if(!isset($_POST['aggiorna']))
        {
            $percorsoFile = "../../../../images/categorieProdotti/";
            //connessione al db
            $query = "SELECT * FROM categoria";  //prendo dati categoria
            $risCategoria = mysqli_query($link,$query) or die("Impossibile eseguire query categoria");
            $i = 0;
            echo '<form method="POST">';
            //stampo categorie disponibili
            while($rigaCategoria = mysqli_fetch_array($risCategoria))
            {
                $nomeCategoria = $rigaCategoria['nome'];
                $codCategoria = $rigaCategoria['codCategoria'];
                $checked = $rigaCategoria['sponsor'];
                $nomeFoto = $rigaCategoria['nomeFoto'];
                if($i % 3 == 0)
                    echo '<div class="row">';
                echo '<div class="col-md-3 my-3 mx-auto">';
                echo '<img src="'.$percorsoFile.$nomeFoto.'" width="200vh" height="200vh"><br>';
                echo 'Nome Categoria: '.$nomeCategoria;
    
                //stampo checkbox
                echo '<label class="checkContainer">Sponsorizzato';
                echo '<input type="checkbox" onchange="controllaMassimo();" name="sponsor[]" value="'.$codCategoria.'"';
                if($checked == 1)
                    echo ' checked';
                echo '>';
                echo '<span class="checkmark"></span></label>';
                echo '<br>';
                echo '</div>';
    
                $i++;
                if($i % 3 == 0)
                    echo '</div>';
            }
            echo '</div>';
            echo '<br>';
            echo '<input type="hidden" name="aggiorna">';
            echo '<div class="row"><div class="col-md-3 my-3 mx-auto"><button type="button" onclick="checkForm(this.form);" class="btn btn-dark bottoneHome">Aggiorna</button></div></div>';
            echo '</form>';
        }
        else
        {
            $sponsorizzati = $_POST['sponsor'];
            //tolgo tutti gli sponsor
            $query = "UPDATE categoria SET sponsor = 0";
            mysqli_query($link,$query);

            //$sponsorizzati e un array che contiene i codici categoria delle categorie da sponsorizzare
            foreach($sponsorizzati as $codCategoria)
            {
                $query = "UPDATE categoria SET sponsor = 1 WHERE codCategoria = $codCategoria";
                mysqli_query($link,$query);
            }
        }
        mysqli_close($link);
        echo '<br><div class="container">L\'operazione &egrave; andata a buon fine.<br><br><div class="row">';
        echo '<div class="col-12 mx-auto" style="text-align:center"><a href="../../index.php"><button class="btn btn-dark bottoneHome" type="button">Torna alla home</button></a></div></div></div>';
    }
    else
    {
        echo 'Utente non riconosciuto';
    }
    ?>
    </div>
    </body>
<script src="./scripts/sponsorizza.js"></script>
<link rel="stylesheet" href="../../../static/style.css">
<link rel="stylesheet" href="./styles/sponsorizza.css">
</html>
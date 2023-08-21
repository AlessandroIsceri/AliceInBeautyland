<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica gli appuntamenti</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/757bd903a3.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
    <link rel="icon" href="../../../../images/logo.png">
</head>
<body>
    <!--Barra di navigazione-->
    <?php
    $posizione = -2;
    include('../../../static/navbar.php');
    if(isset($_SESSION['email'])&&($_SESSION['ruolo'] == 'admin'))
    {        
        require('./scripts/stampaPrenotazioni.php');
    ?>
    <br>
    <div class="container">
        <a href="../../gestioneAppuntamenti.php">
            <i class="fa fa-angle-double-left fa-3x" style="color:#ff33cc;">Gestione appuntamenti</i>
        </a>
        <br> <br>
        <?php
        if(!isset($_POST['visualizza'])&&(!isset($_POST['elimina'])))
        {
        ?>
        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="POST">  
            <div class="row">
                <div class="col-12 mx-auto">
                    Seleziona la data
                    <input type="date" min="<?php echo date('Y-m-d');?>" name="data" required>
                </div>
                <br>
                <div class="col-12 mx-auto">
                    <button type="submit" name="visualizza" class="btn btn-dark bottoneHome">Visualizza</button>
                </div>
            </div>
        </form>
        <?php
        }
        else if(isset($_POST['visualizza']))
        {
            //connessione al db
            $data = $_POST['data'];
            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
            stampaAppuntamenti($link,$data,'modifica');
            mysqli_close($link);
        }
        else
        {
            //rimuovo l'appuntamento e mando una mail
            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
            $query = "DELETE FROM prenota WHERE codPrenotazione =".$_POST['elimina'];
            mysqli_query($link,$query);
            mysqli_close($link);
        }
    }
    else
    {
        echo 'Utente non riconosciuto';
    }
        ?>
    </div>
  </body>
<link rel="stylesheet" href="../../../static/style.css">
<script src = "./scripts/modifica.js"></script>
<style>
    tr,th,thead,tbody,.table thead th {
    border-bottom: 2px solid #ff33cc; 
    }
</style>
</html>
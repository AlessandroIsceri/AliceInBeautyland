<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica profilo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/757bd903a3.js"></script>
    <link rel="icon" href="../../images/logo.png">
</head>
<body>
    <?php
        include('../static/navbar.php');
        if(!isset($_SESSION['email']))
            echo 'Effettua il login per accedere a questo contenuto';
        else if(!isset($_POST['modifica']))
        {
            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
            $email = $_SESSION['email'];
            $query = "SELECT * FROM account WHERE email = '$email'";
            $ris = mysqli_query($link,$query);
            $riga = mysqli_fetch_array($ris);
    ?>
    <div class="container">
        <form method="POST">
            <div class="row">
                <div class="col-md-6">
                    Nome:
                    <input type="text" class="form-control" name="nome" value="<?php echo $riga['nome']; ?>">
                </div>
                <div class="col-md-6">
                    Cognome:
                    <input type="text" class="form-control" name="cognome" value="<?php echo $riga['cognome']; ?>">
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-3">
                    Citt&agrave;:
                    <input type="text" class="form-control" name="citta" value="<?php echo $riga['citta']; ?>">
                </div>
                <div class="col-md-3">
                    CAP:
                    <input type="number" class="form-control" name="CAP" value="<?php echo $riga['CAP']; ?>">
                </div>
                <div class="col-md-3">
                    Via:
                    <input type="text" class="form-control" name="via" value="<?php echo $riga['via']; ?>">
                </div>
                <div class="col-md-3">
                    Numero civico:
                    <input type="number" class="form-control" name="numeroCivico" value="<?php echo $riga['numeroCivico']; ?>">
                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <button type="submit" name="modifica" class="btn btn-dark bottoneHome">Modifica</button>
            </div>
            <br>
        </form>
    </div> 
    <?php
        mysqli_close($link);
        }else if(isset($_POST['modifica']))
        {
            $email = $_SESSION['email'];
            //invio il form
            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
            $email = $_SESSION['email'];
            $nome = ripulisciDato('nome');
            $cognome = ripulisciDato('cognome');
            $citta = ripulisciDato('citta');
            $CAP = ripulisciDato('CAP');
            $nCivico = ripulisciDato('numeroCivico');
            $via = ripulisciDato('via');
            $query = "UPDATE account SET nome = '$nome', cognome = '$cognome',citta = '$citta',CAP = $CAP,numeroCivico = $nCivico,via = '$via' WHERE email = '$email'";
            mysqli_query($link,$query);
            mysqli_close($link);
            $_SESSION['nome'] = $nome;
        }
        //footer
        include('../static/footer.html');
    ?>
    <link rel="stylesheet" href="./styles/home.css">
    <link rel="stylesheet" href="../static/style.css">
    <script src="./scripts/home.js"></script>
</body>
</html>
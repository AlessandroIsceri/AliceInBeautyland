<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione appuntamenti</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/757bd903a3.js"></script>
    <link rel="icon" href="../../images/logo.png">
</head>
<body style="height:100%;width:100%;">
    <!--Barra di navigazione-->
    <?php
        include('../static/navbar.php');
        if(isset($_SESSION['email'])&&($_SESSION['ruolo'] == 'admin'))
        {
            //stampo la pagina
            
    ?>
    <div style="background-image:url('../../images/backgrounds/trattamenti2.jpg');width:100%;height:100%;position:absolute;z-index:-1;">
    </div>
    <br><br>
    
    <div class="container" style="background-color:rgba(255,255,255,0.8)">
    <h3 style="text-align:center">Sezione admin, gestione dei trattamenti</h3>
    <br>
        <a href="./index.php">
            <i class="fa fa-angle-double-left fa-3x" style="color:#ff33cc;">Home</i>
        </a><br><br>
        <h3>Gestione appuntamenti
            <a data-toggle="collapse" href="#appuntamenti" role="button" aria-expanded="false" aria-controls="appuntamenti">
                <img src="../../images/icons/plus.png" height="30vh" width="30vh" class="image" onclick="gira(this);">
            </a>
        </h3>
        <div class="collapse" id="appuntamenti">
        <p>Da queste sezioni potrai visualizzare o gestire gli appuntamenti di oggi o dei prossimi giorni.</p>
            <div class="row">
                <div class="col-auto my-3">
                    <a href="./otherPages/appuntamenti/visualizza.php">
                        <button type="button" class="btn btn-dark bottoneHome" >Visualizza gli appuntamenti prenotati</button>
                    </a>
                </div>
                <div class="col-auto my-3">
                    <a href="./otherPages/appuntamenti/modifica.php">
                        <button type="button" class="btn btn-dark bottoneHome" >Modifica gli appuntamenti prenotati</button>
                    </a>
                </div>
            </div>
        </div>

        <br>

        <h3>Gestione trattamenti
            <a data-toggle="collapse" href="#trattamenti" role="button" aria-expanded="false" aria-controls="trattamenti">
                <img src="../../images/icons/plus.png" height="30vh" width="30vh" class="image" onclick="gira(this);">
            </a>
        </h3><br>
        <div class="collapse" id="trattamenti">
            <p>Da queste sezioni potrai aggiungere o modificare i trattamenti che il negozio offre</p>
            <div class="row">
                <div class="col-auto my-3">
                    <a href="./otherPages/trattamenti/inserisci.php">
                        <button type="button" class="btn btn-dark bottoneHome" >Inserisci un nuovo trattamento</button>
                    </a>
                </div>
                <div class="col-auto my-3">
                    <a href="./otherPages/trattamenti/modifica.php">
                        <button type="button" class="btn btn-dark bottoneHome" >Modifica un trattamento</button>
                    </a>
                </div>
                <div class="col-auto my-3">
                    <a href="./otherPages/trattamenti/elimina.php">
                        <button type="button" class="btn btn-dark bottoneHome" >Rimuovi un trattamento</button>
                    </a>
                </div>
                <div class="col-auto my-3">
                    <a href="./otherPages/trattamenti/visualizza.php">
                        <button type="button" class="btn btn-dark bottoneHome" >Visualizza i trattamenti disponibili</button>
                    </a>
                </div>
            </div>
            <br>
        </div>
    </div>
    <?php
        }
        else
        {
            echo 'Utente non riconosciuto';
        }
    ?>
</body>
    <link rel="stylesheet" href="./styles/admin.css">
    <script src="./scripts/admin.js"></script>
    <script src="../static/script.js"></script>
    <link rel="stylesheet" href="../static/style.css">
</html>
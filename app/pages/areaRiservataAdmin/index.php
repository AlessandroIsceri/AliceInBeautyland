<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="icon" href="../../images/logo.png">
</head>
<body>
    <!--Barra di navigazione-->
    <?php
        include('../static/navbar.php');
        if(isset($_SESSION['email'])&&($_SESSION['ruolo'] == 'admin'))
        {
    ?>

    
    <div class="contents">
    <a href="./gestioneAppuntamenti.php">
        <div class="col-md-6 quarter" id="animato">
            <img src="../../images/backgrounds/trattamenti.jpg" height='100%' width='100%' class="sfondo">
            <div class="scritte">
                Gestione appuntamenti
            </div>
        </div>
    </a>

    <a href="./gestioneShop.php">
        <div class="col-md-6 quarter" id="animato">
            <img src="../../images/backgrounds/shop.jpg" height='100%' width='100%' class="sfondo">
            <div class="scritte">
                Gestione shop
            </div>
        </div>
    </a>

    <a href="./otherPages/analitiche/visualizza.php">
        <div class="col-md-6 quarter" id="animato">
            <img src="../../images/backgrounds/analytics.jpg" height='100%' width='100%' class="sfondo">
            <div class="scritte">
                Analytics            
            </div>
        </div>
    </a>

    <a href="./otherPages/valutazioni/elimina.php">
        <div class="col-md-6 quarter" id="animato">
            <img src="../../images/backgrounds/valutazioni.jpg" height='100%' width='100%' class="sfondo">
            <div class="scritte">
                Valutazioni            
            </div>
        </div>
    </a>
</div>
<?php
    }
    else
    {
        echo 'Utente non riconosciuto';
    }
?>
    
</body>
<link rel="stylesheet" href="./styles/index.css">
</html>
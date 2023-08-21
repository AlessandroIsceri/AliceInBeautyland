<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione shop</title>
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
            
    ?>
    <div style="background-image:url('../../images/backgrounds/shop.jpg');width:100%;height:100%;position:absolute;z-index:-1;">
    </div>
    <br><br>
    <div class="container" style="background-color:rgba(255,255,255,0.8)">
    <h3 style="text-align:center">Sezione admin, gestione dello shop</h3><br>
        <a href="./index.php">
            <i class="fa fa-angle-double-left fa-3x" style="color:#ff33cc;">Home</i>
        </a>
        <br><br>
        <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>">
            <h3>Gestione prodotti
                <a data-toggle="collapse" href="#prodotti" role="button" aria-expanded="false" aria-controls="prodotti">
                    <img src="../../images/icons/plus.png" height="30vh" width="30vh" class="image" onclick="gira(this);">
                </a>
            </h3>
            <div class="collapse" id="prodotti">
            <p>Da queste sezioni potrai visualizzare o gestire i prodotti che saranno disponibili sullo shop.</p>
                <div class="row">
                    <div class="col-auto my-3">
                        <a href="./otherPages/prodotto/inserisci.php">
                            <button type="button" name="submit" value="inserisci-prodotto" class="btn btn-dark bottoneHome">Inserisci un nuovo prodotto</button>
                        </a>
                    </div>
                    <div class="col-auto my-3">
                        <a href="./otherPages/prodotto/modifica.php">
                            <button type="button" name="submit" class="btn btn-dark bottoneHome">Modifica un prodotto</button>
                        </a>
                    </div>
                    <div class="col-auto my-3">
                        <a href="./otherPages/prodotto/elimina.php">
                            <button type="button" name="submit" class="btn btn-dark bottoneHome">Rimuovi un prodotto</button>
                        </a>
                    </div>
                    <div class="col-auto my-3">
                        <a href="./otherPages/prodotto/visualizza.php">
                            <button type="button" name="submit" class="btn btn-dark bottoneHome">Visualizza i prodotti disponibili</button>
                        </a>
                    </div>
                </div>
            </div>

            <br>

            <h3>Gestione categorie
                <a data-toggle="collapse" href="#categorie" role="button" aria-expanded="false" aria-controls="categorie">
                    <img src="../../images/icons/plus.png" height="30vh" width="30vh" class="image" onclick="gira(this);">
                </a>
            </h3>
            <br>
            <div class="collapse" id="categorie">
                <p>Da queste sezioni potrai aggiungere o modificare le categorie dei prodotti</p>
                <div class="row">
                    <div class="col-auto my-3">
                        <a href="./otherPages/categoria/inserisci.php">
                            <button type="button" name="submit" class="btn btn-dark bottoneHome">Inserisci una nuova categoria</button>
                        </a>
                    </div>
                    <div class="col-auto my-3">
                        <a href="./otherPages/categoria/modifica.php">
                            <button type="button" name="submit" class="btn btn-dark bottoneHome" >Modifica una categoria</button>
                        </a>
                    </div>
                    <div class="col-auto my-3">
                        <a href="./otherPages/categoria/elimina.php">
                            <button type="button" name="submit" class="btn btn-dark bottoneHome" >Rimuovi una categoria</button>
                        </a>
                    </div>
                    <div class="col-auto my-3">
                        <a href="./otherPages/categoria/visualizza.php">
                            <button type="button" name="submit" class="btn btn-dark bottoneHome" >Visualizza le categorie disponibili</button>
                        </a>
                    </div>
                    <div class="col-auto my-3">
                        <a href="./otherPages/categoria/sponsorizza.php">
                            <button type="button" name="submit" class="btn btn-dark bottoneHome" >Scegli le categorie da sponsorizzare</button>
                        </a>
                    </div>
                </div>
            </div>
        </form>
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
    <link rel="stylesheet" href="../static/style.css">
    <script src="../static/script.js"></script>
</html>
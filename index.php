<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/757bd903a3.js"></script>
    <link rel="icon" type="image/x-icon" href="./app/images/logo.png">
</head>
<body>
    <?php
        $posizione = 0;
        include('./app/pages/static/navbar.php');
        $posizione = 1;
    ?>

    <!--Immagine sfondo 1-->
    <div class="nascosto">
        <div class="sfondo" id="sf1">
            <div class="container d-flex align-items-center justify-content-center" style="z-index:2;height:100%;">
                <div class="row">
                    <div class="col">
                        <p style="font-weight: bold;font-size:5em;font-family: 'Parisienne', cursive;color:#ffffff;background-color:rgba(255, 51, 204, 0.6);padding:3vh;">Alice in beautyland</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--<div class="testoFoto" style="max-width:100%;">
        <p style="font-weight: bold;font-size:13vh;font-family: 'Parisienne', cursive;color:#ffffff;background-color:rgba(255, 51, 204, 0.6);padding:3vh;">Alice in beautyland</p>
        
    </div>-->
    

    <!--
    Freccia
    <a href="#primoContenuto">
        <img src="../../images/icons/espandi.png" style="position: absolute;top: 90%;left: 50%;transform: translate(-50%, -0%);">
        <i class="fa fa-chevron-circle-down fa-5x" style="position: absolute;top: 90%;left: 50%;transform: translate(-50%, -0%);color:#ff33cc;"></i>
    </a>-->
    
    <br>

    <!--Primo contenuto scritto, trattamenti piu richiesti-->
    <div class="contenuto" id="primoContenuto">
        <h3>I nostri trattamenti più richiesti</h3>
        <br>
        <br>
        <div class="container">
            <?php
                $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');
                $query = "SELECT COUNT(codPrenotazione) as prenotazioni,codTrattamento FROM prenota GROUP BY codTrattamento ORDER BY prenotazioni DESC LIMIT 3";
                $ris = mysqli_query($link,$query);
                //scorriamo il recordset in cerca dei tre maggiori
                echo '<div class="card-group">';
                while($rigaTrattamenti = mysqli_fetch_array($ris))
                {
                    //print_r($rigaTrattamenti);
                    $nPrenotazioni = $rigaTrattamenti['prenotazioni'];
                    $codTrattamento = $rigaTrattamenti['codTrattamento'];

                    

                    echo '<div class="card">';
                    //div animati
                    /*echo '<div class="flip-card">
                    <div class="flip-card-inner">
                    <div class="flip-card-front">';*/
                    
                    //recupero foto trattamento
                    $queryFoto = "SELECT * FROM trattamento WHERE codTrattamento = $codTrattamento";
                    //echo $queryFoto;
                    $risFoto = mysqli_query($link,$queryFoto);
                    $rigaQueryFoto = mysqli_fetch_array($risFoto);
                    //$percorsoFoto = "../../images/trattamenti/";
                    echo '<img src="'.$percorsoFoto.'images/trattamenti/'.$rigaQueryFoto['nomeFoto'].'" height="250vh" class="card-img-top" alt="...">';
                    echo '<div class="card-body">';
                    echo '<h1 class="card-title">'.$rigaQueryFoto['nome'].'</h1>';
                    //echo '</div>';

                    //div animati
                    echo '
                    </div>
                        <!--<div class="flip-card-back">-->
                        <p>Durata: '.$rigaQueryFoto['durata'].'</p>
                        <p>'.$rigaQueryFoto['prezzo'].'€</p><br>
                        <!--<form method="POST" action="./prenota.php">
                        <button type="submit" class="btn btn-dark" name="codTrattamento" value="'.$codTrattamento.'" id="bottoneHome">Prenota ora!</button>
                        </form>
                        </div>
                    </div>
                    </div>-->';
                    //chiude carta
                    echo '</div>';                    
                }
                echo '</div>';
            ?>
            
        </div>
        <br>
        <!--Bottone prenota ora!-->
        <div>
            <a href="./app/pages/areaPubblica/prenota.php"><button type="button" class="btn btn-dark bottoneHome" >Prenota ora!</button></a>
        </div>

    </div>

    <br>

    <!--Immagine sfondo 2-->
    <div class="nascosto">
        <div class="sfondo" id="sf2"></div>
    </div>


    <!--Secondo contenuto, il nostro negozio e i nostri prodotti-->
    <div class="contenuto" >
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div style="margin-top: 25%;margin-left: 25%;margin-bottom:10%;margin-right:10%;text-align: left;">
                        <h3>Chi siamo</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid molestiae expedita quod sit nihil perferendis omnis est quibusdam fugit libero illo quos ex quam dolores deleniti minima, ut dolor eveniet!</p>
                        <button type="button" class="btn btn-dark bottoneHome" >Scopri di pi&ugrave;</button>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12" style="margin: 0 !important; padding: 0 !important;">
                    <img src="./app/images/fotoHome/noi.jpg" height="100%" width="100%">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-sm-12" style="margin: 0 !important; padding: 0 !important;">
                    <img src="./app/images/fotoHome/cura.jpg" height="100%" width="100%">
                </div>
                <div class="col-md-6 col-sm-12">
                    <div style="margin-top: 25%;margin-right: 25%;margin-bottom: 10%;margin-left: 10%;text-align: right;">
                        <h3>I nostri prodotti</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid molestiae expedita quod sit nihil perferendis omnis est quibusdam fugit libero illo quos ex quam dolores deleniti minima, ut dolor eveniet!</p>
                        <a href="./app/pages/areaPubblica/shop.php"><button type="button" class="btn btn-dark bottoneHome" >Compra ora!</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--Immagine sfondo 3, con scritta animata-->
    <div style="position: relative;" >
        <div class="nascosto">
            <div class="sfondo" id="sf3">
                <div class="container d-flex align-items-center justify-content-center" style="z-index:2;height:100%;" onmouseover="scriviLetteraPerLettera();">
                    <div class="row">
                        <div class="col">
                            <p id="paragrafoAnimato1" style="font-size:2em;transform: skewX(-10deg);background: rgba(255, 51, 204, 0.6);width:auto; display: inline-block;color:white"></p>
                            <p id="paragrafoAnimato2" style="font-weight: bold;font-size:3em;transform: skewX(-10deg);background: rgba(255, 51, 204, 0.6);color:white;"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    
    <!--Ultima sezione, mappa e contatti-->
    <?php
        include('./app/pages/static/footer.html');
    ?>

    
    <link rel="stylesheet" href="./home.css">
    <link rel="stylesheet" href="./app/pages/static/style.css">
    <script src="./home.js"></script>
    
</body>
</html>
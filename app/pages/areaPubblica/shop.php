<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Shop</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <script src="https://use.fontawesome.com/757bd903a3.js"></script>

    <link rel="icon" href="../../images/logo.png">

</head>



<body>

    <?php

        include('../static/navbar.php');

    ?>

    <!--carosello-->

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

        <ol class="carousel-indicators">

            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>

            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>

            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>

        </ol>

        <div class="carousel-inner">

            <div class="carousel-item active">

                <img class="d-block w-100" src="../../images/categorieProdotti/prodotti.jpg" alt="First slide" height="500vh">

                <div class="carousel-caption d-none d-md-block" style="text-align:left">

                    <a href="<?php echo htmlentities($_SERVER['PHP_SELF']).'?categoria=tutti'; ?>">

                        <button class="btn btn-dark bottoneHome">Compra ora!</button>

                    </a>

                    <br><br>

                    <h4 style="background-color:rgba(255, 51, 204, 1);font-weight: bold;padding:2px;display:inline-block;">Tutti i nostri prodotti</h4>

                </div>

            </div>

            <?php

            //funzione per stampa categorie la prima categoria sponsorizzata

            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');

            $query = "SELECT * FROM categoria WHERE sponsor = 1";

            $rigaCategorie = mysqli_query($link,$query);

            $percorsoFoto = '../../images/categorieProdotti/';

            $i = 0;

            while($riga = mysqli_fetch_array($rigaCategorie))

            {

                $nomeCategoria = $riga['nome'];

                $nomeFoto = $riga['nomeFoto'];

                $codCategoria = $riga['codCategoria']; 

                //elemento carosello

                echo '<div class="carousel-item">';

                //img

                echo '<img class="d-block w-100" src="'.$percorsoFoto.$nomeFoto.'" alt="Second slide" height="500vh">';

                

                echo '<div class="carousel-caption d-none d-md-block"';

                if($i == 1)

                    echo 'style="text-align:right"';

                echo '>';

                //link bottone

                echo '<a href="'.htmlentities($_SERVER['PHP_SELF']).'?categoria='.$nomeCategoria.'">';

                echo '<button class="btn btn-dark bottoneHome">Compra ora!</button></a><br><br>';

                echo '<h4 style="background-color:rgba(255, 51, 204, 1);font-weight: bold;padding:2px;display:inline-block;">'.$nomeCategoria.'</h4>';

                echo '</div></div>';

                $i++;

            }

            mysqli_close($link);

            ?>

        </div>

        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">

            <span class="carousel-control-prev-icon" aria-hidden="true"></span>

            <span class="sr-only">Previous</span>

        </a>

        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">

            <span class="carousel-control-next-icon" aria-hidden="true"></span>

            <span class="sr-only">Next</span>

        </a>

    </div>

    <div style="position:absolute;left:3%;margin-top:2%" id="bottoneSezioni">

        <img src="../../images/icons/menu.png" width="50vh" height="50vh"  onclick="mostraSezioni()">Filtri di ricerca

    </div>

    <div class="sezioni" id="sezioni">

        <img src="../../images/icons/plus.png" id="close" style="transform: rotate(45deg);position:absolute;right:0;top:0;" onclick="mostraSezioni()" width="50vh" height="50vh">

        <div style="font-size:4vh;padding:20%;" id="contenitoreSezioni">

            <?php

            //stampo i link delle categorie

            //creo link per tutti i prodotti

            echo '<a href="'.htmlentities($_SERVER['PHP_SELF']).'?categoria=tutti">Tutti i prodotti</a><br><br>';



            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');

            $query = "SELECT nome,codCategoria FROM categoria";

            $rigaCategorie = mysqli_fetch_all(mysqli_query($link,$query));

            //scorro l'array e creo i link

            foreach($rigaCategorie as $categoria)

            {

                $nomeCategoria = $categoria[0];

                //stampo i link

                echo '<a href="'.htmlentities($_SERVER['PHP_SELF']).'?categoria='.$nomeCategoria.'">'.$nomeCategoria.'</a><br><br>';

            }

            

            mysqli_close($link);

            ?>

        </div>

    </div>

    <div class="container mt-5" style="text-align:center" id="spazio">

        <br>

        <br>

    </div>

    <hr>

        <?php

            //se ci troviamo nella categoria shop,mostro selezione categoria

            //altrimenti mostro la categoria desiderata con $GET

            if(!isset($_GET['categoria']))

            {

        ?>

    <div class="container mt-5" style="text-align:center">

        <div class="row" style="text-align:center;">

            <div class="col-md-3 my-1">

                <img src="../../images/icons/trasporto.png" width="20vh" height="20vh">

                <h4>Trasporto gratuito</h4>

                <p>Per ordini superiori ai 29€</p>

            </div>

            <div class="col-md-3 my-1">

                <img src="../../images/icons/donna.png" width="20vh" height="20vh">

                <h4>Sei una professionista?</h4>

                <a href="#">

                    <p>Collabora con noi!</p>

                </a>

            </div>

            <div class="col-md-3 my-1">

                <img src="../../images/icons/assistenza.png" width="20vh" height="20vh">

                <h4>Assistenza telefonica gratuita</h4>

                <p>1112223333</p>

            </div>

            <div class="col-md-3 my-1">

                <img src="../../images/icons/cuore.png" width="20vh" height="20vh">

                <h4>Prodotti professionali</h4>

                <p>Made in Italy</p>

            </div>

        </div>

    </div>

    <hr>

    <br>

    <div class="container">

        <h3>I nostri prodotti pi&ugrave; venduti</h3></div>

        <br>

        <div style="padding-right:5%; padding-left:5%;">

    <?php

        //query per recuperare i 4 prodotti più venduti

        $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');

        //query per contare

        $conta = "SELECT COUNT(compra.codAcquisto) as nAcquisti,prodotto.codProdotto FROM prodotto,compra WHERE prodotto.codProdotto = compra.codProdotto GROUP BY codProdotto ORDER BY nAcquisti DESC";

        $risConto = mysqli_query($link,$conta);

        $query = "SELECT * FROM prodotto WHERE ";

        $richiesta = '';

        $i = 0;

        while($rigaConto = mysqli_fetch_array($risConto))

        {

            if($i == 0)

            {

                $richiesta .= " codProdotto = ".$rigaConto['codProdotto'];

            }

            else

                $richiesta .= " OR codProdotto = ".$rigaConto['codProdotto'];

            $i++;

        }

        $query .= $richiesta;

        

        stampaProdotto('shop',$link,$query); 

    ?>

    <br>

    <!--</div> container prodotti-->

    <!--Immagine sfondo newsletter-->

    <div style="position: relative;width:100%">

        <div class="nascondiSfondo">

            <div class="sfondo" id="sf"></div>

        </div>

        

        <!--newsletter-->

        <div class="row testoFoto">

            <div class="col">

                <div class="divAnnuncio">

                    <h3>Iscriviti alla newsletter per ricevere il 10% di sconto!</h3>

                </div>

                <form>

                    <br>

                    <input type="email" class="form-control mb-2 mr-sm-2">

                    <br>

                    <button type="submit" class="btn btn-dark bottoneHome">Registrati!</button>

                </form>

            </div>

        </div>

    </div>

    <br>

    <div class="container"><h3>Alcuni prodotti</h3></div>

    <div style="padding-right:5%; padding-left:5%;">

        

        <br>

    <?php

        //prodotti a caso

        $query = "SELECT * FROM prodotto ORDER BY RAND() LIMIT 3";

        //echo $query;

        stampaProdotto('shop',$link,$query);

        mysqli_close($link);    

    ?>

    <br>

    </div><!--Chiudo il container prodotti-->

    <?php

    }

    else

    {

        echo '<div class="container">

        <br>';

        $categoria = $_GET['categoria'];

        $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');

        

        //query che prende prodotti in base alla sezione e li stampa

        if($categoria == 'tutti')

        {

            $query = "SELECT * FROM prodotto";

            echo '<h3>Tutti i nostri prodotti</h3>';

        }

        else

        {

            //query per lo shop

            $query = "SELECT categoria.nome as 'nome1',prodotto.* FROM prodotto,categoria WHERE prodotto.codcategoria = categoria.codcategoria AND categoria.nome = '$categoria'";

            echo '<h3>Prodotti della categoria '.$categoria.'</h3>';

        }

        stampaProdotto('shop',$link,$query);

        mysqli_close($link);

        echo '<br>

        </div>';

    }

    ?>

    

    <?php

    include('../static/footer.html');

    ?>  

    

</body>

<link rel="stylesheet" href="./styles/shop.css">

<link rel="stylesheet" href="../static/style.css">

<script src="./scripts/shop.js"></script>

<script src="../static/script.js"></script>

</html>
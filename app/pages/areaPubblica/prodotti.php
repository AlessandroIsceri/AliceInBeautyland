<?php
    /*Solo lato server, serve per stampare i caratteri accentati*/
    header('Content-Type: text/html; charset=ISO-8859-1');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prodotto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/757bd903a3.js"></script>
    <link rel="icon" href="../../images/logo.png">
</head>
<body>
<?php
    //require('../static/php/funzioni.php');
    include('../static/navbar.php');    
    //include('../static/php/connessioneDb.php');
?>

<div class="container">
    <div class="row">
        <h2> 
            <?php 
                $codProdotto = htmlentities($_GET['prodotto']);
                $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
                //prepared statement
                $query = "SELECT * FROM prodotto WHERE codProdotto = ?";
                $prepStatement = mysqli_prepare($link, $query);
                mysqli_stmt_bind_param($prepStatement,'i',$codProdotto);
                mysqli_stmt_execute($prepStatement);
                $ris = mysqli_stmt_get_result($prepStatement);
                $riga = mysqli_fetch_array($ris);
                echo $riga['nome'];
                //inserisco la visualizzazione nel file excel
                
                $file = fopen("../../vendite/2021.csv", "r") or die("Non sono riuscito ad aprire il file!");
                $fileOutput = fopen("../../vendite/temp.csv", "w"); //lo apro per scrivere
                //salto riga introduttiva
                $rigaFile = fgetcsv($file,1000,';');
                fputcsv($fileOutput, $rigaFile,';');
                //$mese indica la colonna del mese corrente alla quale vanno aggiornate le visual
                $mese = intval(date('m'));
                while(!feof($file))
                {
                    //fgetcsv(file, length, separator, enclosure)
                    $rigaFile = fgetcsv($file,1000,';');
                    if(feof($file))
                        break;
                    $n_celle = count($rigaFile);
                    //echo $n_celle.'<br>';
                    if($n_celle != 1)
                    {
                        //i = 1 salto il cod prodotto
                        if($rigaFile[0] == $codProdotto)
                        {
                            $datiMese = explode('--',$rigaFile[$mese]);
                            $visualizzazioni = $datiMese[1];
                            $acquisti = $datiMese[0];
                            $visualizzazioni++;
                            $rigaFile[$mese] = $acquisti.'--'.$visualizzazioni;
                        }
                        fputcsv($fileOutput, $rigaFile,';');
                    }
                }
                fclose($file);
                fclose($fileOutput);
                //elimino vecchio file e rinomino il nuovo
                unlink('../../vendite/2021.csv');
                rename('../../vendite/temp.csv', '../../vendite/2021.csv');
            ?>
        </h2>
    </div>
    <br>
    <div class="row">
        <div class="col-md-4">
            <?php
                //recupero foto
                $percorsoFoto = "../../images/prodotti/";
                //prepared statement
                $queryFoto = "SELECT nomeFoto FROM fotoprodotto WHERE codProdotto = ?";
                $prepStatementFoto = mysqli_prepare($link, $queryFoto);
                mysqli_stmt_bind_param($prepStatementFoto,'i',$codProdotto);
                mysqli_stmt_execute($prepStatementFoto);
                $risFoto = mysqli_stmt_get_result($prepStatementFoto);
                $rigaQueryFoto = mysqli_fetch_all($risFoto);

                //apro carosello
                echo '<div id="carouselExampleSlidesOnly" style="width:100%;height:60vh" class="carousel slide" data-ride="carousel"><div class="carousel-inner">';
                $i = 0; //nel primo ciclo dovrò settare la prima immagine come attiva
                foreach($rigaQueryFoto as $value)   //scorro le foto del prodotto
                {
                    $nomeFoto = $value[0];          //ottengo la foto(si trova nell'array in pos 0)
                    $foto = $percorsoFoto.$nomeFoto;
                    
                    echo '<div class="carousel-item';

                    if($i==0)       //setto la prima immagine come attiva
                        echo ' active';
                    echo '">';
                    //stampo foto
                    echo '<img src="'.$foto.'" class="d-block w-100" alt="..." height="400vh;" ></div>';
                    $i++;
                }
                echo '</div></div>';
            ?>
        </div>
        <div class="col-md-4">
            <p>Descrizione: <br>
            <?php 
                $descrizione = $riga['descrizione'];
                echo $descrizione;
            ?></p>
            <?php
            echo 'Prezzo: '.$riga['prezzo'].'&#8364;<br>';
            echo 'Marca: '.$riga['marca'];
            echo '<br><div>';
            echo '<a class="card-link">Compra ora</a>'; 
            echo '<a class="card-link">Aggiungi al carrello</a>';
            echo '<input type="hidden" name="codProdotto" value="'.$codProdotto.'"></div>';
            ?>
        </div>
        <div class="col-md-4" style="height:60vh;">
            <div id="recensioni">
                <?php
                    //query prepared
                    $query = "SELECT email,descrizione,valutazione FROM recensione WHERE codProdotto = ?";
                    $prepStatement = mysqli_prepare($link, $query);
                    mysqli_stmt_bind_param($prepStatement,'i',$codProdotto);
                    mysqli_stmt_execute($prepStatement);
                    $ris = mysqli_stmt_get_result($prepStatement);

                    if(mysqli_fetch_array($ris) == 0)
                    {
                        echo 'Non ci sono recensioni';
                    }
                    else
                    {
                        mysqli_stmt_execute($prepStatement);
                        $ris = mysqli_stmt_get_result($prepStatement);
                    }

                    //stampo le recensioni
                    while($riga = mysqli_fetch_array($ris))
                    {
                        echo 'Recensione di '.$riga['email'];
                        echo '<br>';
                        echo $riga['descrizione'];
                        echo '<br>';
                        //stampo valutazione con stelle
                        $valutazione = $riga['valutazione'];
                        echo 'Valutazione: ';
                        for( $i = 0; $i < 5; $i++ )
                        {
                            //ogni $i è una stella, da 0 a 5
                            //floor arrotonda all'intero per difetto
                            if( floor( $valutazione ) - $i >= 1 )
                            {   
                                //intero - valore della stella attuale >=1, stella piena
                                echo '<i class="fa fa-star" style="color:#ff33cc"></i>'; 
                            }
                            elseif( $valutazione - $i > 0 )
                            { 
                                //intero - valore della stella attuale >0, stella a metà
                                echo '<i class="fa fa-star-half-o" style="color:#ff33cc"></i>'; 
                            }
                            else
                            { 
                                //intero - valore della stella attuale = 0, stella vuota
                                echo '<i class="fa fa-star-o" style="color:#ff33cc"></i>'; 
                            }
                        }
                        echo '<hr style="background-color:#ff33cc;height:2px">';
                    }
                ?>
            </div>
            <br>
            <div style="text-align:center;">
                <form method="POST" action="recensione.php"><button class="btn btn-dark bottoneHome" name="recensione" value="<?php echo $codProdotto; ?>">Scrivi una recensione</button></form>
            </div>
        </div>
    </div>
</div>
<br><br>
<!--Ultima sezione, mappa e contatti-->
<?php
    mysqli_close($link);
    include('../static/footer.html');
?>

<link rel="stylesheet" href="../static/style.css">
<link rel="stylesheet" href="./styles/prodotti.css">
<script src="./scripts/shop.js"></script>
</body>
</html>
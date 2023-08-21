<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizza le valutazioni dei prodotti</title>
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
        <a href="../../index.php">
            <i class="fa fa-angle-double-left fa-3x" style="color:#ff33cc;">Home</i>
        </a>
        <br>
        <?php
        if(!isset($_POST['seleziona'])&&(!isset($_POST['elimina'])))
        {
            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
            $query = "SELECT * FROM prodotto";  //prendo dati prodotto
            stampaProdotto('modifica',$link,$query);    //li stampo in modo che siano selezionabili
            mysqli_close($link);
        ?>
        <?php
        }
        else if(isset($_POST['seleziona']))
        {
            //connessione al db, una volta selezionato il prodotto stampo le recensioni
            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
            $query = "SELECT * FROM recensione WHERE codProdotto = ".$_POST['codProdotto'];
            $ris = mysqli_query($link,$query);
            echo '
            <table class="table">
                <thead style="background-color:rgba(255, 51, 204, 0.7);">
                    <tr>
                        <th scope="col">Email</th>
                        <th scope="col">Recensione</th>
                        <th scope="col">Valutazione</th>
                        <th scope="col">Elimina</th>
                    </tr>
                </thead>
            <tbody>';
            while($riga = mysqli_fetch_array($ris))
            {
                echo '<tr>';
                echo '<td>'.$riga['email'].'</td>';
                echo '<td>'.$riga['descrizione'].'</td>';
                echo '<td>';
                //valutazione in stelle
                $valutazione = $riga['valutazione'];
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
                echo '</td>';
                echo '<th><form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
                echo '<button type="button" class="btn btn-dark bottoneIcona" onclick="chiedi(this);"><i class="fa fa-trash" style="color:#ff33cc"></i></button><input type="hidden" name="elimina" value="'.$riga['codRecensione'].'">';
                echo '</form></th>';
                echo '</tr>';
                
            }
            echo '</tbody>
            </table>';
            mysqli_close($link);
        }
        else
        {
            //cliccato pulsante elimina
            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
            $query = "DELETE FROM recensione WHERE codRecensione = ".$_POST['elimina'];
            mysqli_query($link,$query);
            mysqli_close($link);
            echo 'Eliminazione effettuata con successo';
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
<style>
tr,th,thead,tbody,.table thead th {
   border-bottom: 2px solid #ff33cc; 
}

    </style>
    <script src="./scripts/elimina.js"></script>
</html>
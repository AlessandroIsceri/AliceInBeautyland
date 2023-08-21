<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analitiche</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/757bd903a3.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="../../../../images/logo.png">
</head>
<body <?php 
        if(isset($_POST['seleziona']))
            //echo 'onload="disegnaGrafico();disegnaGraficoGauss();"';    //disegno i grafici all'apertura della pagina
            echo '>';
        ?>
    
    <?php
        $posizione = -2;
        include('../../../static/navbar.php');
        if(!isset($_POST['seleziona']))
        {
            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
            $query = "SELECT * FROM prodotto";  //prendo dati prodotto
            echo '<div class="container">';
            echo '<a href="../../index.php">
                <i class="fa fa-angle-double-left fa-3x" style="color:#ff33cc;">Home</i>
            </a>';
            echo '<h3>Seleziona il prodotto di cui vuoi vedere le analitiche</h3>';
            //stampo i prodotti in modo che siano selezionabili
            stampaProdotto('modifica',$link,$query);
            mysqli_close($link);
        }
        else
        {
            //se é stato selezionato un prodotto
            $codProdotto = $_POST['codProdotto'];
            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
            $query = "SELECT * FROM prodotto WHERE codProdotto = $codProdotto";  //prendo dati prodotto
            echo '<div class="container">';
            echo '<a href="./visualizza.php">
                <i class="fa fa-angle-double-left fa-3x" style="color:#ff33cc;">Seleziona un altro prodotto</i>
            </a>';
            $riga = mysqli_fetch_array(mysqli_query($link,$query));
            mysqli_close($link);
            echo '<input type="hidden" id="codProdotto" value="'.$codProdotto.'">';
            echo "<h2>Dati del prodotto ".$riga['nome']."</h2>";
    ?>
    <br>
        <h3>Seleziona i mesi di cui vuoi vedere le statistiche</h3>
        <select name="mesi" id="mesi" onchange="disegnaGrafico();" class="form-control">
            <option value="1">Ultimo mese</option>
            <option value="2">Ultimi due mesi</option>
            <option value="3">Ultimi tre mesi</option>
            <option value="4">Ultimi quattro mesi</option>
            <option value="5">Ultimi cinque mesi</option>
            <option value="6">Ultimi sei mesi</option>
            <option value="12">Ultimo anno</option>
        </select>
    </div>

    <canvas id="grafico"></canvas>
    
    <br><br>
    <div class="container">
        <h3>Seleziona i mesi di cui vuoi vedere le statistiche</h3>
        <select name="mesiGauss" id="mesiGauss" onchange = "disegnaGraficoGauss();" class="form-control">
            <option value="2">Ultimi due mesi</option>
            <option value="3">Ultimi tre mesi</option>
            <option value="4">Ultimi quattro mesi</option>
            <option value="5">Ultimi cinque mesi</option>
            <option value="6">Ultimi sei mesi</option>
            <option value="12">Ultimo anno</option>
        </select>
    </div>
    <canvas id="gauss"></canvas>
    <div class="container">
        <br>
        <p style="color:red;" id="errore"></p>
        <div class="row">
            <div class="col-md-6">
                <input type="number" class="form-control" id="prodInziali" min="0" value="0">
            </div>
            <div class="col-md-6">
                <input type="number" class="form-control" id="prodFinali" min="0" value="0">
            </div> 
        </div>
        <br>
        <div style="text-align:center">
            <button class="btn btn-dark bottoneHome" onclick="calcolaProbabilita();">Calcola la probabilit&agrave;</button>
            <p id="risultato"></p>
        </div>
    </div>
    <?php
        }
    ?>
    <br>
    <br>
    <script src="./analitiche.js"></script>
    <link rel="stylesheet" href="../../../static/style.css">
    <script>
    window.onload = function() {
  		disegnaGrafico();
        disegnaGraficoGauss();
	};
    </script>
</body>
</html>
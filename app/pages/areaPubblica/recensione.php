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
    //require ('../static/php/funzioni.php');
    include('../static/navbar.php');    
    //include('../static/php/connessioneDb.php');
?>

<div class="container">
    <?php
        if(!isset($_SESSION['nome']))
        {
            echo 'Effettua il login per scrivere una recensione<br>';
            echo '<div class = "row align-items-center"><div class="col-12" style="text-align:center"><a href="./login.php"><button class="btn btn-dark bottoneHome">Effettua il login</button></a></div></div>';
            echo '<br>';
        }
        else if(!isset($_POST['pubblica']))
        {
            $codProdotto = $_POST['recensione'];
            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
            //arriva da un campo hidden, inutile creare una prepared
            $query = "SELECT * FROM prodotto WHERE codProdotto = ".$codProdotto;
            $riga = mysqli_fetch_array(mysqli_query($link,$query));
    ?>
    Scrivi una recensione sul prodotto <?php echo $riga['nome'];?>
    <br><br>
    <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>">
        <div class = "row align-items-center">
            <div class="col-8">
                <textarea class="form-control" name="recensione"></textarea>
            </div>
            <div class="col-auto">
                <i class="fa fa-star-o fa-2x" style="color:#ff33cc" id="1" onclick="colora(this);"></i>
                <i class="fa fa-star-o fa-2x" style="color:#ff33cc" id="2" onclick="colora(this);"></i>
                <i class="fa fa-star-o fa-2x" style="color:#ff33cc" id="3" onclick="colora(this);"></i>
                <i class="fa fa-star-o fa-2x" style="color:#ff33cc" id="4" onclick="colora(this);"></i>
                <i class="fa fa-star-o fa-2x" style="color:#ff33cc" id="5" onclick="colora(this);"></i>
                <input type="hidden" name="voto" value="0" id="voto">
            </div>
        </div>
        <br>
        <div class = "row align-items-center">
            <div class="col-12" style="text-align:center">
                <button class="btn btn-dark bottoneHome" name="pubblica" value="<?php echo $codProdotto; ?>">Pubblica</button>
            </div>
        </div>
    </form>
    <br>
</div>

<!--Ultima sezione, mappa e contatti-->
<?php
    }
    else
    {
        $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella recensione');
        //pubblico la recensione
        $recensione = ripulisciDato('recensione');
        $valutazione = $_POST['voto'];
        $email = $_SESSION['email'];
        $codProdotto = $_POST['pubblica'];
        //query prepared
        $query = "INSERT INTO recensione(descrizione,valutazione,email,codProdotto) VALUES (?,?,?,?)";
        $prepStatement = mysqli_prepare($link, $query);
        mysqli_stmt_bind_param($prepStatement, 'sdsi', $recensione, $valutazione,$email,$codProdotto);
        mysqli_stmt_execute($prepStatement);
        mysqli_close($link);
        echo '<a href="./prodotti.php?prodotto='.$codProdotto.'">Recensione pubblicata correttamente</a>';
        echo '</div>';
    }
    include('../static/footer.html');
?>

<link rel="stylesheet" href="../static/style.css">
<script>
//quando viene cliccata una stella le colora per far visualizzare la valutazione inserita
function colora(stella){
    var stellaCorrente;
    for(var i = 1; i <= 5 ; i++)
    {
        stellaCorrente = document.getElementById(i);
        stellaCorrente.className = "fa fa-star-o fa-2x";
    }
    var id = parseInt(stella.id);
    for(var i = 1; i <= id; i++)
    {
        stellaCorrente = document.getElementById(i);
        stellaCorrente.className = "fa fa-star fa-2x";   
    }
    document.getElementById('voto').value = id;
}
</script>
</body>
</html>
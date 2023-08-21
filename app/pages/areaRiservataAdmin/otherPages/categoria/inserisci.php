<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserisci categoria</title>
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
        if(!isset($_POST['inserisci']))
      {
    ?>
    <br>
    <div class="container">
        <a href="../../gestioneShop.php">
            <i class="fa fa-angle-double-left fa-3x" style="color:#ff33cc;">Gestione shop</i>
        </a>
        <br>
        <form method="POST" enctype="multipart/form-data">
            <h3>Inserisci i dati della nuova categoria</h3><br>
            <p id = "errore" style="color:red"></p>
            <div class="row">
                <div class="col">
                <input type="text" class="form-control" placeholder="Nome categoria" name="nome" id="nome">
                </div>
            </div>
            <br>
            <div class="row" id="rigaFoto">
                <div class="form-group">
                    <label for="foto">Seleziona foto categoria</label>
                    <input type="file" class="form-control-file" id="foto" name="foto" required>
                    <p id='paragrafoFoto' style="color:red"></p>
                </div>
            </div>
            <input type="hidden" name="inserisci" id="inserisci">
            <br>
            <div style="text-align:center">
                <div class="row">
                    <div class="col-md-3 my-3 mx-auto">
                        <button class="btn btn-dark bottoneHome" type="button" onclick="checkForm(this.form);">Pubblica</button>
                    </div>
                    <div class="col-md-3 my-3 mx-auto">
                    <input type="reset" class="btn btn-dark bottoneHome" name="reset">
                    </div>
                </div>
            </div>
        </form>
    </div>
  </body>
<?php
  }
  else
  {
    $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');
    $nome = '';
    $nome = $_POST['nome'];
    $errore = false;
    //inserisco le foto
    $percorsoFile = "../../../../images/categorieProdotti/";
    echo $percorsoFile.$_FILES['foto']['name'];
    if(move_uploaded_file($_FILES['foto']['tmp_name'],$percorsoFile.$_FILES['foto']['name']))
    { 
        echo "Foto caricata correttamente<br>";
        $nomeFoto = $_FILES['foto']['name'];
        $query = "INSERT INTO categoria(nome,nomeFoto) VALUES('$nome','$nomeFoto')";
        mysqli_query($link,$query) or die("impossibile eseguire query prodotto");
    }
    else
    {
        echo "Errore nell'invio della foto<br>"; 
        $errore = true;  
    } 
    mysqli_close($link);
    if(!$errore)
    {
        echo '<br><div class="container">L\'operazione &egrave; andata a buon fine.<br><br><div class="row">';
        echo '<div class="col-6 mx-auto" style="text-align:center"><a href="./inserisci.php"><button class="btn btn-dark bottoneHome" type="button">Inserisci una nuova categoria</button></a></div>';
        echo '<div class="col-6 mx-auto" style="text-align:center"><a href="../../index.php"><button class="btn btn-dark bottoneHome" type="button">Torna alla home</button></a></div></div></div>';
    }
  }
}
else
{
    echo 'Utente non riconosciuto';
}
?>
<script src="./scripts/inserisci.js"></script>
<link rel="stylesheet" href="../../../static/style.css">
</html>
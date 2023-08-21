<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserisci prodotto</title>
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
        <h3>Inserisci i dati del nuovo prodotto</h3><br>
        <p id = "errore" style="color:red"></p>
          <div class="row">
            <div class="col">
              <input type="text" class="form-control" placeholder="Nome prodotto" name="nome" id="nome">
            </div>
            <div class="col">
              <input type="text" class="form-control" placeholder="Marca" name="marca" id="marca">
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="col">
              <input type="number" class="form-control" placeholder="Prezzo" name="prezzo" min="0" id="prezzo">
            </div>
            <div class="col">
              <input type="number" class="form-control" placeholder="Quantit&agrave;" name="quantita" min="0" id="quantita">
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="col">
              <select name="categoria" class="form-control">
                <?php
                    $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');
                    $query = "SELECT nome,codCategoria FROM categoria";
                    $ris = mysqli_query($link,$query);
                    while($riga = mysqli_fetch_array($ris))
                    {
                      $codCategoria = $riga['codCategoria'];
                      $categoria = $riga['nome'];
                      echo "<option value = '$codCategoria'>$categoria</option>";
                    }
                    mysqli_close($link);
                ?>
              </select>
            </div>
          </div>
          <br><br>
          <div class="row">
            <div class="col">
              <div class="form-group">
                <textarea class="form-control" id="descrizione" rows="3" placeholder="Descrizione" name="descrizione"></textarea>
              </div>
            </div>
          </div>
          <br><br>
          <div class="row">
          Seleziona il numero di foto che vuoi caricare
            <select name="numeroFoto" id="numeroFoto" class="form-contro mb-2" onchange="cambiaNumeroFoto(this);">
                <option value ="1">Una foto</option>
                <option value ="2">Due foto</option>
                <option value ="3">Tre foto</option>
                <option value ="4">Quattro foto</option>
                <option value ="5">Cinque foto</option>
                <option value ="6">Sei foto</option>
                <option value ="7">Sette foto</option>
                <option value ="8">Otto foto</option>
                <option value ="9">Nove foto</option>
            </select>
          </div>
          
          <div class="row" id="rigaFoto">
            <div class="form-group">
              <label for="foto1">Seleziona foto 1</label>
              <input type="file" class="form-control-file" id="foto1" name="foto[]" required>
              <p id='paragrafoFoto1' style="color:red"></p>
            </div>
          </div>
          <input type="hidden" name="inserisci" id="inserisci">
          <br>
          <div style="text-align:center">
            <div class="row">
              <div class="col-md-3 my-3 mx-auto">
                <button class="btn btn-dark bottoneHome" type="button" onclick="checkFile(this.form);">Pubblica</button>
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
      $quantita = $prezzo = 0;
      $nome = $descrizione = $marca = $codCategoria = '';
      $quantita = $_POST['quantita'];
      $prezzo = $_POST['prezzo'];
      $nome = $_POST['nome'];
      $descrizione = $_POST['descrizione'];
      $marca = $_POST['marca'];
      $codCategoria = $_POST['categoria'];
      $query = "INSERT INTO prodotto(nome,quantita,prezzo,descrizione,marca,codCategoria) VALUES('$nome',$quantita,$prezzo,'$descrizione','$marca',$codCategoria)";
      //echo $query.'<br>';
      mysqli_query($link,$query) or die("impossibile eseguire query prodotto");
      //inserisco le foto
      $query = "SELECT LAST_INSERT_ID() FROM prodotto";
      $ris = mysqli_fetch_array(mysqli_query($link,$query));
      $codProdotto = $ris['LAST_INSERT_ID()'];
      $percorsoFile = "../../../../images/prodotti/";
      $errore = false;
      
      //inserisco le foto
      for($i = 0; $i < sizeof($_FILES['foto']['name']); $i++)
      {
        $nomeFoto = $_FILES['foto']['name'][$i];
        //echo $percorsoFile.$nomeFoto.'<br>';
        if(move_uploaded_file($_FILES['foto']['tmp_name'][$i],$percorsoFile.$nomeFoto))
        {
            echo "File ".$i." inviato correttamente<br>";
            $query = "INSERT INTO fotoProdotto(nomeFoto,codProdotto) VALUES('$nomeFoto',$codProdotto)";
            //echo $query;
            mysqli_query($link,$query)or die("impossibile eseguire query immagini");
        }
        else
        {
            echo "Errore nell'invio del file ".$i."<br>";
            $errore = true;
        }
      }
      mysqli_close($link);
      //aggiorno il file excel (creo nuova istanza col prodotto appena inserito) 
      $rigaFile = [];
      $file = fopen("../../../../vendite/2021.csv", "a") or die("Non sono riuscito ad aprire il file!");
      array_push($rigaFile, $codProdotto);
      for($i = 0; $i < 12; $i++)
      {
        array_push($rigaFile,'0--0');
      }
      //print_r($rigaFile);
      fputcsv($file, $rigaFile,';');
      fclose($file); 
      if(!$errore)
      {
        echo '<br><div class="container">L\'operazione &egrave; andata a buon fine.<br><br><div class="row">';
        echo '<div class="col-6 mx-auto" style="text-align:center"><a href="./inserisci.php"><button class="btn btn-dark bottoneHome" type="button">Inserisci un nuovo prodotto</button></a></div>';
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
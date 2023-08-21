<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica prodotto</title>
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
      <a href="../../gestioneShop.php">
        <i class="fa fa-angle-double-left fa-3x" style="color:#ff33cc;">Gestione shop</i>
      </a>
      <br>
        <?php
            if(!isset($_POST['seleziona'])&&(!isset($_POST['modifica'])))
            {
              //connessione al db
              $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
              $query = "SELECT * FROM prodotto";  //prendo dati prodotto
              stampaProdotto('modifica',$link,$query);
              mysqli_close($link);
            }
            else if(isset($_POST['seleziona']))//se e' stato cliccato il pulsante di un prodotto
            {
                $codProdotto = $_POST['codProdotto'];
                $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
                $query = "SELECT * FROM prodotto WHERE codProdotto = $codProdotto";
                $ris = mysqli_query($link,$query);
                $riga = mysqli_fetch_array($ris);
                //setto le variabili del recordset
                $nomeProdotto = $riga['nome'];
                $descrizione = $riga['descrizione'];
                $marca = $riga['marca'];
                $quantita = $riga['quantita'];
                $prezzo = $riga['prezzo'];

                //query per recuperare le foto
                $queryFoto = "SELECT nomeFoto FROM fotoProdotto WHERE codProdotto = '$codProdotto'";
                $rigaQueryFoto = mysqli_fetch_all(mysqli_query($link,$queryFoto));
                //numero delle foto
                $numeroFoto = sizeof($rigaQueryFoto);
                
                //stampo il form per modificare i dati
                echo '<form method="POST" enctype="multipart/form-data" id="form">
                <h3>Modifica i dati del prodotto</h3><br>
                <p id = "errore" style="color:red"></p>
                  <div class="row">
                    <div class="col">
                      <input type="text" class="form-control" placeholder="Nome prodotto" name="nome" id="nome" value="'.$nomeProdotto.'">
                    </div>
                    <div class="col">
                      <input type="text" class="form-control" placeholder="Marca" name="marca" id="marca" value="'.$marca.'">
                    </div>
                  </div>
                  <br><br>
                  <div class="row">
                    <div class="col">
                      <input type="number" class="form-control" placeholder="Prezzo" name="prezzo" min="0" id="prezzo" value="'.$prezzo.'">
                    </div>
                    <div class="col">
                      <input type="number" class="form-control" placeholder="Quantit&agrave;" name="quantita" min="0" id="quantita" value="'.$quantita.'">
                    </div>
                  </div>
                  <br><br>
                  <div class="row">
                    <div class="col">
                      <select name="categoria" class="form-control">';
                            //stampo le categorie nel select
                            $queryCatgeoria = "SELECT nome,codCategoria FROM categoria";
                            $risCategoria = mysqli_query($link,$queryCatgeoria);
                            while($rigaCategoria = mysqli_fetch_array($risCategoria))
                            {
                              $codCategoria = $rigaCategoria['codCategoria'];
                              $categoria = $rigaCategoria['nome'];
                              echo "<option value = '$codCategoria'>$categoria</option>";
                            }
                  echo '</select>
                    </div>
                  </div>
                  <br><br>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <textarea class="form-control" id="descrizione" rows="3" placeholder="Descrizione" name="descrizione">'.$descrizione.'</textarea>
                      </div>
                    </div>
                  </div>
                  <br><br>
                  <div class="row">';
                  //stampo le foto
                  $percorsoFoto = "../../../../images/prodotti/"; //percorso dove sono salvate le foto
                  $i = 0;
                  foreach($rigaQueryFoto as $value)
                  {
                    echo '<div class="col" style="text-align:center" id="divFotoCaricata'.($i+1).'">';
                    echo '<img src = "'.$percorsoFoto.$value[0].'"width = "100vh" height="100vh" id="'.$value[0].'"><br><br>';
                    echo '<button type="button" id="eliminaFoto'.($i+1).'" class="btn btn-dark bottoneHome" onclick="eliminaFoto(this)">Elimina foto '.($i+1);
                    echo '</div>';
                    $i++;
                  }
                  echo '</div>
                  <br><br>
                  <div class="row">
                    Seleziona il numero di foto che vuoi aggiungere
                      <select name="numeroFoto" id="numeroFoto" class="form-contro mb-2" onchange="cambiaNumeroFoto(this);">
                        <option value ="0">Zero foto</option>
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
                  <div id="rigaFoto">
                  </div>
                  <input type="hidden" name="modifica" id="modifica">
                  <input type="hidden" name="codProdotto" value="'.$codProdotto.'">
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
                </form>';
                
                mysqli_close($link);
            }
            else //inviato il form di modifica
            {
              $errore = false;
              $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');
              $quantita = $prezzo = 0;
              $nome = $descrizione = $marca = $codCategoria = '';
              $quantita = $_POST['quantita'];
              $prezzo = $_POST['prezzo'];
              $nome = $_POST['nome'];
              $descrizione = $_POST['descrizione'];
              $marca = $_POST['marca'];
              $codCategoria = $_POST['categoria'];
              $codProdotto = $_POST['codProdotto'];
              //aggiorno i dati
              $query = "UPDATE prodotto SET nome = '$nome', quantita = $quantita, prezzo = $prezzo ,descrizione = '$descrizione',marca = '$marca',codCategoria = '$codCategoria' WHERE codProdotto = $codProdotto";
              //echo $query.'<br>';
              mysqli_query($link,$query) or die("impossibile eseguire query prodotto");
              $percorsoFoto = "../../../../images/prodotti/";
              //rimuovo le foto vecchie

              if(isset($_POST['fotoEliminate']))
                {
                  $fotoDaEliminare = $_POST['fotoEliminate'];
                  foreach($fotoDaEliminare as $fotoCorrente)
                  {
                    $queryFotoEliminate = "DELETE FROM fotoprodotto WHERE nomeFoto = '$fotoCorrente'";
                    mysqli_query($link,$queryFotoEliminate);
                    unlink($percorsoFoto.$fotoCorrente);
                  }
                }
              //inserisco le foto nuove, se presenti
              
              if(!(empty($_FILES)))
                for($i = 0; $i < sizeof($_FILES['foto']['name']); $i++)
                {
                  $nomeFoto = $_FILES['foto']['name'][$i];
                  //echo $percorsoFoto.$nomeFoto.'<br>';
                  if(move_uploaded_file($_FILES['foto']['tmp_name'][$i],$percorsoFoto.$nomeFoto))
                  {
                      echo "File ".$i." inviato correttamente<br>";
                      $query = "INSERT into fotoProdotto(nomeFoto,codProdotto) VALUES('$nomeFoto',$codProdotto)";
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
              if(!$errore)
              {
                echo '<br><div class="container">L\'operazione &egrave; andata a buon fine.<br><br><div class="row">';
                echo '<div class="col-6 mx-auto" style="text-align:center"><a href="./modifica.php"><button class="btn btn-dark bottoneHome" type="button">Modifica un altro prodotto</button></a></div>';
                echo '<div class="col-6 mx-auto" style="text-align:center"><a href="../../index.php"><button class="btn btn-dark bottoneHome" type="button">Torna alla home</button></a></div></div></div>';
              }
            }
          }
          else
          {
              echo 'Utente non riconosciuto';
          }
        ?>
    </div>
  </body>
<script src="./scripts/modifica.js"></script>
<link rel="stylesheet" href="../../../static/style.css">
</html>
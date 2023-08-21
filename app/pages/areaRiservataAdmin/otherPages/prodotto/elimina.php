<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elimina prodotto</title>
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
            if(!isset($_POST['seleziona'])&&(!isset($_POST['elimina'])))
            {
                //connessione al db
                $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
                $query = "SELECT * FROM prodotto";  //prendo dati prodotto
                stampaProdotto('elimina',$link,$query);
                mysqli_close($link);
            }
            else if(isset($_POST['seleziona']))
            {
                //chiedo se si è sicuri di cancellare
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
                <h3>Elimina prodotto</h3><br>
                <p id = "errore" style="color:red"></p>
                  <div class="row">
                    <div class="col">
                      <input type="text" class="form-control" placeholder="Nome prodotto" name="nome" id="nome" value="'.$nomeProdotto.'" readonly>
                    </div>
                    <div class="col">
                      <input type="text" class="form-control" placeholder="Marca" name="marca" id="marca" value="'.$marca.'" readonly>
                    </div>
                  </div>
                  <br><br>
                  <div class="row">
                    <div class="col">
                      <input type="number" class="form-control" placeholder="Prezzo" name="prezzo" min="0" id="prezzo" value="'.$prezzo.'" readonly>
                    </div>
                    <div class="col">
                      <input type="number" class="form-control" placeholder="Quantit&agrave;" name="quantita" min="0" id="quantita" value="'.$quantita.'" readonly>
                    </div>
                  </div>
                  <br><br>
                  <div class="row">
                    <div class="col">
                      <select name="categoria" class="form-control" readonly>';
                            //stampo le categorie
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
                        <textarea class="form-control" id="descrizione" rows="3" placeholder="Descrizione" name="descrizione" readonly>'.$descrizione.'</textarea>
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
                    echo 'Foto '.($i+1);
                    echo '</div>';
                    $i++;
                  }
                  echo '</div>
                  <input type="hidden" name="codProdotto" value="'.$codProdotto.'">
                  <br>
                  <div style="text-align:center">
                    <button class="btn btn-dark bottoneHome" name="elimina" type="submit">Elimina</button>
                  </div>
                </form>';
                
                mysqli_close($link);
            }
            else
            {
                //cliccato pulsante elimina
                $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');
                $codProdotto = $_POST['codProdotto'];
                $query = "DELETE FROM prodotto WHERE codProdotto = '$codProdotto'";
                mysqli_query($link,$query) or die("Impossibile eseguire la query");
                mysqli_close($link);
                echo '<br><div class="container">L\'operazione &egrave; andata a buon fine.<br><br><div class="row">';
                echo '<div class="col-6 mx-auto" style="text-align:center"><a href="./elimina.php"><button class="btn btn-dark bottoneHome" type="button">Elimina un altro prodotto</button></a></div>';
                echo '<div class="col-6 mx-auto" style="text-align:center"><a href="../../index.php"><button class="btn btn-dark bottoneHome" type="button">Torna alla home</button></a></div></div></div>';
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
</html>
        
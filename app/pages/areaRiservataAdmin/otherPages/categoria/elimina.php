<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elimina una categoria</title>
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
              $percorsoFile = "../../../../images/categorieProdotti/";
              //connessione al db
              $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
              $query = "SELECT * FROM categoria";  //prendo dati categoria
              $risCategoria = mysqli_query($link,$query) or die("Impossibile eseguire query categoria");
              
              $i = 0;
              //stampo categorie
              while($rigaCategoria = mysqli_fetch_array($risCategoria))
              {
                    $nomeCategoria = $rigaCategoria['nome'];
                    $codCategoria = $rigaCategoria['codCategoria'];
                    $nomeFoto = $rigaCategoria['nomeFoto'];
                    if($i % 3 == 0)
                        echo '<div class="row">';
                    echo '<div class="col-md-3 my-3 mx-auto">';
                    echo '<img src="'.$percorsoFile.$nomeFoto.'" width="200vh" height="200vh"><br>';
                    echo 'Nome Categoria: '.$nomeCategoria;
                    echo '<br><form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
                    echo '<input type="submit" class="btn btn-dark bottoneHome" name="seleziona" value="Seleziona">';
                    echo '<input type="hidden" name="codCategoria" value="'.$codCategoria.'">';
                    echo '</form>';
                    echo '</div>';

                    $i++;
                    if($i % 3 == 0)
                        echo '</div>';
              }
              mysqli_close($link);
            }
            else if(isset($_POST['seleziona']))//se e' stato cliccato il pulsante di una categoria
            {
                $codCategoria = $_POST['codCategoria'];
                $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
                $query = "SELECT * FROM categoria WHERE codCategoria = $codCategoria";
                $ris = mysqli_query($link,$query);
                $riga = mysqli_fetch_array($ris);
                $nomeCategoria = $riga['nome'];
                $nomeFoto = $riga['nomeFoto'];
                //setto le variabili del recordset
                
                //stampo il form per modificare i dati
                echo '
                <form method="POST" enctype="multipart/form-data" id="form">
                    <h3>Sicuro di voler eliminare questa categoria?</h3><br>
                    <h3>Tutti i prodotti legati a questa categoria saranno eliminati</h3><br>
                    <div class="row">
                        <div class="col">
                        <input type="text" class="form-control" placeholder="Nome categoria" name="nome" id="nome" value="'.$nomeCategoria.'" readonly>
                        </div>
                    </div>
                    <br>
                    <div class="row" id="rigaFoto">
                        <div class="form-group">';
                        //stampo la foto corrente col bottone elimina
                        $percorsoFoto = "../../../../images/categorieProdotti/"; //percorso dove sono salvate le foto
                        echo '<div class="col" style="text-align:left" id="divFotoCaricata">';
                        echo '<img src = "'.$percorsoFoto.$nomeFoto.'"width = "100vh" height="100vh" id="foto"><br><br>';
                        echo '</div>';

                echo'    </div>
                    </div>
                    <br>
                    <div style="text-align:center">
                        <div class="row">
                            <div class="col-md-3 my-3 mx-auto">
                                <form>
                                    <input type="hidden" name="nomeFoto" value="'.$nomeFoto.'">
                                    <button class="btn btn-dark bottoneHome" name="elimina" type="submit" value="'.$codCategoria.'">Elimina</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </form>';
                
                mysqli_close($link);
            }
            else //inviato il form di eliminazione
            {
                $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');
                $codCategoria = $_POST['elimina'];
                $nomeCategoria = $_POST['nome'];
                $nomeFoto = $_POST['nomeFoto'];
                //elimino istanza
                $query = "DELETE FROM categoria WHERE codCategoria = $codCategoria";
                //echo $query.'<br>';
                mysqli_query($link,$query) or die("impossibile eseguire query categoria");
                $percorsoFoto = "../../../../images/categorieProdotti/";
                //rimuovo la foto
                unlink($percorsoFoto.$nomeFoto);
                //echo $percorsoFoto.$nomeFoto.'.jpg<br>';
                mysqli_close($link);
                echo '<br><div class="container">L\'operazione &egrave; andata a buon fine.<br><br><div class="row">';
                echo '<div class="col-6 mx-auto" style="text-align:center"><a href="./elimina.php"><button class="btn btn-dark bottoneHome" type="button">Elimina un\'altra categoria</button></a></div>';
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
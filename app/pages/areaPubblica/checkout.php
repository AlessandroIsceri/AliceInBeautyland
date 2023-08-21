<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
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
    <div class="container">
        <h3>Il tuo carrello</h3>
        <div class = "containerCheckout">
            <?php
                if(isset($_POST['codProdotto']))
                if(sizeof($_POST['codProdotto']) == 0)
                {
                    echo 'Il tuo carrello &egrave; vuoto';
                }
            ?>
            <div class="row align-items-center">
                <div class="col-md-3 col-sm-3 col-3 mx-auto" style="text-align:center;">
                    <div style="border-radius:50%;color:white;background-color:#ff33cc;">
                        <p style="font-size:5vh;padding:5%;" id="login">
                        <?php
                            if(isset($_SESSION['nome']))
                                echo '✓';
                            else
                                echo '1';
                        ?>
                        </p>
                    </div>
                    <p style="font-size:3vh;color:#ff33cc">Login</p>
                </div>
                <div class="col-md-3 col-sm-3 col-3 mx-auto" style="text-align:center;">
                    <div style="border-radius:50%;color:white;background-color:#ff33cc;">
                        <p style="font-size:5vh;padding:5%;" id="indirizzo">
                        <?php
                        if(isset($_POST['indirizzoConfermato'])||(isset($_POST['procediAlPagamento'])))
                            echo '✓';
                        else
                            echo '2';
                        ?>
                        </p>
                    </div>
                    <p style="font-size:3vh;color:#ff33cc">Indirizzo</p>
                </div>
                <div class="col-md-3 col-sm-3 col-3 mx-auto" style="text-align:center;">
                    <div style="border-radius:50%;color:white;background-color:#ff33cc;">
                        <p style="font-size:5vh;padding:5%;" id="indirizzo">
                        <?php
                            if((isset($_POST['procediAlPagamento'])))
                                echo '✓';
                            else
                                echo '3';
                        ?>
                        </p>
                    </div>
                    <p style="font-size:3vh;color:#ff33cc">Carrello</p>
                </div>
                <div class="col-md-3 col-sm-3 col-3 mx-auto" style="text-align:center;">
                    <div style="border-radius:50%;color:white;background-color:#ff33cc;">
                        <p style="font-size:5vh;padding:5%;" id="indirizzo">4</p>
                    </div>
                    <p style="font-size:3vh;color:#ff33cc">Paga</p>
                </div>
            </div>
            <div id="checkoutInfo" style="padding:5%;">
                <?php 
                    if(!isset($_SESSION['nome']))
                    {
                        echo '<div style="text-align:center">';
                        echo '<a href="../areaPubblica/login.php"><button class="btn btn-dark bottoneHome">Effettua il login</button></a>';
                        echo '</div>';
                    }
                    else
                    {
                        if(isset($_POST['indirizzoConfermato'])&&(!isset($_POST['procediAlPagmento'])))
                        {
                            //stampo il carrello
                            
                            $codProdotti = json_decode($_COOKIE['codProdotti']);
                            $quantita = json_decode($_COOKIE['quantita']);
                            if(sizeof($codProdotti) == 0)
                            {
                                echo '<h3 style="color:#ff33cc">Il carrello é vuoto!</h3>';
                            }
                            else
                            {
                                $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');
                                $totale = 0;
                                echo '<h3 style="color:#ff33cc">Riepilogo ordine</h3>';
                                for($i = 0; $i < sizeof($codProdotti);$i++)
                                {
                                    echo '<div class="row align-items-center">';
                                    echo '<div class="col-12 col-sm-4 col-md-2">';
                                    //stampo la foto,query prepared  
                                    $queryFoto = "SELECT nomeFoto FROM fotoprodotto WHERE codProdotto = ? LIMIT 1";
                                    $prepStatement = mysqli_prepare($link, $queryFoto);
                                    mysqli_stmt_bind_param($prepStatement,'i',$codProdotti[$i]);
                                    mysqli_stmt_execute($prepStatement);
                                    $risFoto = mysqli_stmt_get_result($prepStatement);                          
                                    $rigaFoto = mysqli_fetch_array($risFoto);
                                    $percorsoFoto = '../../images/prodotti/';
                                    $foto = $percorsoFoto.$rigaFoto['nomeFoto'];
                                    echo '<img height="100vh" width="100vh" src="'.$foto.'">';
                                    echo '</div>';
                                    echo '<div class="col-12 col-sm-9 col-md-4">';
                                    $query = "SELECT nome,prezzo FROM prodotto WHERE codProdotto = ?";
                                    $prepStatement1 = mysqli_prepare($link, $query);
                                    mysqli_stmt_bind_param($prepStatement1,'i',$codProdotti[$i]);
                                    mysqli_stmt_execute($prepStatement1);
                                    $ris = mysqli_stmt_get_result($prepStatement1);                               
                                    $riga = mysqli_fetch_array($ris);
                                    echo '<h4>'.$riga['nome'].'</h4>';
                                    echo '</div>';
                                    echo '<div class="col-12 col-sm-6 col-md-3">';
                                    echo '<h4>Quantit&agrave;: '.$quantita[$i].'</h4>';
                                    echo '</div>';
                                    echo '<div class="col-12 col-sm-6 col-md-3">';
                                    echo '<h4>Prezzo: '.$quantita[$i]*$riga['prezzo'].'€</h4>';
                                    echo '</div>';
                                    echo '</div><hr style="background-color:#ff33cc;height:2px;">';
                                    $totale += $quantita[$i]*$riga['prezzo'];
                                }
                                echo '<div class="row"><div class="col-3"></div><div class="col-3"></div><div class="col-3"></div><div class="col-3">';
                                echo '<h3>Totale: '.$totale.'€</h3><form method="POST"><button class="btn btn-dark bottoneHome" name="procediAlPagamento">Procedi al pagamento</button></form>';
                                echo '</div></div>';
                                mysqli_close($link);
                            }
                        }
                        else if(!isset($_POST['procediAlPagamento']))
                        {
                            //inserisci indirizzo col select o con inserimento
                            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');
                            $query = "SELECT citta,via,CAP,numeroCivico FROM account WHERE email = '".$_SESSION['email']."'";
                            $riga = mysqli_fetch_array(mysqli_query($link,$query));
                            //stampo indirizzo
                            echo '<form method="POST">';

                            /*echo '
                           
                            <table class="table">
                                <thead style="background-color:rgba(255, 51, 204, 0.7);">
                                    <tr>
                                        <th scope="col">Citt&agrave;</th>
                                        <th scope="col">CAP</th>
                                        <th scope="col">Via</th>
                                        <th scope="col">Numero Civico</th>';
                                    echo'
                                    </tr>
                                </thead>
                            <tbody>';*/
                            echo '<div class="row">';
                            echo '<div class="col-6 my-3"><input type="text" style="background-color:white" readonly class="form-control input" value="Città: '.$riga['citta'].'"></div>';
                            echo '<div class="col-6 my-3"><input type="text" style="background-color:white" readonly class="form-control input" value="CAP: '.$riga['CAP'].'"></div>';
                            echo '<div class="col-6 my-3"><input type="text" style="background-color:white" readonly class="form-control input" value="Via: '.$riga['via'].'"></div>';
                            echo '<div class="col-6 my-3"><input type="text" style="background-color:white" readonly class="form-control input" value="Numero civico: '.$riga['numeroCivico'].'"></div>';
                            echo '</div>';

                            /*echo '</tbody>
                            </table>';*/

                            echo '<br><div style="text-align:center"><button type="submit" name="indirizzoConfermato" class="btn btn-dark bottoneHome">Conferma indirizzo</button></div>';
                            echo '</form>';
                            
                            mysqli_close($link);
                        }
                        else
                        {
                            //pagamento
                            echo '<div class="row align-items-center"><div class="col-12 mx-auto" style="text-align:center;" id="colonnaPagamento">';
                            echo '<script src="https://www.paypal.com/sdk/js?client-id=test"></script>
                            <script>paypal.Buttons().render(document.getElementById("colonnaPagamento"));</script>';
                            echo '</div></div>';
                            
                            $codProdotti = json_decode($_COOKIE['codProdotti']);
                            foreach($codProdotti as $codProdotto)
                            {
                                
                                //aggiorno file excel
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
                                    $n_celle = count($rigaFile);
                                    if($n_celle != 1)
                                    {
                                        //i = 1 salto il cod prodotto
                                        if($rigaFile[0] == $codProdotto)
                                        {
                                            $datiMese = explode('--',$rigaFile[$mese]);
                                            $visualizzazioni = $datiMese[1];
                                            $acquisti = $datiMese[0];
                                            $acquisti++;
                                            $rigaFile[$mese] = $acquisti.'--'.$visualizzazioni;
                                        }
                                        //print_r($rigaFile);
                                        fputcsv($fileOutput, $rigaFile,';');
                                    }
                                }
                                fclose($file);
                                fclose($fileOutput);
                                //elimino vecchio file e rinomino il nuovo
                                unlink('../../vendite/2021.csv');
                                rename('../../vendite/temp.csv', '../../vendite/2021.csv');
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <?php
        include('../static/footer.html');
    ?>

</body>
<link rel="stylesheet" href="../static/style.css">
<link rel="stylesheet" href="./styles/checkout.css">
</html>
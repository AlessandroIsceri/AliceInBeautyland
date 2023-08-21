<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenota</title>
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
    <div class="container-fluid" id="containerPagina">
        <br>
        <?php
        if(isset($_SESSION['nome']))
            if(!isset($_POST['prenota']))
            {
                if(isset($_POST['codTrattamento']))
                {
        ?>
        <div class="row">
            <div class="col-md-12 col-sm-12 mx-auto d-flex justify-content-center" id="scritteAppuntamento">
                <div class="container" style="width:80%;background-color:rgba(255, 255, 255, 1);padding:30px;border: 1px solid rgba(0, 0, 0, 0.4);">
                    <h3 style="color:#ff33cc">Prenota subito un appuntamento</h3>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ducimus voluptate iure hic, asperiores tempora deleniti placeat enim sunt omnis corporis, tempore quod non blanditiis laudantium suscipit. Recusandae fuga dolores totam.</p>
                </div>
            </div>
        </div>
        <br><br><br>
        <div class="row">
            <div class="col-md-12 col-sm-12 mx-auto justify-content-center" id="formPrenotazione">
                <div class="container" id="containerForm">
                    <form id="form" action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="POST">
                        <h3 style="color:#ff33cc">Prenota un appuntamento</h3>
                        <div class="row">
                            <div class="col mx-auto">
                                <select class="form-control mb 3" name="trattamento" id="trattamento" onchange="mostraOrariDisponibili();">
                                    <?php
                                        $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');
                                        $query = "SELECT * FROM trattamento";
                                        $ris = mysqli_query($link,$query);
                                        while($riga = mysqli_fetch_array($ris))
                                        {
                                            echo '<option value="'.$riga['codTrattamento'];
                                            if(isset($_POST['codTrattamento'])&&($_POST['codTrattamento'] == $riga['codTrattamento']))
                                                echo ' "selected>';
                                            else
                                                echo '">';
                                            echo $riga['nome'].' - Prezzo - '.$riga['prezzo'].'€</option>';
                                        }
                                        mysqli_close($link);
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="data">Seleziona la data in cui si desidera prenotare:
                                    <input type="date" id="data" onchange="mostraOrariDisponibili();" name="data" min="<?php echo date('Y-m-d');?>" max="<?php echo date('Y-m-d', strtotime("+3 months", strtotime(date('Y-m-d')))); //si puo prenotare massimo 3 mesi prima ?>">
                                </label>
                            </div>
                        </div>
                        
                        <div class="row" id="rigaBottone">
                            <div class="col mx-auto">
                                <button type="submit" name="prenota" id="prenota" class="btn btn-dark bottoneHome" disabled>prenota</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br><br>
        <?php   
                }
                else
                {
                    $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');
                    $queryFoto = "SELECT * FROM trattamento";
                    $risFoto = mysqli_query($link,$queryFoto);
                    $i = 0;
                    echo '<div class="accordion row" id="accordion">';
                    echo '<div class="col-md-2 col-sm-12">';
                    while($rigaQueryFoto = mysqli_fetch_array($risFoto))
                    {
                        echo '<div class="card" style="border:none;">
                        <div id="div'.$i.'">
                            <button id="bottone'.$i.'"class="btn btn-primary bottoneHome';
                        if($i==0)
                            echo' bottoneAttivo"';
                        else 
                            echo '"';
                        echo 'type="button" onclick="rimuoviClasse(this);" style="width:100%;" data-toggle="collapse" data-target="#collapse'.$i.'" aria-expanded="true" aria-controls="collapse">
                                '.$rigaQueryFoto['nome'].'
                            </button>
                        </div>
                        </div>
                        <br>';
                        $i++;
                    }
                    echo '</div>';  //colonna1 (trattamenti)
                    echo '<div class="col-md-10 col-sm-12" style="text-align:left;">';
                    $risFoto = mysqli_query($link,$queryFoto);
                    $i = 0;
                    while($rigaQueryFoto = mysqli_fetch_array($risFoto))
                    {   
                        echo '<div id="collapse'.$i.'"';
                        if($i == 0)
                            echo 'class="collapse show"';
                        else
                            echo 'class="collapse"';
                        echo 'aria-labelledby="div'.$i.'" data-parent="#accordion">
                                <div class="card card-body" style="border:none;">';
                        $percorsoFoto = "../../images/trattamenti/";
                        echo '<div class="row"><div class="col-md-6 col-sm-6">';
                        echo '<img src="'.$percorsoFoto.$rigaQueryFoto['nomeFoto'].'" height="300vh" class="d-block w-100" alt="...">';
                        echo '</div>';//col1
                        echo '<div class="col-md-6 col-sm-6">';
                        echo '<div class="card"><br>';
                        echo '<h2 class="card-title" style="font-size:2em;text-align:center">'.$rigaQueryFoto['nome'].'</h2>';

                        echo '<div class="card-body">';
                        echo '<p class="card-text" style="font-size:1.5em;text-align:center;">Durata: '.$rigaQueryFoto['durata'].'</p>';
                        echo '<p class="card-text" style="font-size:1.5em;text-align:center;">Prezzo: '.$rigaQueryFoto['prezzo'].'€</p></div>';
                        echo '<ul class="list-group list-group-flush">';
                        echo '<li class="list-group-item" style="text-align:center"><form method="POST" action="./prenota.php"><button type="submit" style="text-align:center;" class="btn btn-dark bottoneHome" name="codTrattamento" value="'.$rigaQueryFoto['codTrattamento'].'">Prenota ora!</button></form></li>';
                        echo '</div>';//card
                        echo '</div>';//col2
                        echo '</div>';//row
                        echo '
                                </div>
                            </div>';
                        $i++;
                    }
                    echo '</div>';  //colonna2(infoTrattamenti)
                    echo '</div>';  //accordion
                }
            }
            else
            {
                $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');
                $email = $_SESSION['email'];
                $codTrattamento = $_POST['trattamento'];
                $data = $_POST['data'];
                $oraInizio = $_POST['ora'];
                //non serve la query prepared, il codTrattamento arriva da una select con metodo post
                $queryTrattamento = "SELECT durata FROM trattamento WHERE codTrattamento = $codTrattamento";
                $rigaDurata = mysqli_fetch_array(mysqli_query($link,$queryTrattamento));

                $durataOre = $rigaDurata['durata'];
                $secs = strtotime($durataOre)-strtotime("00:00:00");
                $oraFine = date("H:i:s",strtotime($oraInizio)+$secs);
                //query innocua, la mail è già stata ripulita nel momento della registrazione, il codTrattamento arriva da select e gli altri dati arrivano da input type date o time
                $query = "INSERT INTO prenota(codTrattamento,email,data,oraInizio,oraFine) VALUES($codTrattamento,'$email','$data','$oraInizio','$oraFine')";
                mysqli_query($link,$query);
                mysqli_close($link);
                echo '<div class="container"><h3>Hai prenotato correttamente!</h3></div>';
            }
        else
        {
            echo '<div class="container mt-5" style="background-color:rgba(255, 255, 255, 0.4);font-size:7vh"> Effettua il login per poter prenotare</div><br><br>';
        }
        ?>
        <div>
            
        </div>
    </div>
    <?php
        include('../static/footer.html');
    ?> 
</body>
<link rel="stylesheet" href="./styles/prenota.css">
<link rel="stylesheet" href="../static/style.css">
<script src="./scripts/prenota.js"></script>
</html>
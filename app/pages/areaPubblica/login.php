<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Effettua il login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./styles/login.css">
    <script src="./scripts/registerLogin.js"></script>
    <script src="./scripts/sha512.js"></script>
    <script src="./scripts/login.js"></script>
    <link rel="icon" href="../../images/logo.png">
</head>
<body>
    <?php
        //includo file funzioni
        require ('../static/php/funzioni.php');
        include('../static/php/connessioneDb.php');
        sec_session_start();
        if(!isset($_POST['login']))
        {
    ?>
    <div class="sfondo"></div>
    <div class='container'>
            <div>
                <br>
                <h4>Ben tornato!</h4>
                <br>
                <p>Inserisci le tue credenziali per accedere</p>
            </div>
        
        <form method="POST" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">
            <div class='form-row align-items-center'>
                <div class="col-lg-1"></div>
                <div class='col-8 my-2'>
                    <label for="email" id="email1"><medium class="text-muted">Email</medium></label>
                    <input type="email" name="email" id="email" class="form-control" onfocus="alza(this);" onblur="abbassa(this);">
                </div>
            </div>
            <div class='form-row align-items-center'>
                <div class="col-lg-1"></div>
                <div class='col-8 my-2'>
                    <label for="password" id="password1"><medium class="text-muted">Password</medium></label>
                    <input type="password" class="form-control" name="password" id="password" onfocus="alza(this);" onblur="abbassa(this);">
                </div>
                <div id="bottoneFoto" class="col-auto mx-0 my-2">
                    <img src="../../images/icons/occhioAperto.png" onclick="cambiaIcona(this);" id="occhio" class="occhio" style="background:transparent;" height="60%" width="60%">
                </div>
            </div>
            <br>
            <input type="hidden" name="login">
            <button type="button" onclick="criptaPassword(this.form);" class="btn btn-dark" value="login" id="login">Login</button>
            <hr style="visibility:hidden">
        </form>
        <p>Non hai un account? <a style="color:#ff33cc" href="./register.php">Clicca qui per registrarti!</a></p>
        <br>
    </div>
    <?php
        }
        else
        {
            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nel login');
            $email = $password = "";
            $email = ripulisciDato('email');
            $password = ripulisciDato('passwordCriptata');
            $query = "SELECT email,password,nome,ruolo,salt FROM account WHERE email = ?";
            $prepStatement = mysqli_prepare($link, $query);
            mysqli_stmt_bind_param($prepStatement,'s',$email);
            mysqli_stmt_execute($prepStatement);
            $ris = mysqli_stmt_get_result($prepStatement);
            $ris = mysqli_fetch_array($ris);
            //controllo gli ultimi accessi
            if(!controllaAccessi($ris['email'],$link))
            {
                //attacco a forza bruta non verificato
                //procedo con il controllo del login
                $salt = $ris['salt']; 
                $password = hash('sha512',$password.$salt);
                if($ris['password'] == $password)
                {
                    //inserisco nella tabella login il tentativo
                    $query = "INSERT INTO login(email,tempo,esito) VALUES (?,?,?)";
                    $prepStatement = mysqli_prepare($link, $query);
                    $time = time();
                    $esito = 1;
                    mysqli_stmt_bind_param($prepStatement, 'ssi', $email, $time,$esito);
                    mysqli_stmt_execute($prepStatement);
                    $_SESSION['nome'] = $ris['nome'];
                    $_SESSION['ruolo'] = $ris['ruolo'];
                    $_SESSION['email'] = $ris['email'];
                    if($ris['ruolo'] == 'admin')
                    {
                        header('Location: ../areaRiservataAdmin/index.php');
                        exit();
                    }
                    else
                    {
                        header('Location: ../../../index.php');
                        exit();
                    }
                }
                else
                {
                    echo 'Utente non riconosciuto';
                    //inserisco nella tabella login il tentativo
                    $query = "INSERT INTO login(email,tempo,esito) VALUES (?,?,?)";
                    $prepStatement = mysqli_prepare($link, $query);
                    $time = time();
                    $esito = 0;
                    mysqli_stmt_bind_param($prepStatement, 'ssi', $email, $time,$esito);
                    mysqli_stmt_execute($prepStatement);
                }
            }
            else
            {
                //sono stati effettuati piu' di 5 accessi nelle ultime due ore
                echo 'Hai sbagliato la password troppe volte nelle ultime due ore, aspetta prima di riprovare.';
            }
            
            mysqli_close($link);
        }
    ?>
</body>
</html>
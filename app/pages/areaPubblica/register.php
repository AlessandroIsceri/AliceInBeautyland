<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrati</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./styles/register.css">
    <script src="./scripts/registerLogin.js"></script>
    <script src="./scripts/register.js"></script>
    <script src="./scripts/sha512.js"></script>
    <link rel="icon" href="../../images/logo.png">
</head>
<body>
    
    <div class='container mt-5'>
    <?php
        //includo file funzioni
        require ('../static/php/funzioni.php');
        include('../static/php/connessioneDb.php');
        sec_session_start();
        if(!isset($_POST['registrati']))
        {
    ?>
            <div>
                <br>
                <h4>Benvenuto alla pagina di registrazione</h4>
                <div style="color:red;font-size:small">* campi obbligatori</div>
                <div id="errore"></div>
            </div>
        
        <form method="POST" id="form" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" style="text-align:center" onsubmit="return checkForm(this.password,this.ripetiPassword);">
            <h5>Dati anagrafici</h5>
            <div class="form-row align-items-center mt-3">
                <!--Dati anagrafici-->
                <div class='col-auto mx-auto my-1'>
                    <label for="nome" id="nome1" class="label"><medium class="text-muted">Nome<span style="color:red">*</span></medium></label>
                    <input type="text"  name="nome" id="nome" class="form-control mb-2" onfocus="alza(this);" onblur="abbassa(this);" required>
                </div>

                <div class='col-auto mx-auto my-1'>
                    <label for="cognome" id="cognome1" class="label"><medium class="text-muted">Cognome<span style="color:red">*</span></medium></label>
                    <input type="text"  name="cognome" id="cognome" class="form-control mb-2" onfocus="alza(this);" onblur="abbassa(this);" required>
                </div>

                <div class='col-auto mx-auto my-1'>
                    <label for="email" id="email1" class="label"><medium class="text-muted">Email<span style="color:red">*</span></medium></label>
                    <input type="email"  name="email" id="email" class="form-control mb-2" onfocus="alza(this);" onblur="abbassa(this);" required>
                </div>
            
                
            </div>
            <br>
            <h5>Indirizzo per le spedizioni</h5>
            <div class='form-row align-items-center'>
                <!--indirizzo per spedizioni-->
                <div class='col-auto mx-auto my-1'>
                    <label for="citta" id="citta1" class="label"><medium class="text-muted">Citta<span style="color:red">*</span></medium></label>
                    <input type="text"  name="citta" id="citta" class="form-control mb-2" onfocus="alza(this);" onblur="abbassa(this);" required>
                </div>

                <div class='col-auto mx-auto my-1'>
                    <label for="CAP" id="CAP1" class="label"><medium class="text-muted">CAP<span style="color:red">*</span></medium></label>
                    <input type="number" min="0" name="CAP" id="CAP" class="form-control mb-2" onfocus="alza(this);" onblur="abbassa(this);" required>
                </div>

                <div class='col-auto mx-auto my-1'>
                    <label for="via" id="via1" class="label"><medium class="text-muted">Via<span style="color:red">*</span></medium></label>
                    <input type="text"  name="via" id="via" class="form-control mb-2" onfocus="alza(this);" onblur="abbassa(this);" required>
                </div>

                <div class='col-auto mx-auto my-1'>
                    <label for="civico" id="civico1" class="label"><medium class="text-muted">Civico<span style="color:red">*</span></medium></label>
                    <input type="number"  min="0" name="civico" id="civico" class="form-control mb-2" onfocus="alza(this);" onblur="abbassa(this);" required>
                </div>
            </div>
            <br>
            <h5>Patologie
                <a data-toggle="collapse" href="#categorie" role="button" aria-expanded="false" aria-controls="categorie">
                    <img src="../../images/icons/plus.png" height="30vh" width="30vh" class="image" onclick="gira(this);">
                </a>
            </h5>
            <div class='form-row align-items-center'>
                <div class="col mx-auto my-1">
                    <div class="collapse" id="categorie" style="margin-left:-2%">
                        <?php
                            //prendo le patologie dal db e le stampo
                            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
                            $query = "SELECT * FROM patologia";
                            $ris = mysqli_query($link,$query);
                            while($riga = mysqli_fetch_array($ris))
                            {
                                echo '<label class="checkContainer">'.$riga['nomePatologia'];
                                echo '<input type="checkbox" name="patologie[]" value="'.$riga['nomePatologia'].'">';
                                echo '<span class="checkmark"></span>';
                                echo '</label><br>';
                            }
                            mysqli_close($link);
                        ?>
                    </div>
                </div>
            </div>
            <br>
            <h5>Password</h5>
            <p id="passwordDiverse" style="color:red"></p>
            <div class='form-row align-items-center'>
                <!--doppia pw e email-->
                <div class="col-4">
                </div>
                <div class='col-4 my-1'>
                    <label for="password" id="password1" class="label"><medium class="text-muted">Password<span style="color:red">*</span></medium></label>
                    <input type="password" class="form-control mb-2" name="password" id="password" onfocus="alza(this);" onblur="abbassa(this);">
                </div>
                <div id="bottoneFoto" class="col-auto mx-0 my-1">
                    <img src="../../images/icons/occhioAperto.png" onclick="cambiaIcona(this);" id="occhio" class="occhio" width="60%" height="60%">
                </div>
            </div>
            <br>
            <div class='form-row align-items-center'>
                <div class="col-4">
                </div>
                <div class='col-4 my-1'>
                    <label for="ripetiPassword" id="ripetiPassword1" class="label"><medium class="text-muted">Ripeti password<span style="color:red">*</span></medium></label>
                    <input type="password" class="form-control mb-2" name="ripetiPassword" id="ripetiPassword" onfocus="alza(this);" onblur="abbassa(this);">
                </div>
                <div class="col-auto mx-0 my-1">
                    <img src="../../images/icons/occhioAperto.png" onclick="cambiaIcona(this);" id="ripetiOcchio" class="occhio" width="60%" height="60%">
                </div>
            </div>
            <br>
            <label class="checkContainer">Accetto e acconsento il trattamento dei dati personali
            <input type="checkbox" name="trattamentoDati" id="trattamentoDati" value="yes">
            <span class="checkmark"></span>
            </label><br>
            <br>
            <input type="hidden" name="registrati">
            <button type="button" class="btn btn-dark"  value="registrati" id="registrati" onclick="criptaPassword(this.form);">Registrati</button>
            <hr style="visibility:hidden">
        </form>
        <p>Hai già un account? <a style="color:#ff33cc" href="./login.php">Clicca qui per effettuare il login!</a></p>
        <br>
        <?php
        }
        else
        {
            $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore nella connessione al db');
            //prendo i dati e eseguo registrazione
            print_r($_POST);
            $nome = $cognome = $email =  "";
            $citta = $via = $nCivico = $CAP = "";
            $password = $ripetiPassword = "";
            $patologie = "";
            $nome = ripulisciDato('nome');
            $cognome = ripulisciDato('cognome');
            $email = ripulisciDato('email');
            $CAP = ripulisciDato('CAP');
            $citta = ripulisciDato('citta');
            $nCivico = ripulisciDato('civico');
            $via = ripulisciDato('via');
            $password = ripulisciDato('passwordCriptata');
            $ripetiPassword = ripulisciDato('ripetiPasswordCriptata');
            //genero una salt
            $salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
            $patologie = [];
            if(isset($_POST['patologie']))  //inserisco le patologie selezionate in un'array
                $patologie = $_POST['patologie'];
            //cripto la password
            $password = hash('sha512',$password.$salt);
            $query = "INSERT INTO account(nome, cognome, citta, CAP, via, numeroCivico, email, password,salt, ruolo) VALUES (?,?,?,?,?,?,?,?,?,?)";
            $prepStatement = mysqli_prepare($link, $query);
            $ruolo = 'user';
            mysqli_stmt_bind_param($prepStatement, 'sssisissss', $nome,$cognome,$citta,$CAP,$via,$nCivico,$email,$password,$salt,$ruolo);
            mysqli_stmt_execute($prepStatement);
            if(sizeof($patologie) != 0 )
                foreach($patologie as $patologia)
                {
                    //inserisco le patologie
                    $query = "INSERT INTO personapatologia(email, nomePatologia) VALUES('$email','$patologia')";
                    mysqli_query($link,$query) or die('Errore nella registrazione patologie');
                }
            mysqli_close($link);
            $_SESSION['nome'] = $nome;
            $_SESSION['ruolo'] = 'utente';
            $_SESSION['email'] = $email;
            header('Location: ../../../index.php'); //reinderizzo alla home
        }
    ?>
    </div>
    <br><br>
</body>
<link rel="stylesheet" href="../static/style.css">
<script src="../static/script.js"></script>
</html>
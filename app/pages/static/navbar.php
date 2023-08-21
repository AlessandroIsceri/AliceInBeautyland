<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Parisienne&display=swap" rel="stylesheet">

<?php
    //include('./php/connessioneDb.php');
    $loggato = false;
    $percorsoFoto = '../../';
    $percorsoLink = '../';
    if(isset($posizione) && ($posizione == 0))
    {
    	$percorsoLink = './app/pages/';
        $percorsoFoto = './app/';
    }
    if(isset($posizione) && ($posizione == -2))
    {
        $percorsoFoto = '../../../../';
        $percorsoLink = '../../../';
    }
    require ($percorsoLink.'/static/php/funzioni.php');
    include($percorsoLink.'/static/php/connessioneDb.php');
    sec_session_start();
    
    if(isset($_SESSION['nome']))
    {
        $loggato = true;
    }
    if(!isset($_SESSION['ruolo']))
    {
        $_SESSION['ruolo'] = 'user';
    }
    
        
?>
<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?php echo $percorsoLink.'../../index.php'?>">
        <img src="<?php echo $percorsoFoto.'/images/logo.png'; ?>" width="50vh" height="50vh">
    </a>
    <div style="text-align:center" class="col-6">
        <span style="font-size:5vh;font-family: 'Parisienne', cursive;text-align:center;color:#ff33cc;">Alice in beautyland</span>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto" style="text-align:center;" id="menu">
            <li class="nav-item dropdown" id="colonnaMenu" >
                <button class="elemento" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                        
                        //devo controllare che l'utente sia loggato
                        if($loggato)
                            echo 'Ciao, '.$_SESSION['nome'];
                    ?>
                    <img src="<?php echo $percorsoFoto.'images/icons/utente.png';?>" width="20vh" height="20vh">
                    <div class="sottolineato">
                    </div>
                </button>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                        if($loggato)
                            {
                                echo '<a class="dropdown-item" href="'.$percorsoLink.'areaPubblica/modificaProfilo.php">Modifica il profilo</a>';
                                echo '<a class="dropdown-item" href="'.$percorsoLink.'areaPubblica/logout.php">Logout</a>';                          
                            }
                            else
                                echo '<a class="dropdown-item" href="'.$percorsoLink.'areaPubblica/login.php">Accedi</a>'
                    ?>
                </div> 
            </li>
            <li class="nav-item active" id="colonnaMenu">
                    <?php
                    if($_SESSION['ruolo'] == 'admin')
                        {
                            echo '<a href = "'.$percorsoLink.'areaRiservataAdmin/gestioneAppuntamenti.php">';
                            echo '<button class="elemento">';
                            echo 'Gestisci gli appuntamenti';
                        }
                    else
                        {
                            echo '<a href = "'.$percorsoLink.'areaPubblica/prenota.php">';
                            echo '<button class="elemento">';
                            echo 'Prenota un appuntamento';
                        }
                    ?>    
                        <div class="sottolineato">
                        </div>
                    </button>
                </a>
            </li>
            <li class="nav-item active" id="colonnaMenu">
                    <?php
                    if($_SESSION['ruolo'] == 'admin')
                        {
                            echo '<a href = "'.$percorsoLink.'areaRiservataAdmin/gestioneShop.php">';
                            echo '<button class="elemento">';
                            echo 'Gestisci lo shop';
                        }
                    else
                        {
                            echo '<a href = "'.$percorsoLink.'areaPubblica/shop.php">';
                            echo '<button class="elemento">';
                            echo 'Shop';
                        }
                    ?>   
                        <div class="sottolineato">
                        </div>
                    </button>
                </a>
            </li>
            <?php
            if($_SESSION['ruolo'] != 'admin')
                {
                    //conto numero di prodotti
                    if(isset($_COOKIE['codProdotti']))
                    {
                        $codiciProdotti = json_decode($_COOKIE['codProdotti']);
                        $numeroProdotti = 0;
                        foreach($codiciProdotti as $codProdotto)
                        {  
                            $numeroProdotti++;
                        }
                    }
                    else
                        $numeroProdotti = 0;
                //se non è admin, stampo carrello
            ?>  
                <li class="nav-item active" id="colonnaMenu" onclick="mostraCarrello();">
                    <button class="elemento" id="numeroProdotti" data-toggle="tooltip" data-placement="left" value="<?php echo $numeroProdotti;?>" title="<?php echo 'Ci sono '.$numeroProdotti.' prodotti'?>">
                        <img src="<?php echo $percorsoFoto.'images/icons/carrello.png'?>" width="20vh" height="20vh">
                        <div class="sottolineato">
                        </div>
                    </button>
                </li>
            <?php
                }
                else
                {
                //stampo le altre sezioni admin
            ?>
                <li class="nav-item active" id="colonnaMenu">
                    <a href="<?php echo $percorsoLink.'areaRiservataAdmin/otherPages/analitiche/visualizza.php';?>">
                        <button class="elemento">
                            Analytics
                            <div class="sottolineato">
                            </div>
                        </button>
                    </a>
                </li> 
                <li class="nav-item active" id="colonnaMenu">
                    <a href="<?php echo $percorsoLink.'areaRiservataAdmin/otherPages/valutazioni/elimina.php';?>">
                        <button class="elemento">
                            Valutazioni
                            <div class="sottolineato">
                            </div>
                        </button>
                    </a>
                </li>
            <?php
                }
            ?>  
        </ul>
    </div>     
</nav>
<form method="POST" action="<?php echo $percorsoLink.'areaPubblica/checkout.php';?>">
    <div id="divCarrello" class="container" style="overflow: scroll;padding:30px">
        <div class="row">
            <div class="col">
                <h3>Carrello </h3>
            </div>
            <div class="col" style="text-align:right">
                <i class="fa fa-times fa-3x" onclick="mostraCarrello();" id="x"></i>
            </div>
        </div>
         
        <hr style="background-color:#ff33cc;height:2px">
        <div id="contenutoCarrello" >
            <?php
                $totale = 0;
                //stampo il carrello se i cookie sono settati
                if(isset($_COOKIE['codProdotti']))
                {
                    //da json ad array
                    $codiciProdotti = json_decode($_COOKIE['codProdotti']);
                    $numeroProdotti = 0;
                    $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');
                    foreach($codiciProdotti as $codProdotto)
                    {  
                        $query = "SELECT * FROM prodotto WHERE codProdotto = $codProdotto";
                        $riga = mysqli_fetch_array(mysqli_query($link,$query));
                        $queryImmagine = "SELECT nomeFoto FROM fotoprodotto WHERE codProdotto = $codProdotto LIMIT 1";
                        $rigaFoto = mysqli_fetch_array(mysqli_query($link,$queryImmagine));
                        $immagine = $rigaFoto['nomeFoto'];
                        $quantita = json_decode($_COOKIE['quantita']);
                        $costo = $riga['prezzo'];
                        echo '<div class="row align-items-center">';
                        //colonna 1
                        echo '<div class="col-lg-6 col-md-8 col sm-12 my-1">';
                        echo '<img height="50vh" width="50vh" src="'.$percorsoFoto.'images/prodotti/'.$immagine.'"><br>';
                        echo '<label style="font-size: 3vh; text-align: left;">'.$riga['nome'].'</label>';
                        echo '<input type="hidden" name="codProdotto[]" value="'.$codProdotto.'">';
                        echo '</div>';
                        //colonna 2
                        echo '<div class="col-lg-3 col-md-2 col sm-12 my-1">
                        <i class="fa fa-plus fa-x" id="piu" onclick="aumenta(this);" style="color: rgb(255, 51, 204); margin-right: 3px;"></i>
                        <label id="quantita" style="font-size: 3vh; text-align: center;"> '.$quantita[$numeroProdotti].' </label>
                        <i class="fa fa-minus fa-x" id="meno" onclick="diminuisci(this);" style="color: rgb(255, 51, 204); margin-left: 3px;"></i>
                        <input type="hidden" name="quantita[]" value="'.$quantita[$numeroProdotti].'">
                        <input type="hidden" id="numeroProdotto" value="'.$numeroProdotti.'">
                        </div>';
                        //colonna 3
                        echo '<div class="col-lg-3 col-md-2 col-sm-12 my-1">';
                        $prezzoItem = intval($quantita[$numeroProdotti])*floatval($costo);
                        echo '<label style="font-size: 3vh; text-align: right;">'.$prezzoItem.'€</label>
                        </div>';
                        $totale += $prezzoItem;
                        echo '</div>';
                        echo '<hr style="background-color:#ff33cc;height:1px">';
                        $numeroProdotti++;
                    }
                }
            ?>
        </div>
        <!--<hr style="background-color:#ff33cc;height:2px">-->
        <div style="text-align:center">
            <label style="font-size:3vh">Totale: <?php echo $totale?>€</label><br>
            <button class="btn btn-dark bottoneHome" name="paga">Procedi al pagamento</button>
        </div>
    </div>
</form>
<div id="filter" class="filter"></div>
<style>
    nav{
    z-index: 1;
}
.elemento{
    color:black;
    width: 100%;
    border: none;
    font-size: 16px;
    cursor: pointer;
    text-align: center;
    background:none;
    margin-right: 0px;
}
.elemento:focus{
  outline: none;
}
#menu:hover > #colonnaMenu > a >.elemento{
    opacity: 0.5;
}
#menu:hover > #colonnaMenu > a > .elemento:hover{
    opacity: 1;
} 
#menu:hover > #colonnaMenu > .elemento{
    opacity: 0.5;
}
#menu:hover > #colonnaMenu > .elemento:hover{
    opacity: 1;
} 
.elemento:hover > .sottolineato{
  border: 0;
  border-bottom: 4px solid #ff33cc;
  width: 0;
  animation: separator-width 0.25s ease-in-out forwards;
}
@keyframes separator-width {
  0% {
    width: 0;
  }
  100% {
    width: 100%;
  }
}
.sottolineato {
    border : 4px solid transparent;
}
#colonnaMenu{
    margin-top:2vh;
}
#divCarrello{
    top:0%;
    right:-5%;
    position:fixed;
    display:none;
    height:100%;
    width:50%;
    background-color:white;
    z-index:6;
}
@keyframes mostraCarrello {
  0% {
    right:-100vh;
  }
  100% {
    right:0;
  }
}

@keyframes nascondiCarrello {
  0% {
    right:0;
  }
  100% {
    right:-100vh;
  }
}

body{
    overflow-x: hidden;
}
::-webkit-scrollbar {
display: none;
}

.fa-minus:hover,.fa-plus:hover{
    cursor: pointer;
}
.carousel-indicators{
    z-index:4;
}

#x{
    cursor: pointer;
}
.cookieBar{
    position: fixed;
    z-index:10;
    bottom:0;
    text-align:center;
    width:100%;
    background-color:grey;
    padding:30px;
    color:white;
}
.filter{
    height:500vh;
    width:500vh;
    position:absolute;
    background-color:rgba(0,0,0,0.4);
    top:0;
    right:0;
    z-index:5;
    display:none;
}
</style>


<script>
    //attiva il tooltip
    $(function () {
    $('[data-toggle="tooltip"]').tooltip()
    })
    var visibile = false;
    var carrello = document.getElementById('divCarrello');
    function mostraCarrello(){
        if(visibile == false){
            carrello.style.display = 'unset';
            carrello.style.animation = 'mostraCarrello';
            carrello.style.animationDuration = '1.5s';
            carrello.style.animationFillMode = 'forwards';
            visibile = true;
            //document.body.style.filter = "grayscale(100%)";
            document.getElementById("filter").style.display = "inline";
            document.body.style.overflow="hidden";
        }
        else{
            carrello.style.animation = 'nascondiCarrello';
            carrello.style.animationDuration = '1.5s';
            carrello.style.animationFillMode = 'forwards';
            setTimeout(function(){ carrello.style.display = "none"; }, 1500);
            visibile = false;
            document.getElementById("filter").style.display = "none";
            document.body.style.overflow="initial";
        }
    }

var nProdotti;
function diminuisci(icona){
    //colContatore è la colonna con +,- e numero di oggetti
    var colOggetto = icona.parentNode;
    //diminuisco il figlio di posto 1 (il paragrafo che conta)
    var numero = colOggetto.children[1].textContent;
    //scalo nella riga, poi nella prima colonna (dove c'è un paragrafo in pos 1 col nome del prodotto)
    var riga = colOggetto.parentNode;
    var nomeProdotto = riga.children[0].children[1].innerHTML;

    //modifico il costo
    var labelCosto = riga.children[2].children[0]
    var costoAttuale = labelCosto.innerHTML;
    //tolgo il simbolo dell'euro
    costoAttuale = costoAttuale.substring(0, costoAttuale.length-1);
    costoAttuale = parseFloat(costoAttuale);
    var costoProdotto = costoAttuale / numero;

    //diminuisco il totale
    //modifico il totale-> riga -> contenuto carrello -> carrello -> ultimo figlio(div del totale) ->label è il figlio in pos 0
    var carrello = riga.parentNode.parentNode;
    var labelTotale = carrello.children[carrello.childElementCount - 1].children[0];

    var costoTotaleAttuale = labelTotale.textContent;
    //tolgo simbolo euro, parte da 8 perchè prima c'è la scritta totale
    costoTotaleAttuale = costoTotaleAttuale.substring(7, costoTotaleAttuale.length-1);
    costoTotaleAttuale = parseFloat(costoTotaleAttuale);
    costoTotaleAttuale -= parseFloat(costoProdotto);
    
    labelTotale.textContent = 'Totale: '+costoTotaleAttuale+'€';

    if(numero == 1)
    {
        if (confirm('L\'elemento '+nomeProdotto+' verrà cancellato dal carrello, sicuro di voler procedere?')) 
        {
            var contenutoCarrello = riga.parentNode;
            console.log(contenutoCarrello);
            var ultimaRiga = contenutoCarrello.children[contenutoCarrello.childElementCount - 2];   //attenzione all'hr
            var ultimaPosizione = parseInt(ultimaRiga.children[1].children[4].value);
            //compatto l'array
            var posizioneAttuale = parseInt(colOggetto.children[4].value);
            //rimuovo la riga e hr
            var hrDaRimuovere = riga.nextSibling //hr
            contenutoCarrello.removeChild(riga);
            contenutoCarrello.removeChild(hrDaRimuovere);
            //rimuovo il cookie corrente e scalo gli altri
            var quantita = getQuantita();
            var arrayQuantita = JSON.parse(quantita);
            //in arrayquantita ci sono le quantita in ordine di ogni prodotto.
            arrayQuantita.splice(posizioneAttuale, 1);
            quantita = JSON.stringify(arrayQuantita);
            document.cookie = 'quantita ='+quantita;
            //rimuovo il cookie anche coi codici prodotto
            var prodotti = getCodProdotti();
            var arrayProdotti = JSON.parse(prodotti);
            //console.log(arrayProdotti);
            arrayProdotti.splice(posizioneAttuale, 1);
            console.log('Dopo la modifica '+arrayProdotti);
            prodotti = JSON.stringify(arrayProdotti);
            //console.log(prodotti);
            document.cookie = 'codProdotti ='+prodotti;
            
            for(posizioneAttuale; posizioneAttuale < ultimaPosizione; posizioneAttuale++)
            {
                var rigaAttuale = contenutoCarrello.children[posizioneAttuale];
                rigaAttuale.children[1].children[4].value = rigaAttuale.children[1].children[4].value - 1;
            }
            nProdotti = parseInt(document.getElementById('numeroProdotti').value);
            nProdotti--;
            //console.log(nProdotti);
            //riscrivo il numero di prodotti nel carrello
            document.getElementById('numeroProdotti').setAttribute('data-original-title',"Ci sono "+nProdotti+" prodotti");
            document.getElementById('numeroProdotti').value = nProdotti;
        }
    }
    else
    {
        var costoConSottrazione = costoAttuale - costoProdotto;
        labelCosto.textContent = costoConSottrazione+'€';
        numero--;
        colOggetto.children[1].textContent = ' '+numero+' ';
        colOggetto.children[3].value = numero;


        //aggiorno il cookie
        var quantita = getQuantita();
        //posizione nel carrello dell'oggetto
        var posizione = parseInt(colOggetto.children[4].value);
        console.log("pos: "+posizione);
        var arrayQuantita = JSON.parse(quantita);
        arrayQuantita[posizione] = arrayQuantita[posizione] - 1;
        //in arrayquantita ci sono le quantita in ordine di ogni prodotto.
        quantita = JSON.stringify(arrayQuantita);
        document.cookie = 'quantita ='+quantita;
    }
}
function aumenta(icona){
    var colOggetto = icona.parentNode;
    //diminuisco il figlio di posto 1 (il paragrafo che conta)
    var numero = colOggetto.children[1].textContent;
    //modifico il costo
    var riga = colOggetto.parentNode;
    var labelCosto = riga.children[2].children[0];
    var costoAttuale = labelCosto.textContent;
    //tolgo il simbolo dell'euro
    costoAttuale = costoAttuale.substring(0, costoAttuale.length-1);
    costoAttuale = parseFloat(costoAttuale);
    var costoProdotto = costoAttuale / numero;
    var costoConSomma = costoAttuale + costoProdotto;
    labelCosto.innerHTML = costoConSomma+'€';
    numero++;
    colOggetto.children[1].textContent = ' '+numero+' ';
    colOggetto.children[3].value = numero;
    //modifico il totale-> riga -> contenuto carrello -> carrello -> ultimo figlio(div del totale) ->label è il figlio in pos 0

    var carrello = riga.parentNode.parentNode;
    var labelTotale = carrello.children[carrello.childElementCount - 1].children[0];

    var costoTotaleAttuale = labelTotale.textContent;
    //tolgo simbolo euro, parte da 8 perchè prima c'è la scritta totale
    costoTotaleAttuale = costoTotaleAttuale.substring(7, costoTotaleAttuale.length-1);
    costoTotaleAttuale = parseFloat(costoTotaleAttuale);
    costoTotaleAttuale += costoProdotto;
    
    labelTotale.textContent = 'Totale: '+costoTotaleAttuale+'€';

    //aggiorno il cookie
    var quantita = getQuantita();  
    //console.log(quantita);
    //posizione nel carrello dell'oggetto
    var posizione = parseInt(colOggetto.children[4].value);
    console.log("pos: "+posizione);
    var arrayQuantita = JSON.parse(quantita);
    arrayQuantita[posizione] = arrayQuantita[posizione] + 1
    //in arrayquantita ci sono le quantita in ordine di ogni prodotto.
    quantita = JSON.stringify(arrayQuantita);
    document.cookie = 'quantita ='+quantita;
}

function getQuantita(){
    var cookie= decodeURIComponent(document.cookie);
    //array con tutti i cookie
    cookie = cookie.split(';');
    var cookieSplittati;
    console.log("cookie: "+cookie);
    for(var i = 0; i < cookie.length; i++)
    {
        cookieSplittati = cookie[i].split('=');
        console.log("split: "+cookieSplittati);
        //lo scorro e cerco e assegno l'array con le quantita ad una variabile,era buggato e questa è la solzuione
        if((cookieSplittati[0] == 'quantita')||(cookieSplittati[0] == ' quantita'))
        {
            return cookieSplittati[1];
        }
    }
}

function getCodProdotti(){
    var cookie= decodeURIComponent(document.cookie);
    //array con tutti i cookie
    cookie = cookie.split(';');

    var cookieSplittati;
    for(var i = 0; i < cookie.length; i++)
    {
        //lo scorro e cerco se c'è l'array coi prodotti lo assegno all'array cookie prodotti
        cookieSplittati = cookie[i].split('=');
        if(cookieSplittati[0] == 'codProdotti'){
            return cookieSplittati[1];
        }
    }
}
//controllo se l'utente accede da telefono
var mobile;
window.onload = function(){
    let check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    //console.log(check);
    mobile = check;
    if(mobile)
    {
        document.getElementById("divCarrello").style.width = "100%"; //size carrello
        //se siamo nello shop chiamo la funzione che mi serve
        if(document.title == "shop")
        {
            resize();
        }
        
    }
};

//funzione di accettazione dei cookie
function accetta(){
    document.cookie = 'cookie = accettati';
    location.reload();
}

function rifiuta(){
    location.reload();
}
</script>
<?php
    if (!isset($_COOKIE["cookie"]))
    {
    echo '
        <div class="cookieBar">
            <h3>Prima di continuare...</h3>
            <p>Questo sito utilizza cookie tecnici, analytics e di terze parti. <br>Proseguendo nella navigazione accetti l’utilizzo dei cookie.</p>
            <div class="cookiebar-buttons">
                <button class="btn btn-dark bottoneHome" onclick="rifiuta();">Rifiuto<span class="sr-only"> i cookies</span></button>
                <button class="btn btn-dark bottoneHome" onclick="accetta();">Accetto<span class="sr-only"> i cookies</span></button>
            </div>
        </div>
    ';
    ?>
    <style>
    body{
        overflow:hidden;
    }
    .filter{
        display:inline;
    }
    </style>
    <?php
    }
?>
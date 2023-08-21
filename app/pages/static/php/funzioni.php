<?php
function ripulisciDato($dato)
{
    if(isset($_POST[$dato]))
    {
        $temp = $_POST[$dato];
        $temp = trim($temp);
        $temp = htmlentities($temp);
    }
    return $temp;
}
function stampaProdotto($pagina,$link,$query)
{ 
    if($pagina == 'shop')
        $percorsoFoto = '../../images/prodotti/';
    else
        $percorsoFoto = "../../../../images/prodotti/"; //percorso dove sono salvate le foto

    //connessione al db
    $ris = mysqli_query($link,$query);  //eseguo query
    $elementiRiga = 0;                  //conto gli elementi per capire quando creare nuove righe
    while($riga = mysqli_fetch_array($ris)) //finche ci sono righe nel recordset
    {
        //setto le variabili del recordset
        $codProdotto = $riga['codProdotto'];
        $nomeProdotto = $riga['nome'];
        //$descrizione = $riga['descrizione'];
        $marca = $riga['marca'];
        $codCategoria = $riga['codCategoria'];

        if($elementiRiga % 3 == 0)          //se le righe sono multipli di 3, creo una nuova riga
            echo '<div class="row">';
        
        //stampo oggetti html per la carta
        echo '<div class="col-md-3 my-3 mx-auto"><div class="card h-100" style="width: auto;">';
        
        
        //recupero foto
        $queryFoto = "SELECT nomeFoto FROM fotoprodotto WHERE codProdotto = '$codProdotto'";
        $rigaQueryFoto = mysqli_fetch_all(mysqli_query($link,$queryFoto));
        //apro carosello
        echo '<div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel"><div class="carousel-inner"';
        if($pagina == 'shop')
            echo ' id="carosello"';
        echo '>';
        $i = 0; //nel primo ciclo dovrò settare la prima immagine come attiva
        foreach($rigaQueryFoto as $value)   //scorro le foto del prodotto
        {
            $nomeFoto = $value[0];          //ottengo la foto(si trova nell'array in pos 0)
            $foto = $percorsoFoto.$nomeFoto;
            
            echo '<div class="carousel-item';

            if($i==0)       //setto la prima immagine come attiva
                echo ' active';
            echo '">';
            //stampo foto
            echo '<img src="'.$foto.'" class="d-block w-100" alt="..." height="200vh" ></div>';
            $i++;
        }

        if($pagina == 'shop')//se siamo nello shop metto div animato
        {
            echo '<div class="infoNascoste">';
            echo '<a href="prodotti.php?prodotto='.$codProdotto.'"><button class="btn btn-dark bottoneHome">Scopri di pi&ugrave;</button></a></div>';
        }
        
        echo '</div></div>';
        //sotto parte della carta
        //stampo i dati del prodotto
        echo '<div class="card-body">';
        echo '<h5 class="card-title">'.$nomeProdotto.'</h5>';
        echo '<p class="card-text">'.$riga['prezzo'].'€</p></div>';
        echo '<ul class="list-group list-group-flush">';
        echo '<li class="list-group-item">'.$marca.'</li>';
        
        //se non siamo nello shop stampo anche la categoria per farle vedere al titolare
        if($pagina != 'shop')
        {
            $queryCategoria = "SELECT nome FROM categoria WHERE codCategoria = $codCategoria";
            $rigaCategoria = mysqli_fetch_array(mysqli_query($link,$queryCategoria));

            echo '<li class="list-group-item">Categoria: '.$rigaCategoria['nome'].'</li>';
        }
            
        //valutazione e' la media delle valutazioni
        //calcolo la media 
        $queryValutazione = "SELECT valutazione FROM recensione WHERE codProdotto =".$codProdotto;
        $risValutazione = mysqli_query($link,$queryValutazione);
        $totaleValutazioni = 0;
        $c = 0;
        if(mysqli_fetch_array($risValutazione) == 0)
        {
            $valutazione = 0;
        }
        else
        {
            $risValutazione = mysqli_query($link,$queryValutazione);
            while($rigaValutazione = mysqli_fetch_array($risValutazione))
            {
                $totaleValutazioni += $rigaValutazione['valutazione'];
                $c++;
            }
            $valutazione = $totaleValutazioni / $c;
        }
        
        echo '<li class="list-group-item">';
        for( $i = 0; $i < 5; $i++ )
        {
            //ogni $i è una stella, da 0 a 5
            //floor arrotonda all'intero per difetto
            if( floor( $valutazione ) - $i >= 1 )
            {   
                //intero - valore della stella attuale >=1, stella piena
                echo '<i class="fa fa-star" style="color:#ff33cc"></i>'; 
            }
            elseif( $valutazione - $i > 0 )
            { 
                //intero - valore della stella attuale >0, stella a metà
                echo '<i class="fa fa-star-half-o" style="color:#ff33cc"></i>'; 
            }
            else
            { 
                //intero - valore della stella attuale = 0, stella vuota
                echo '<i class="fa fa-star-o" style="color:#ff33cc"></i>'; 
            }
        }
        echo '</li>';
        echo '</ul>';
        if($pagina == 'shop')
        {
            echo '<div class="card-body">';
            //inserisco onclick
            echo '<div style="display:inline-block;margin-right:5%;"><a class="card-link">Compra ora</a></div>';
            echo '<div style="display:inline-block;"><a onclick="aggiungiProdotto(this);" class="card-link">Aggiungi al carrello</a></div>';
            echo '<input type="hidden" name="codProdotto" value="'.$codProdotto.'">';
            echo '</div>';
        }
        else if($pagina == 'modifica')
        {
            echo '<div class="card-body">';
            echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
            echo '<input type="submit" class="btn btn-dark bottoneHome" name="seleziona" value="Seleziona">';
            echo '<input type="hidden" name="codProdotto" value="'.$codProdotto.'">';
            echo '</form></div>';
        }
        else if($pagina == 'elimina')    //elimina
        {
            echo '<div class="card-body">';
            echo '<form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
            echo '<input type="submit" class="btn btn-dark bottoneHome" name="seleziona" value="Seleziona">';
            echo '<input type="hidden" name="codProdotto" value="'.$codProdotto.'">';
            echo '</form></div>';
        }
        //chiudo la carta
        echo '</div></div>';
        $elementiRiga++;
        if($elementiRiga % 3 == 0)  //se siamo ad un multiplo di 3, chiudo la riga
            echo '</div>';
    }
    echo '</div>';
}   


//funzione per attacchi a forza bruta
function controllaAccessi($email, $link) 
{
    // Recupero il timestamp
    $ora = time();
    // Vengono analizzati tutti i tentativi di login a partire dalle ultime due ore.
    $ultimeDueOre = $ora - (2 * 60 * 60);
    $sql="SELECT codLogin FROM login WHERE email = '$email' AND esito = 0 AND tempo > '$ultimeDueOre'";
    
    if ($result = mysqli_query($link,$sql)) 
    {
        // Verifico l'esistenza di più di 5 tentativi di login falliti.
        if(mysqli_num_rows($result) > 5) 
        {
            return true;
        } 
        else 
        {
            return false;
        }
    }
}
//sessione sicura
function sec_session_start() 
    {
        $session_name = 'sec_session_id'; // Imposta un nome di sessione
        $secure = false; // Imposta il parametro a true se vuoi usare il protocollo 'https'.
        $httponly = true; // Questo impedirà ad un javascript di essere in grado di accedere all'id di sessione.
        ini_set('session.use_only_cookies', 1); // Forza la sessione ad utilizzare solo i cookie.
        $cookieParams = session_get_cookie_params(); // Legge i parametri correnti relativi ai cookie.
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"],
        $cookieParams["domain"], $secure, $httponly);
        session_name($session_name); // Imposta il nome di sessione con quello prescelto all'inizio della funzione.
        session_start(); // Avvia la sessione php.
        session_regenerate_id(); // Rigenera la sessione e cancella quella creata in precedenza.
    }

?>
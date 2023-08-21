<?php
    include('../../static/php/connessioneDb.php');
    //variabili comuni
    $codTrattamento = $_GET['trattamento'];
    $link = mysqli_connect($indirizzo,$utente,$password,$db) or die('Errore');
    //recupero la durata del trattamento richiesto
    $queryTrattamento = "SELECT durata FROM trattamento WHERE codTrattamento = $codTrattamento";
    $rigaDurata = mysqli_fetch_array(mysqli_query($link,$queryTrattamento));

    $durataOre = $rigaDurata['durata'];

    $durata = convertiInMinuti($durataOre);

    //prendo tutti gli appuntamenti prenotati per la data richiesta
    $data = $_GET['data'];
    $queryData = "SELECT orainizio,orafine FROM prenota WHERE data = '$data' ORDER BY oraInizio ASC";
    $ris = mysqli_query($link,$queryData);
    $riga = mysqli_fetch_all($ris);
	
    if(sizeof($riga) == 0)
        echo "Tutti gli orari sono disponibili";
    else
    {
    //controllo se è stato cliccato input ora o input data
    if(!isset($_GET['ora']))
    {        
        $stampa = false;
        $stringa = "";
        if(sizeof($riga) == 0)
        {
            $stampa = true;
            echo 'Tutti gli orari sono disponibili';
        }
        
        //controllo prima riga
        $tempoLibero = ( strtotime($riga[0][1]) - strtotime('08:00:00')) / 60;
        if($tempoLibero >= $durata)
        {
            $stringa = $stringa.'<br>08:00:00';
            $stampa = true;
        }

        for($i = 0;$i < sizeof($riga) - 1; $i++)
        {
        	
            //in po 0 oraInizio in pos 1 oraFine, tempo libero in minuti!
            $tempoLibero = ( strtotime($riga[$i + 1][0]) - strtotime($riga[$i][1])  ) / 60;
            if($tempoLibero >= $durata)
                {
                    $stringa = $stringa.'<br>'.$riga[$i][1];
                    $stampa = true;
                }
        }
        //controllo ultima riga
        $tempoLibero = ( strtotime('19:00:00')- strtotime($riga[sizeof($riga) - 1][1])) / 60;
       	if($tempoLibero >= $durata)
          {
            $stringa = $stringa.'<br>'.$riga[sizeof($riga) - 1][1];
            $stampa = true;
          }
        
        //se non è stato stampato nulla, stampo orario fine ultimo trattamento se c'è tempo tra esso e la chiusura del negozio (19)
        if(!$stampa)
        {
            echo 'Non ci sono orari disponibili';
        }
        else
            echo $stringa;
    }
    else
    {
        //è stato cliccato input ora 
        $ora = $_GET['ora'];
		//calcolo oraFine
        $temp = strtotime($ora)+($durata*60);
        $oraFine = date("H:i:s",$temp);
        $stampa = false;
        //cerco se c'è spazio tra due trattamenti
        for($i = 0;$i < sizeof($riga) - 1; $i++)
        {
            //controllo se l'orario di inizio si trova DOPO all'orario di fine della prentazione
            //precedente e l'orario di fine si trova PRIMA dell'orario dell'inizio della prenota
            //zione successiva
            $riga[$i][0];

            $riga[$i][1];

            if(strtotime($riga[$i][1]) <= strtotime($ora) && strtotime($riga[$i+1][0]) >= strtotime($oraFine))
            {
                $stampa = true;
            }
        }
        if(!$stampa)
        {
          	
            //controllo se l'ora è dopo a tutti gli appuntamenti o prima di tutti
            //se è prima del primo ed è dopo l'apertura (per forza, non selezionabile prima delle 8)
            if(strtotime($oraFine) <= strtotime($riga[0][0]))
            {
                
                $stampa = true;
            }
            
            //se l'ora di inizio è dopo l'ora di fine dell'ultimo ed è prima della chiusura
            if(strtotime($ora) >= strtotime($riga[sizeof($riga) - 1][1]) && strtotime($oraFine) <= strtotime('19:00:00'))
            {
                $stampa = true;
            }   
        }
        if(!$stampa)
            echo 'false';
    }
    }

    
    
    function convertiInMinuti($x){
        //converto durata in minuti
        //$durata = (ore x 60) + (minuti)
        $valori = explode(':',$x);
        return intval($valori[0])*60 + intval($valori[1]);
    }  
?>
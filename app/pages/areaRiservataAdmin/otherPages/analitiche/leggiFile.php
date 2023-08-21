<?php
    $richiesta = $_GET['richiesta'];    //prendo la richiesta
    $codProdotto = $_GET['codProdotto'];    //prendo codProdotto
    
    //apro il file in lettura
    $file = fopen("../../../../vendite/2021.csv", "r") or die("Non sono riuscito ad aprire il file!");
    //salto riga introduttiva
    $rigaFile = fgetcsv($file,1000,';');
    $visualizzazioni = [];
    $acquisti = [];
    while(!feof($file))
    {
        //fgetcsv(file, length, separator, enclosure)
        $rigaFile = fgetcsv($file,1000,';');    //singola riga del file
        if($rigaFile == "")
            break;
        $n_celle = count($rigaFile);
        if($n_celle != 0) 
        {
            //i = 1 per saltare il cod prodotto (prima cella su excel)
            if($rigaFile[0] == $codProdotto)    //se la prima cella é uguale al codProdotto
            {
                for($i = 1;$i <= 12;$i++)   //scorro le 12 colonne (12 mesi)
                {
                    $datiMese = explode('--',$rigaFile[$i]);//file excel: acquisti--visual
                    array_push($visualizzazioni,$datiMese[1]);//inserisco i dati del mese corrente
                    array_push($acquisti,$datiMese[0]);//inserisco i dati del mese corrente
                }
            }
        }
    }
    fclose($file);
    //visualFin = cosa deve visualizzare l'utente alla fine
    if($richiesta == 1) //richiesta == 1, sto richiedendo le visual
    {
        $visualFin = json_encode($visualizzazioni);
    }
    else    //altrimenti richiedo acquisti
    {
        $visualFin = json_encode($acquisti);
    }
    $visualFin = str_replace('"', "", $visualFin);
    echo $visualFin;
?>
<?php
    require('../static/php/funzioni.php');  //file delle funzioni per eseguire sec_session_start()
    sec_session_start();    //sessione attuale
    session_destroy();      //distruggo la sessione attuale
    header('Location: ../../../index.php'); //reinderizzo alla home
    exit(); //termino lo script
?>
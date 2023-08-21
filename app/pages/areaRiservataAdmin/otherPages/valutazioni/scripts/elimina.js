function chiedi(bottone){
    //chiede se si é sicuri di voler cancellare la recensione selezionata
    var form = bottone.parentNode;
    var riga = bottone.parentNode.parentNode.parentNode;
    var msg = "La recensione scritta da "+riga.children[0].innerHTML;
    msg += " con testo '"+riga.children[1].innerHTML+"'";
    msg += " sarà eliminata, sicur* di voler procedere?";
    if(confirm(msg)){
        form.submit();
    }
}
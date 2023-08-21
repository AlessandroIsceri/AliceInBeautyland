function chiedi(bottone){
    //chiedi se si é sicuri di voler eliminare un appuntamento
    var form = bottone.parentNode;
    var riga = bottone.parentNode.parentNode.parentNode;
    var msg = "L'appuntamento prenotato da "+riga.children[2].innerHTML;
    msg += " con orario inizio "+riga.children[3].innerHTML;
    msg += " e orario fine "+riga.children[4].innerHTML;
    msg += " sarà eliminato, sicur* di voler procedere?";
    if(confirm(msg)){
        form.submit();
    }
}
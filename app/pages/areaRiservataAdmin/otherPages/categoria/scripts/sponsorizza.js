function controllaMassimo(){
    var checkboxes = document.getElementsByName('sponsor[]');
    var contaChecked = contaCheck(checkboxes);  //ritorna numero di checkbox checked
    //se é uguale a 2, disabilito le altre
    if(contaChecked == 2)
    {
        for(var i = 0; i < checkboxes.length; i++)
        {
            if(!checkboxes[i].checked)
            {
                checkboxes[i].disabled = true;
            }
        }
    }
    else    //altrimenti rimuovo il disabled cosí da renderle selezionabili
    {
        for(var i = 0; i < checkboxes.length; i++)
        {
            if(!checkboxes[i].checked && checkboxes[i].disabled == true)
            {
                checkboxes[i].disabled = false;
            }
        }
    }
}
function checkForm(form){
    //controlla che esattamente 2 checkboxes siano checked
    var checkboxes = document.getElementsByName('sponsor[]');
    var contaChecked = contaCheck(checkboxes);  //ritorna numero di checkbox checked
    if(contaChecked != 2)
    {
        alert('Devi selezionare due categorie da sponsorizzare!');
    }
    else
    {
        form.submit()
    }
}

function contaCheck(checkboxes){
    //conta quante checkbox sono checked
    contaChecked = 0;
    for(var i = 0; i < checkboxes.length; i++)
    {
        if(checkboxes[i].checked)
        {
            contaChecked++;
        }
    }
    return contaChecked;
}
function checkForm(form){
//controllo estensione file 
var foto = document.getElementById('foto');
var errore = false;
if(foto.value == '')
{
    errore = true;
    document.getElementById('paragrafoFoto').innerHTML = 'Devi caricare un file!';
}
else
{
    var nomeFile = foto.value;
    var punto = nomeFile.lastIndexOf('.');
    var estensione = nomeFile.substring(punto+1, nomeFile.length);
    if(estensione != 'jpg' && estensione != 'png')
    {
        document.getElementById('paragrafoFoto').innerHTML = 'Devi caricare un file JPG o PNG!';
        errore = true;
    }
    else
    {
        document.getElementById('paragrafoFoto').innerHTML = '';
    }
    var nome = document.getElementById('nome').value;
    if(nome == '' )
    {
        errore = true;
    }

    if(errore == false)
    {
        document.getElementById('inserisci').value = 'inserisci';
        form.submit();
    }
    else
        document.getElementById('errore').innerHTML = 'Form non completato correttamente';
    }
}
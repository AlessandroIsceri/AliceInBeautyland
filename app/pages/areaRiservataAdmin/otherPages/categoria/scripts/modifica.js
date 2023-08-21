function eliminaFoto(bottoneCliccato){
    //cancellazione foto
    var div = bottoneCliccato.parentNode;
    //console.log(hidden);
    if (confirm('La foto verrà cancellata, sicuro di voler procedere?'))
    {
        var foto = document.getElementById('foto');
        div.removeChild(foto);
        div.removeChild(bottoneCliccato);
        var label = document.createElement('label');
        label.for = "foto";
        label.innerHTML = "Carica una nuova foto";
        var input = document.createElement('input');
        input.className = "form-control-file";
        input.type = "file";
        input.id = "fotoDaCaricare";
        input.name = "fotoDaCaricare";
        var p = document.createElement('p');
        p.style.color = "red";
        p.id = "paragrafoFoto";
        div.appendChild(label);
        div.appendChild(input);
        div.appendChild(p);
    }
}


function checkForm(form){
//controllo che le foto siano dell'estenzione corretta
var foto = document.getElementById('foto');
var errore = false;
var caricaFoto = document.getElementById('fotoDaCaricare');
if(foto == null)
{
    //la foto è stata rimossa, controllo il file
    if(caricaFoto.value == undefined)
    {
        errore = true;
        document.getElementById('paragrafoFoto').innerHTML = 'Devi caricare un file!';
    }
    else
    {
    var nomeFile = caricaFoto.value;
    var punto = nomeFile.lastIndexOf('.');
    var estensione = nomeFile.substring(punto+1, nomeFile.length);
    if(estensione != 'jpg' && estensione != 'png')
    {
        document.getElementById('paragrafoFoto').innerHTML = 'Devi caricare un file JPG o PNG!';
        errore = true;
    }
    var nome = document.getElementById('nome').value;
    if(nome == '' )
    {
        errore = true;
    }

    if(errore == false)
    {
        form.submit();
    }
    else
        document.getElementById('errore').innerHTML = 'Form non completato correttamente';
    }
}
else
{
    var nome = document.getElementById('nome').value;
    if(nome != '' )
    {
        form.submit();
    }
    else
    {
        document.getElementById('errore').innerHTML = 'Form non completato correttamente';
    }
}
}
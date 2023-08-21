function eliminaFoto(bottoneCliccato){
    //gestisco eliminazione foto
    var div = bottoneCliccato.parentNode;
    //console.log(hidden);
    if (confirm('La foto verrà cancellata, sicuro di voler procedere?'))
    {
        div.parentNode.removeChild(div);
        var hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'fotoEliminate[]';
        hidden.value = div.childNodes[0].id;
        document.getElementById('form').appendChild(hidden);
    }
}
var numeroFotoVisibili = 0;
function cambiaNumeroFoto(selectNumeroFoto){
    var numeroFoto = parseInt(selectNumeroFoto.value);
    if(numeroFoto > numeroFotoVisibili)
    {
        //creo input foto aggiuntivi
        var i = numeroFotoVisibili + 1;
        for(i; i <= numeroFoto; i++)
        {
            var div = document.createElement('div');
            div.classList.add('form-group');
            div.id = 'divFoto'+i;
            var label = document.createElement('label');
            label.for = "foto"+i;
            label.innerHTML = "Seleziona foto "+i;
            var input = document.createElement('input');
            input.type="file";
            input.classList.add('form-control-file');
            input.id="foto"+i;
            input.name="foto[]";
            var paragrafo = document.createElement('p');
            paragrafo.id = "paragrafoFoto"+i;
            paragrafo.style.color = "red";
            var riga = document.getElementById('rigaFoto');
            div.appendChild(label);
            div.appendChild(input);
            div.appendChild(paragrafo);
            riga.appendChild(div);
        }
        numeroFotoVisibili = numeroFoto;
    }
    else if(numeroFoto < numeroFotoVisibili)
    {
        //popup per foto che verranno perse
        if (confirm('Le foto '+numeroFoto+'-'+numeroFotoVisibili+' verrnano cancellate, sicuro di voler procedere?')) {
        // cancello gli input in piú
        var i = parseInt(numeroFoto) + 1;
        var divNuovo, inputNuovo;
        for(i; i <= numeroFotoVisibili; i++)
        {
            divNuovo = document.getElementById('divFoto'+i);
            inputNuovo = document.getElementById('foto'+i);
            var riga = document.getElementById('rigaFoto');
            riga.removeChild(divNuovo);
        }
        numeroFotoVisibili = numeroFoto;
        }
    }
}

function checkFile(form){
    //controllo che i file inviati siano del formato corretto
    var files = document.getElementsByName('foto[]');
    if(files.length != 0)
    {
        var errore = false;
        if(files[0].value == '')
            errore = true;
        for(var i = 1; i <= files.length; i++)
            {
                document.getElementById('paragrafoFoto'+i).innerHTML = "";
                var nomeFile = files[i-1].value;
                var punto = nomeFile.lastIndexOf('.');
                var estensione = nomeFile.substring(punto+1, nomeFile.length);
                if(estensione != 'jpg' && estensione != 'png')
                {
                    document.getElementById('paragrafoFoto'+i).innerHTML = 'Devi caricare un file JPG o PNG!';
                    errore = true;
                }  
            }
        var prezzo = document.getElementById('prezzo').value;
        var quantita = document.getElementById('quantita').value;
        var nome = document.getElementById('nome').value;
        var marca = document.getElementById('marca').value;
        var descrizione = document.getElementById('descrizione').value;
        if(prezzo == '' || quantita == '' || nome == '' || marca == '' || descrizione == '')
            {
                errore = true;
            }
        if(errore == false)
        {
            document.getElementById('modifica').value = 'modifica';
            form.submit();
        }
        else
            document.getElementById('errore').innerHTML = 'Form non completato correttamente';
    }
    else
        form.submit();
}

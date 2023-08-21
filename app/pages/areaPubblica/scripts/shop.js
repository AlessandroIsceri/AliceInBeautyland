var visibile = false;   //dice se é visibile la barra dei filtri
var sezioni = document.getElementById('sezioni');
var bottoneSezioni = document.getElementById('bottoneSezioni');
function mostraSezioni(){
    if(visibile == false){
        bottoneSezioni.style.visibility = 'hidden';
        sezioni.style.animationFillMode = 'forwards';
        if(!mobile)//se non si sta usando un telefono cellulare
        {
            //animazione sezione
            sezioni.style.display = 'unset';
            sezioni.style.animation = 'mostraSezioni';
            sezioni.style.animationDuration = '1s';
            //animazione body
            document.body.style.animation = 'animaBody';
            document.body.style.animationDuration = '1s';
            document.body.style.animationFillMode = 'forwards';
            setTimeout(function(){ 
                document.body.style.marginLeft = '25%';
                sezioni.style.marginLeft="25%";
            }, 1000);
            visibile = true;
        }
        else
        {
            //cellulare
            sezioni.style.animation = 'mostraSezioniCellulare';
            sezioni.style.animationDuration = '1.5s';
            sezioni.style.display = 'unset';
            sezioni.style.width = "100%";
            sezioni.style.backgroundColor = "white";
            document.getElementById('contenitoreSezioni').style.padding="0%";
            document.getElementById('contenitoreSezioni').style.paddingLeft="10%";
            document.getElementById('contenitoreSezioni').style.paddingRight="10%";
            sezioni.style.position = "relative"; 
            sezioni.style.left = "0%";  
            document.getElementById('close').style.position = "relative"; 
            visibile = true;
            
        }
    }
    else
    {
        if(!mobile)//se non si sta usando un telefono cellulare
        {
            //animazione sezione
            sezioni.style.animation = 'nascondiSezioni';
            sezioni.style.animationDuration = '1s';
            //animazione body
            document.body.style.animation = 'normaleBody';
            document.body.style.animationDuration = '1s';
            document.body.style.animationFillMode = 'forwards';
            setTimeout(function(){ 
                document.body.style.marginLeft = '0%';
                bottoneSezioni.style.visibility = 'unset'; 
                sezioni.style.marginLeft = '-25%';
            }, 1000);
            visibile = false;
        }
        else
        {
            //cellulare
            sezioni.style.animation = 'nascondiSezioniCellulare';
            sezioni.style.animationDuration = '1.5s';
            setTimeout(function(){ 
                bottoneSezioni.style.visibility = 'unset'; 
                sezioni.style.display = 'none';
                document.getElementById('sezioni').style.left = "-20%"; 
                document.getElementById('sezioni').style.position = "relative"; 
                document.getElementById('close').style.position = "relative"; 
                bottoneSezioni.style.visibility = 'unset';
            }, 1000); 
            visibile = false;
            
        }
    }
}
 
//quando si clicca aggiungi al carrello
var nProdotti = 0;
function aggiungiProdotto(link){
    //aggiungo il prodotto 
    var contenutoCarrello = document.getElementById('contenutoCarrello');
    var riga = document.createElement('div');
    riga.className = "row align-items-center";
    var img = document.createElement('img');
    img.height = 50;
    img.width = 50;
    //immagine, recupero la foto
    //carta
    var card = link.parentNode.parentNode.parentNode;
    var imgCarosello = card.children[0].children[0].children[0].children[0];
    
    var percorsoFoto = imgCarosello.getAttribute("src");
    img.src = percorsoFoto;
    var label1 = document.createElement('label');
    label1.style.fontSize = '3vh';
    label1.style.textAlign = "center";
    //nome prodotto
    var nomeProdotto = card.children[1].children[0].innerHTML;
    label1.textContent = " "+nomeProdotto;

    //recupero il codProdotto
    var codProdotto = link.parentNode.parentNode.children[2].value;

    //aggiungo un campo hidden per il form
    var hiddenCod = document.createElement('input');
    hiddenCod.type = "hidden";
    //codice prodotto
    hiddenCod.name = "codProdotto[]";
    hiddenCod.value = codProdotto;
    
    //aggiungo gli elementi alla colonna1 e poi alla riga
    var colonna1 = document.createElement('div');
    colonna1.className = "col-lg-6 col-md-8 col sm-12 my-1";
    colonna1.appendChild(img);
    colonna1.appendChild(document.createElement("br"));
    colonna1.appendChild(label1);
    colonna1.appendChild(hiddenCod);
    
    //colonna2
    var colonna2 = document.createElement('div');
    colonna2.className = "col-lg-3 col-md-2 col sm-12 my-1";
    var plus = document.createElement('i'); //icona del piú
    plus.className = "fa fa-plus fa-x";
    plus.style.color = "#ff33cc";
    plus.style.marginRight = "3px";
    plus.id="piu";
    plus.setAttribute('onclick','aumenta(this);');
    var label2 = document.createElement('label');   //label contenente la quantitá
    label2.style.fontSize = "3vh";
    label2.style.textAlign = "center";
    label2.id = "quantita";
    label2.textContent = " 1 ";
    var minus = document.createElement('i');    //icona del meno
    minus.className = "fa fa-minus fa-x";
    minus.style.color = "#ff33cc";
    minus.style.marginLeft = "3px";
    minus.id="meno";
    minus.setAttribute('onclick','diminuisci(this);');

    //aggiungo un campo hidden per il form
    var hiddenQuantita = document.createElement('input');
    hiddenQuantita.type = "hidden";
    //codice prodotto
    hiddenQuantita.name = "quantita[]";
    hiddenQuantita.value = "1";

    //tiene conto del numero di prodotti
    hiddenNumero = document.createElement('input');
    hiddenNumero.type = "hidden";
    hiddenNumero.id = "numeroProdotto";
    hiddenNumero.value = nProdotti;
    nProdotti++;

    //aggiungo elementi alla colonna
    colonna2.appendChild(plus);
    colonna2.appendChild(label2);
    colonna2.appendChild(minus);
    colonna2.appendChild(hiddenQuantita);
    colonna2.appendChild(hiddenNumero);

    //colonna3
    var colonna3 = document.createElement('div');
    colonna3.className = "col-lg-3 col-md-2 col-sm-12 my-1";
    var label3 = document.createElement('label');   //label contenente il prezzo
    label3.style.fontSize = "3vh";
    label3.style.textAlign = "right";
    //recupero il prezzo
    var prezzo = card.children[1].children[1].innerHTML;
    label3.textContent = prezzo;
    colonna3.appendChild(label3);

    //creo hr
    var hr = document.createElement("hr");
    hr.style.backgroundColor = "#ff33cc";
    hr.style.height = "1px";

    //aggiungo gli elementi al carrello
    riga.appendChild(colonna1);
    riga.appendChild(colonna2);
    riga.appendChild(colonna3);
    contenutoCarrello.appendChild(riga);
    contenutoCarrello.appendChild(hr);
    //modifico costo totale
    var labelTotale = carrello.children[carrello.childElementCount - 1].children[0];
    var costoTotaleAttuale = labelTotale.textContent;
    costoTotaleAttuale = costoTotaleAttuale.substring(7, costoTotaleAttuale.length-1);
    costoTotaleAttuale = parseFloat(costoTotaleAttuale);
    costoTotaleAttuale += parseFloat(prezzo);
    
    labelTotale.textContent = "Totale: "+costoTotaleAttuale+"€";

    


    //torno all'inizio della pagina
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: 'smooth'
      });
    //mostro il carrello
    if(visibile == false)
        setTimeout(mostraCarrello(),1000);

    //creo cookie per memorizzare oggetto e qta
    //controllo se il cookie esiste
    var cookie= decodeURIComponent(document.cookie);
    //array con tutti i cookie
    cookie = cookie.split(';');

    var cookieSplittati;
    var cookieProdotti = null;  //cookie/array che contiene le chiavi primarie dei prodotti nel carrello
    //per tenere conto delle quantita di prodotti che si sta acquistando
    var quantita = [];  //cookie/array che contiene la quantitá dei prodotti nel carrello
    for(var i = 0; i < cookie.length; i++)
    {
        //lo scorro e cerco se c'è l'array coi prodotti lo assegno all'array cookie prodotti
        cookieSplittati = cookie[i].split('=');
        if(cookieSplittati[0] == 'codProdotti'){
            cookieProdotti = cookieSplittati[1];    //assegno all'array cookieProdotti il contenuto del cookie
        }
        if(cookieSplittati[0] == ' quantita')
        {
            quantita = cookieSplittati[1];  //assegno all'array quantita il contenuto del cookie
        }
    }
    codProdotto = parseInt(codProdotto);
    if(cookieProdotti == null)
    {
        //non esiste, lo creo
        var prodotti = [];
        prodotti.push(codProdotto);
        var json_prodotti = JSON.stringify(prodotti);
        document.cookie = 'codProdotti ='+json_prodotti;
        //setto quantita
        quantita.push(1);
        var quantita_json = JSON.stringify(quantita);
        document.cookie = 'quantita ='+quantita_json;
    }
    else
    {
        //esiste gia
        var prodotti = JSON.parse(cookieProdotti);
        prodotti.push(codProdotto);
        cookieProdotti = JSON.stringify(prodotti);
        document.cookie = 'codProdotti ='+cookieProdotti;
        //setto quantita
        var arrayQuantita = JSON.parse(quantita);
        arrayQuantita.push(1);
        quantita = JSON.stringify(arrayQuantita);
        document.cookie = 'quantita ='+quantita;
    }
    //riscrivo il numero di prodotti nel carrello
    document.getElementById('numeroProdotti').setAttribute('data-original-title',"Ci sono "+nProdotti+" prodotti");
    document.getElementById('numeroProdotti').value = nProdotti;
}

function resize()
{
    document.getElementById('sezioni').style.position = "sticky";
    //rimuovo le righe sotto
    document.getElementById('spazio').children[0].style.display = "none";
    document.getElementById("divCarrello").style.width = "100%"; //size carrello
}


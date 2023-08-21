var labels = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio','Giugno','Luglio','Agosto','Settembre','Ottobre','Novembre','Dicembre'];
var chart = null;
//istogramma
function disegnaGrafico(){
    //variabili
    let visualizzazioniGrafico = [];
    let venditeGrafico = [];
    let labelsGraficoUno = [];
    let visualizzazioni = [];
    let vendite = [];

    //primo grafico
    var codProdotto = document.getElementById("codProdotto").value;
    var ricVisualizzazioni=new XMLHttpRequest();
    //creo richiesta, richiesta = 1 richiede le visual
    ricVisualizzazioni.open("GET","./leggiFile.php?richiesta="+1+"&codProdotto="+codProdotto,true);
    //invio richiesta
    ricVisualizzazioni.send();
    
    //applico un gestore dell'evento
    ricVisualizzazioni.onreadystatechange=function() {
    //se la connessione è andata a buon fine e la risposta è valida, stampo output
        if (this.readyState==4 && this.status==200) {
            visualizzazioni = JSON.parse(this.responseText);
        }
    }


    //nuova richiesta per le vendite
    var ricVendite=new XMLHttpRequest();
    //richiesta != 1 -> vendite
    ricVendite.open("GET","./leggiFile.php?richiesta="+2+"&codProdotto="+codProdotto,true);
    //invio richiesta
    ricVendite.send();
    ricVendite.onreadystatechange=function() {
    //se la connessione è andata a buon fine e la risposta è valida, stampo output
        if (this.readyState==4 && this.status==200) {
            vendite = JSON.parse(this.responseText);
        }
    }
    
    //grafico,lo ritardo per permettere di prendere i dati dal database
    setTimeout(creaGrafico,1000);
    
    //funzione per disegnare
    function creaGrafico(){
    
        if(chart != null)   //se il grafico esiste, lo cancello
            chart.destroy();
        //recupero i dati necessari
        mesi = document.getElementById('mesi').value;   //ultimi n mesi dal form
        document.getElementById('grafico').height = 50; //size
        document.getElementById('grafico').width = 100; //size
        var today = new Date(); //data di oggi
        var meseCorrente = today.getMonth();    //mese corrente
        var meseCiclo = meseCorrente - mesi;    //mesi da girare (mese corrente - mesi del form)
        while(meseCiclo < meseCorrente) //ciclo i mesi
        {
            labelsGraficoUno.push(labels[meseCiclo]);   //label con i nomi di ogni mese che ci serve
            visualizzazioniGrafico.push(visualizzazioni[meseCiclo]);    //nell'array visualizzazioni inserisco le visual di mese in mese
            venditeGrafico.push(vendite[meseCiclo]);    //faccio lo stesso con le vendite
            meseCiclo++;    //mese successivo
        }

        //ora disegno il primo grafico
        var ctx = document.getElementById('grafico').getContext('2d');
        chart = new Chart(ctx, {
        type: 'bar',    //istogramma
        data: {
            datasets: [{
                    type: 'bar',    //istogramma1, acquisti
                    label: 'Acquisti ultimi '+mesi+' mesi',
                    data: venditeGrafico,   //array con le vendite come dati
                    //order: 2, (per disegnarlo in secondo piano)
                    fill: true, 
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor:'rgba(75, 192, 192,0.4)',
                    tension: 0.1
            },
            {
                    label: 'Visualizzazioni ultimi '+mesi+' mesi',
                    data: visualizzazioniGrafico, //array con dati visual
                    type: 'bar', //istogramma2, vendite
                    //order: 1, (per disegnarlo in primo piano)
                    fill: true,
                    borderColor: 'rgb(255, 0, 0)',
                    backgroundColor:'rgba(255, 0, 0,0.4)',
                    tension: 0.1
            }],
            labels: labelsGraficoUno    //label con i mesi (array)
            },
        });
    }
}


//grafico di gauss
//variabili
var gauss = null;
let asseX = [];
let asseY = [];
var media = 0;
var devStandard = 0;
function disegnaGraficoGauss(){
    let venditeGraficoGauss = [];   //array con vendite
    let labelsGraficoGauss = [];    //array con numero di prodotti
    var codProdotto = document.getElementById("codProdotto").value;
    //nuova richiesta per le vendite
    var ricVendite=new XMLHttpRequest();
    ricVendite.open("GET","./leggiFile.php?richiesta="+2+"&codProdotto="+codProdotto,true);
    //invio richiesta
    ricVendite.send();
    ricVendite.onreadystatechange=function() {
    //se la connessione è andata a buon fine e la risposta è valida, stampo output
        if (this.readyState==4 && this.status==200) {
            vendite = JSON.parse(this.responseText);    //vendite contiene tutte le vendite di un prodotto, mese per mese
            //console.log(vendite);
        }
    }
    
    //grafico,lo ritardo per permettere di prendere i dati dal database
    setTimeout(creaGauss,1000);

    //funzione
    function creaGauss(){
        mesi = document.getElementById('mesiGauss').value;  //prendo gli ultimi n mesi di gauss
        var today = new Date(); //data di oggi
        var meseCorrente = today.getMonth();    //mese attuale
        var meseCiclo = meseCorrente - mesi;    //mese da scorrere
        while(meseCiclo < meseCorrente) //ciclo i mesi richiesti
        {
            labelsGraficoGauss.push(labels[meseCiclo]); //forse inutile
            venditeGraficoGauss.push(vendite[meseCiclo]);//inserisco vendite del mese che si sta ciclando
            meseCiclo++;
        }
        //nell'array vendite sono presenti tutti i valori delle vendite degli ultimi n mesi
        //calcolo la media 
        somma = 0;
        for(var i = 0; i < venditeGraficoGauss.length; i++)
        {
            somma += venditeGraficoGauss[i];
        }
        //console.log(somma+'/'+venditeGraficoGauss.length);
        media = somma/venditeGraficoGauss.length;
        //ora calcolo la deviazione standard
        //devStandard = rad(sommatoria((valoreN - media)^2) / numeroDiValori)
        var sommaDevStandard = 0;
        var temp;
        for(var i = 0; i < venditeGraficoGauss.length; i++)
        {
            temp = Math.pow((venditeGraficoGauss[i]-media),2);  //temp = (valore - media)^2
            sommaDevStandard = sommaDevStandard + temp; //sommo tutti i temp per ottenere la somma
        }
        mediaDevStandard = sommaDevStandard / venditeGraficoGauss.length;   //divido la somma per il numero di elementi
        devStandard = Math.sqrt(mediaDevStandard);  //devStandard che ci serve per disegnare

        //ora che ho tutti i valori, disegno la funzione
        //asse x = 1,2,3,4...
        asseX = [];
        asseY = [];
        //riempio asse x da 0 fino a due volte il valore della media
        //asse y = valori che prende in base alla x
        
        for(var i = 0; i < media * 2; i++)
        {
            //o = devStandard
            //funzione = (1/(o * rad(2*π))) * (e)^(- ((x - media)^2) / (2 * o^2))
            asseX[i] = i;
            asseY[i] = (1/(devStandard * Math.sqrt(2*Math.PI))) * Math.pow(Math.E,(- Math.pow((i-media),2) / (2 * mediaDevStandard)));
        }
        
        //stampo i valori

        console.log('AsseX: '+asseX);
        console.log('AsseY: '+asseY);
        
        console.log('Media: '+media);
        console.log('DevStandard: '+devStandard);

        // se il chart è stato creato lo distruggo per ridisegnarlo
        if(gauss != null)
            gauss.destroy();
        var ctxGauss = document.getElementById('gauss').getContext('2d');
        //disegno il grafico
        gauss = new Chart(ctxGauss, {
            type: 'line',   //grafico a linea
            data: {
                labels: asseX,  //asseX
                datasets: [{
                label: ['Vendite ultimi '+mesi+' mesi'],    //label grafico
                data: asseY,    //asse Y
                fill: true,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor:'rgba(75, 192, 192,0.4)',
                tension: 0.1
                }]},
        });
    }
}

function calcolaProbabilita(){
    //funzione per calcolare areaSottesa
    var inizioInt = parseInt(document.getElementById('prodInziali').value); //inizio intervallo
    var fineInt = parseInt(document.getElementById('prodFinali').value);    //fine intervallo
    var p = document.getElementById('risultato');   //paragrafo del risultato
    if(Number.isInteger(inizioInt) && Number.isInteger(fineInt))    //se sono stati inseriti due valori interi
    {
        if(inizioInt <= fineInt)
        {
            document.getElementById('errore').innerHTML = "";
            //applico la formula per approssimazioni e ottengo il risultato
            var areaSottesaInizio = areaSottesa((inizioInt - media)/devStandard);
            var areaSottesaFine = areaSottesa((fineInt - media)/(devStandard));
            //arrotonda
            areaSottesaFine=Math.round(100000*areaSottesaFine)/100000;
            areaSottesaInizio=Math.round(100000*areaSottesaInizio)/100000;

            //calcolo probabilitá finale
            probabilitaFinale = areaSottesaFine - areaSottesaInizio;
            //console.log(probabilitaFinale);
            probabilitaFinale = probabilitaFinale * 100; //la esprimo in percentuale
            //la stampo
            p.innerHTML = "La probabilit&agrave; di vendere tra i "+inizioInt+" prodotti e i "+fineInt+" prodotti &egrave; del "+probabilitaFinale+ "%";
            let valoriDaColorare = [];
            //setto i valori dell'array a null fino all'inizio dell'intervallo cosí che non vengano colorati
            for(var i = 0; i < inizioInt; i++)
            {
                valoriDaColorare.push(null);
            }
            //ora da inizio intervallo a fine intervallo, inserisco i valori presi dall'array asseY nella pos corrente
            for(var i = inizioInt ;i < fineInt; i++)
            {
                valoriDaColorare.push(asseY[i]);
            }
            //console.log(valoriDaColorare);
            coloraGraficoGauss(valoriDaColorare);
        }
        else
        {
            //se il primo valore é maggiore del secondo, errore
            document.getElementById('errore').innerHTML = "Il primo numero deve essere inferiore del secondo!";
        }
        
    }
    else
    {
        //se non sono stati inseriti due valori interi
        document.getElementById('errore').innerHTML = "Devi inserire due numeri!";
    }
}

function areaSottesa(X){   //HASTINGS.  MAX ERROR = .000001
	var T=1/(1+.2316419*Math.abs(X));
	var D=.3989423*Math.exp(-X*X/2);
	var Prob=D*T*(.3193815+T*(-.3565638+T*(1.781478+T*(-1.821256+T*1.330274))));
	if (X>0) {
		Prob=1-Prob;
	}
	return Prob;
} 
//attraverso una serie di approssimazioni, si arriva al valore desiderato'(area sottesa)

function coloraGraficoGauss(valoriDaColorare){
    gauss.destroy();    //distruggo il grafico e lo ridisegno
    var ctx = document.getElementById('gauss').getContext('2d');
    gauss = new Chart(ctx, {
    type: 'line',
    data: {
        datasets: 
        [{
            type: 'line',
            data: asseY,//asseY
            // grafico disegnato sotto
            order: 2,
            fill: true,
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor:'rgba(75, 192, 192,0.4)',
            tension: 0.1,
            label: ['Vendite ultimi '+mesi+' mesi']  //nome del grafico
        },
        {
            type: 'line',
            data: valoriDaColorare, //asseY
            // grafico disegnato sopra
            order: 1,
            fill: true,
            borderColor: 'rgb(255, 0, 0)',
            backgroundColor:'rgba(255, 0, 0,0.4)',
            tension: 0.1,
            label: 'Area sottesa'   //nome del grafico
        }],
        labels: asseX //asseX
        },
    });
}
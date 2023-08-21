//animazione typewriter dell'ultimo div
testo='Vieni a trovarci per un\'esperienza INDIMENTICABILE';    //testo da scrivere
var i = 0;  //conta i caratteri
var id = "paragrafoAnimato";    //nome paragrafo
var n = 1;  //indica se paragrafo 1 o paragrafo 2
var velocita = 40;  //velocita animazione
function scriviLetteraPerLettera()
{
    if(i == 35)//parola Indimenticabile,cambio paragrafo
    {
        n=2;
    }
    if(i < testo.length)
    {
        //paragrafo1 e paragrafo 2 quando si arriva al 35esimo carattere
        document.getElementById(id+n).innerHTML += testo.charAt(i);
        setTimeout(scriviLetteraPerLettera,velocita);
        i++;
    } 
}

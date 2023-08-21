//animazione per alzare una scritta
var occhio = 'aperto';
function alza(input){
    input.style.borderBottom = '2px solid #ff33cc';
    var label = document.getElementById(input.id+'1');
    label.style.animationDuration = '0.3s';
    label.style.animationName = 'animazione';
    label.style.animationFillMode = 'forwards';    
}
//animazione per abbassare una scritta
function abbassa(input){
    if(input.value == ''){
        input.style.borderBottom = '2px solid black'
        var label = document.getElementById(input.id+'1');
        label.style.animationDuration = '0.3s';
        label.style.animationName = 'animazioneInversa';
        label.style.animationFillMode = 'forwards';
    }
}
//animazione per cambiare icona occhio pw
function cambiaIcona(immagine){
    var input;
    if(immagine.id == 'occhio')
        input = document.getElementById('password');
    else
        input = document.getElementById('ripetiPassword'); 
    if(occhio == 'aperto')
    {
        immagine.src ='../../images/icons/occhioAperto.png';
        input.type = 'password';
        occhio = 'chiuso';
    }
    else
    {
        immagine.src = '../../images/icons/occhioChiuso.png';
        input.type = 'text';
        occhio = 'aperto'
    }
}

//controlla le pw
function checkForm(password,ripetiPassword){ 
    if(password.value != ripetiPassword.value)
    {
        //se sono diverse
        document.getElementById('passwordDiverse').innerHTML = 'Le password non corrispondono!';
        return false;
    }
    return true;
}

//sul load della pagina devo alzare le scritte che rimangono settate
window.onload = function() {controllaCampi()};
function controllaCampi(){
    var inputs, i;
    inputs = document.getElementsByTagName('input');
    for (i = 0; i < inputs.length; i++) {
        if(inputs[i].type != 'checkbox')
        {
            if(inputs[i].value != '')
            {
                alza(inputs[i]);
            }
        }
        
    }
}
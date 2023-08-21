//animazione per girare bottone
function gira(img){
    if(img.style.animationName == 'spin'){
        img.style.animationName = 'reverseSpin';
    }
    else{
        img.style.animationName = 'spin';
    }
}
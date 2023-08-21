function criptaPassword(form) {
    var corretto = checkForm();
    if(!corretto)
    {
        document.getElementById("errore").innerHTML = "<p style='color:red'>Errore, devi compilare tutti i campi obbligatori!</p>";
    }
    else
    {
        document.getElementById("errore").innerHTML = "";
        var password = document.getElementById('password');
        var ripetiPassword = document.getElementById('ripetiPassword');
        if(password.value != ripetiPassword.value)
        {
            document.getElementById("errore").innerHTML = "<p style='color:red'>Errore, le password non coincidono!</p>";
        }
        else
        {
            // Crea un elemento di input che verrà usato come campo di output per la password criptata.
            var hidden = document.createElement("input");
            // Aggiungi un nuovo elemento al tuo form.
            form.appendChild(hidden);
            hidden.name = "passwordCriptata";
            hidden.type = "hidden"
            hidden.value = hex_sha512(password.value);
            var hidden1 = document.createElement("input"); 
            // Aggiungi un nuovo elemento al tuo form.
            form.appendChild(hidden1);
            hidden1.name = "ripetiPasswordCriptata";
            hidden1.type = "hidden"
            hidden1.value = hex_sha512(ripetiPassword.value);
            // La password non deve essere inviata in chiaro.
            password.value = "";
            ripetiPassword.value="";
            // Submit del form.
            form.submit();
        }
    }
    
 }
 
 function checkForm(){
    var nome = document.getElementById("nome").value.trim();
    var cognome = document.getElementById("cognome").value.trim();
    var email = document.getElementById("email").value.trim();
    var citta = document.getElementById("citta").value.trim();
    var CAP = document.getElementById("CAP").value.trim();
    var via = document.getElementById("via").value.trim();
    var civico = document.getElementById("civico").value.trim();
    var password = document.getElementById("password").value.trim();7
    var ripetiPassword = document.getElementById("ripetiPassword").value.trim();
    var trattamentoDati = document.getElementById("trattamentoDati");
    if(nome.length == 0 || cognome.length == 0 || email.length == 0 || citta.length == 0 || CAP.length == 0 || via.length == 0 || civico.length == 0 || password.length == 0 || ripetiPassword.length == 0 || trattamentoDati.checked == false)
        return false;
    else
        return true;
 }
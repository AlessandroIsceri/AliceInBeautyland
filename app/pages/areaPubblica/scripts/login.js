function criptaPassword(form) {
    var password = document.getElementById('password');
    // Crea un elemento di input che verrà usato come campo di output per la password criptata.
    var hidden = document.createElement("input");
    // Aggiungi un nuovo elemento al tuo form.
    form.appendChild(hidden);
    hidden.name = "passwordCriptata";
    hidden.type = "hidden"; //campo nascosto al quale assegno pw criptata in sha512
    hidden.value = hex_sha512(password.value);
    // La password non deve essere inviata in chiaro.
    password.value = "";
    // Submit del form.
    form.submit();
 }
  
<?php
    function stampaAppuntamenti($link,$data,$modalita)
    {
        $query = "SELECT * FROM prenota WHERE data = '$data' ORDER BY oraInizio";  //prendo dati prenotazioni
        $ris = mysqli_query($link,$query);
        if(mysqli_fetch_array($ris) != 0)
        {
            //lo rieseguo perchè se no perde un recordset
            $ris = mysqli_query($link,$query);
            echo '
            <table class="table">
                <thead style="background-color:rgba(255, 51, 204, 0.7);">
                    <tr>
                        <th scope="col">Nome Trattamento</th>
                        <th scope="col">Email</th>
                        <th scope="col">Nome Persona</th>
                        <th scope="col">Ora inizio</th>
                        <th scope="col">Ora fine</th>
                        <th scope="col">Durata</th>';
            if($modalita == 'modifica')
            {
                echo '<th scope="col">Elimina</th>';
            }
            echo'
                    </tr>
                </thead>
            <tbody>';
            while($riga = mysqli_fetch_array($ris))
            {
                echo '<tr><th scope="row">';
                //recupero nome trattamento e durata 
                $queryTrattamento = "SELECT nome,durata FROM trattamento WHERE codTrattamento = ".$riga['codTrattamento'];
                $rigaTrattamento = mysqli_fetch_array(mysqli_query($link,$queryTrattamento));
                echo $rigaTrattamento['nome'];
                echo '</th>';
                echo '<td>'.$riga['email'].'</td>';
                //nome persona
                $queryPersona = "SELECT nome FROM account WHERE email = '".$riga['email']."'";
                $rigaPersona = mysqli_fetch_array(mysqli_query($link,$queryPersona));
                echo '<td>'.$rigaPersona['nome'].'</td>';
                echo '<td>'.$riga['oraInizio'].'</td>';
                echo '<td>'.$riga['oraFine'].'</td>';
                echo '<td>'.$rigaTrattamento['durata'].'</td>';
                if($modalita == 'modifica')
                {
                    echo '<th><form method="POST" action="'.$_SERVER['PHP_SELF'].'">';
                    echo '<button type="button" class="btn btn-dark bottoneIcona" onclick="chiedi(this);"><i class="fa fa-trash" style="color:#ff33cc"></i></button><input type="hidden" name="elimina" value="'.$riga['codPrenotazione'].'">';
                    echo '</form></th>';
                }
                echo '</tr>';
            }
            echo '</tbody>
            </table>';
        }
        else
            echo 'Nessun appuntamento prenotato in data '.$data;
    }
?>
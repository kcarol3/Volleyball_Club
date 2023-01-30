<?php

class Results
{
    //zapisz wynik do bazy danych
    public function saveResultDB($db, $id){
        $attack = floatval($_GET['attack']);
        $block = floatval($_GET['block']);

        if($db->insert("INSERT INTO results VALUES (NULL,'$id','$attack','$block')")){
            return true;
        }
        else {
            return false;
        }
    }

    //zwróc tablicę z pobranymi wynikami
    public function showResults($db, $id){
        $pola = ['attack','block'];
        $dane = $db->selectRows("SELECT attack,block FROM results WHERE userId = '$id'", $pola);
        $cnt = 1;
        $daneHtml = "<div class = 'container'><table class = 'table'>
        <tr>
            <th>Nr.</th>
            <th>Atak</th>
            <th>block</th>
        </tr>";
        foreach ($dane as $item) {
            $daneHtml.="<tr>";
            $daneHtml.="<td>".$cnt.".</td><td>".$item['attack']."</td><td>".$item['block']."</td>";
            $daneHtml.="</tr>";
            $cnt++;
        }
        $daneHtml.="</table></div>";

        return $daneHtml;
    }

    //usuń wyniki użytkownika z bazy danych
    public function deleteResults($db, $id){
        if($db->delete("DELETE FROM results WHERE userId='$id';")){
            return true;
        } else{
            return false;
        }
    }
}
?>
<?php

class DataBase
{
    private $mysqli;
    public function __construct($serwer, $user, $pass, $baza) {
        $this->mysqli = new mysqli($serwer, $user, $pass, $baza);
        if ($this->mysqli->connect_errno){
            printf("Nie udało sie połączenie z serwerem: %s\n", $this->mysqli->connect_error);
            exit();
        }
        if ($this->mysqli->set_charset("utf8")){
        }
    }
    function __destruct() {
        $this->mysqli->close();
    }

    public function insert($sql) {
        if( $this->mysqli->query($sql)) return true; else return false;
    }
    public function update($sql) {
        if( $this->mysqli->query($sql)) return true; else return false;
    }
    public function getMysqli() {
        return $this->mysqli;
    }

    public function delete($sql) {
        if($this->mysqli->query($sql)) {
            return true;
        }
        else {
            return false;
        }
    }

    //funkcja wyszukująca użytkownika w bazie danych, zwraca jego id w razie powodzenia lub -1
    public function selectUser($login, $passwd, $tabela) {
        $id = -1;
        $sql = "SELECT * FROM $tabela WHERE email='$login'";
        if ($result = $this->mysqli->query($sql)) {
            $ile = $result->num_rows;
            if ($ile == 1) {
                $row = $result->fetch_object();
                $hash = $row->passwd;
                if (password_verify($passwd, $hash))
                    $id = $row->id;
            }
        }
        return $id;
    }

    //funkcja pobierająca jeden wiersz z bazy danych
    public function select($sql, $pola) {
        $tresc = array();
        if ($result = $this->mysqli->query($sql)) {
            $ilepol = count($pola); //ile pól
            while ($row = $result->fetch_object()) {
                for ($i = 0; $i < $ilepol; $i++) {
                    $p = $pola[$i];
                     $tresc[$p]=$row->$p;
                }
            }
            $result->close(); /* zwolnij pamięć */
        }
        return $tresc;
    }

    // funkcja wczytujaca wiele wierszy z bazy danych, zwraca tablice tablic asocjacyjnych
    public function selectRows($sql, $pola) {
        $tresc = array();
        $tab = array();
        if ($result = $this->mysqli->query($sql)) {
            $ilepol = count($pola); //ile pól
            $cnt = 0;
            while ($row = $result->fetch_object()) {
                for ($i = 0; $i < $ilepol; $i++) {
                    $p = $pola[$i];
                    $tresc[$p]=$row->$p;
                }
                $tab[$cnt]=$tresc;
                $cnt++;
            }
            $result->close(); /* zwolnij pamięć */
        }
        return $tab;
    }

}
?>
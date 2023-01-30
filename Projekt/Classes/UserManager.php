<?php

class UserManager
{
    //sprawdź poprawność logowania
    function login($db) {
        $args = [
            'login' => FILTER_SANITIZE_ADD_SLASHES,
            'password' => FILTER_SANITIZE_ADD_SLASHES
        ];

        $dane = filter_input_array(INPUT_POST, $args);
        $login = $dane["login"];
        $passwd = $dane["password"];
        $userId = $db->selectUser($login, $passwd, "users");

        if ($userId >= 0) {
            session_start();
            $db->delete("DELETE FROM logged_in_users WHERE userId = $userId");
            $date = (new DateTime())->format("Y-m-d H:i:s");
            $session_id = session_id();
            $sql = "INSERT INTO logged_in_users "
                . "(sessionId, userId, lastUpdate) "
                . "VALUES ('$session_id', '$userId','$date')";
            if($db->insert($sql)){
                return $userId;
            }
            else {
                return -1;
            }
        }
        return -1;
    }

    //wyloguj użytkownika, usuń dane sesji oraz wpis do tabeli logged_in_users
    function logout($db) {
        session_start();
        $session_id = session_id();
        $_SESSION = [];
        if (filter_input( INPUT_COOKIE,session_name() )) {
            setcookie(session_name(), '', time() - 42000, '/'); }
        session_destroy();
        $sql = "DELETE FROM logged_in_users WHERE sessionId = '$session_id';";
        if($db->delete($sql)) {
            return true;
        }
        else {
            return false;
        }
    }

    //sprawdź czy użytkownik jest zalogowany
    function getLoggedInUser($db, $sessionId) {
        if($result = $db->getmysqli()->query("SELECT userId FROM logged_in_users WHERE sessionId = '$sessionId';")){
            if($data = $result->fetch_object()){
                return $data->userId;
            }
        } else {
            return -1;
        }
    }

    //sprawdź dane użytkownika
    function checkUserData(){
        $args = [
            'nick' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^[0-9A-Za-ząęłńśćźżó_-]{2,25}$/']
            ],
            'name' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^[A-ZŁŚŻŹŃÓĆ][a-ząęłńśćźżó]{1,25}$/']
            ],
            'surname' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^[A-ZŁŚŻŹŃÓĆ][a-ząęłńśćźżó]{1,25}$/']
            ],
            'email' => FILTER_VALIDATE_EMAIL
        ];

        $data = filter_input_array(INPUT_POST, $args);
        foreach ($data as $key => $val) {
            if ($val === false) {
                return -1;
            }
        }
        return $data;
    }

    //zaktualizuj dane użytkownika w bazie danych
    public function changeUserData($db, $id){
        $data = $this->checkUserData();
        $chenged = false;
        if($data != -1){
            foreach ($data as $key => $val){
                    if ($db->update("UPDATE users SET $key='$val' WHERE id='$id';")) {
                        $chenged = true;
                    }
            }
        }
        return $chenged;
    }

    //spradź czy hasła są poprawne
    function checkPasswords(){
        $args = [
            'oldPassword' => FILTER_SANITIZE_ADD_SLASHES,
            'newPassword' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^(?=.*[!@#$%^&*.])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/']
            ]
        ];
        $data = filter_input_array(INPUT_POST, $args);

        $errors = "";
        foreach ($data as $key => $val) {
            if ($val === false or $val === NULL) {
                $errors .= $key . " ";
            }
        }
        if($errors===""){
            return $data;
        } else {
            return -1;
        }
    }

    //zmień hasło użytkownika na nowe
    public function changePassword($db, $id){

        $data = $this->checkPasswords();
        if($data != -1){
            $passwd = $data["oldPassword"];
            $newPasswd = $data['newPassword'];
            $oldPasswd = $db->select("SELECT passwd FROM users WHERE id='$id';", ['passwd']);

            if (password_verify($passwd, $oldPasswd['passwd'])) {
                $newPasswd = password_hash($newPasswd, PASSWORD_DEFAULT);
                if ($db->update("UPDATE users SET passwd = '$newPasswd' WHERE id='$id';")) {
                    return true;
                }
            }
        }
        return false;
    }

    //usuń konto użytkownika, pod warunkiem że podał poprawne hasło oraz zaznaczył checkboxa
    public function deleteAccount($db,$id){
        $passwd = filter_input(INPUT_POST,"password", FILTER_SANITIZE_ADD_SLASHES);
        $currentPasswd = $db->select("SELECT passwd FROM users WHERE id='$id';", ['passwd']);

        if (password_verify($passwd, $currentPasswd['passwd']) and filter_input(INPUT_POST,"agree")=="yes") {
            $db->delete("DELETE FROM results WHERE userId='$id';");
            if($db->delete("DELETE FROM users WHERE id='$id';")){
                return true;
            }
        }
        else return false;
    }


}
?>
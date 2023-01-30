<?php

class User
{
    const STATUS_USER = 1;
    const STATUS_ADMIN = 2;
    private $nick;
    private $name;
    private $surname;
    private $email;
    private $position;
    private $status;
    private $password;
    private $date;


    public function __construct($newNick, $newName, $newSurname, $newPosition, $newEmail, $newPassword )
    {
        $this->status=User::STATUS_USER;
        $this->nick=$newNick;
        $this->name=$newName;
        $this->surname=$newSurname;
        $this->position = $newPosition;
        $this->email=$newEmail;
        $this->password = password_hash($newPassword, PASSWORD_DEFAULT );
        $this->date = (new DateTime())->format("Y-m-d H:i:s");

    }

    public function setStatusAdmin(){
        $this->status=User::STATUS_ADMIN;
    }

    //zapisz użytkownika do bazy danych
    public function save_to_db($db){
        $sql = "INSERT INTO users VALUES (NULL,'$this->nick','$this->name','$this->surname','$this->position','$this->email','$this->password',$this->status,'$this->date');";
        if($db->insert($sql)){
            return true;
        } else{
            return false;
        }
    }

}
?>
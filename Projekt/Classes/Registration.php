<?php
include_once "DataBase.php";
include_once "User.php";

class Registration
{
    protected $user;

    //sprawdź poprawność danych, w razie powodzenia zwróc obiekt klasy user
    function checkUser(){
        $args = [
            'nick' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^[0-9A-Za-ząęłńśćźżó_-]{2,25}$/']
            ],
            'name' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^[A-ZŁ][a-ząęłńśćźżó]{1,25}$/']
            ],
            'surname' => ['filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^[A-ZŁ][a-ząęłńśćźżó-]{1,40}$/']
            ],
            'position' => ['filter' => FILTER_SANITIZE_SPECIAL_CHARS],
            'mail' => FILTER_VALIDATE_EMAIL,
            'password' => ['filter' => FILTER_VALIDATE_REGEXP,
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

        if ($errors === "") {
            $this->user=new User($data['nick'], $data['name'], $data['surname'], $data['position'], $data['mail'],$data['password']);
        } else {
            echo "<p>Błędne dane:$errors</p>";
            $this->user = NULL;
        }
        return $this->user;
    }


}
?>
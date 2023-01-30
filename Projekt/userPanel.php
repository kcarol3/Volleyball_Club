<?php
include_once "Classes/Page.php";
include_once "Classes/UserManager.php";
include_once "Classes/DataBase.php";

$db = new DataBase("localhost", "root", "", "clients");
$um = new UserManager();
session_start();
$session_id = session_id();
$id = $um->getLoggedInUser($db, $session_id);

if ($id > 0) {

    $userPage = new Page();
    $userPage->set_styles("css/styles.css");
    $userPage->set_Title('O naszym klubie');
    $userPage->set_nav_items(["Home" => "index.php", "O nas" => "about.php", "Sprawdź się" => "blockAndAttack.php", "Panel" => "userPanel.php", "Wyloguj" => "processLogin.php?akcja=wyloguj"]);

    $pola = ['id', 'nick', 'name', 'surname', 'position', 'email'];
    $dane = $db->select("SELECT * FROM users WHERE id = '$id'", $pola);

    $header = '
     <header class="bg-dark py-1  bg-primary rounded-3 shadow">
        <div class="rounded-3 px-4 py-4">
            <div class="text-center">          
                    <h1 class="fw-bolder text-white">Panel użytkownika</h1>
                    <p class="lead fw-bold text-white-50 mb-4">
                    Tutaj możesz sprawdzić zapisane dane oraz je edytować.
                    </p>
            </div>           
        </div>       
    </header>
     ';

    $content = '
<div class = "container ">
        <div class="modal fade" id="changeData" tabindex="-1" role="dialog" aria-labelledby="changeData" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edytuj dane</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>                     
                    </div>
                    <div class="modal-body">
                        <form method="post" action="userPanel.php">
                         <!-- nick -->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="nick" type="text" name = "nick" value="' . $dane['nick'] . '"/>
                            <label for="nick">Twój nick...</label>
                            <div id="nick_error">
                            </div>
                        </div>
                        <!-- name -->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="name" type="text" name = "name" value="' . $dane['name'] . '"/>
                            <label for="name">Imię...</label>
                            <div id="name_error"></div>
                        </div>
                        <!-- surname -->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="surname" type="text" name = "surname" value="' . $dane['surname'] . '"/>
                            <label for="surname">Nazwisko...</label>
                            <div id="surname_error"></div>
                        </div>
                        
                        <!-- email -->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="mail" name = "email" value="' . $dane['email'] . '"/>
                            <label for="mail">E-mail...</label>
                            <div id="mail_error"></div>
                        </div>
                        <div class="m-auto text-center">
                            <input class = "btn bg-succ text-white border-dark" name="changeData" type="submit" value="Zapisz Dane"/>
                        </div>   
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary border-dark" data-bs-dismiss="modal">Zamknij</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePassword" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Zmień hasło</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>                     
                    </div>
                    <div class="modal-body">
                        <form method="post" action="userPanel.php">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="oldPassword" name = "oldPassword" type="password"/>
                                <label for="oldPassword">Twoje obecne hasło...</label>                         
                        </div>
                        <div class="form-floating mb-3">
                            <input class="form-control" id="newPassword" name = "newPassword" type="password"/>
                                <label for="newPassword">Nowe hasło...</label>                           
                        </div> 
                        <div class="m-auto text-center">
                            <input class = "btn bg-succ text-white border-dark" type="submit" name="changePassword" value="Zapisz"/>
                        </div>   
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary border-dark" data-bs-dismiss="modal">Zamknij</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="deleteUser" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Usuń konto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>                     
                    </div>
                    <div class="modal-body">
                        <form method="post" action="userPanel.php">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="password" name = "password" type="password"/>
                                <label for="password">Twoje obecne hasło...</label>
                        </div>
                        <div class="form-check py-4">
                            <input class="form-check-input" type="checkbox" value="yes" id="flexCheckChecked" name = "agree">
                                <label class="form-check-label" for="flexCheckChecked">
                                 Czy napewno chcesz usunąć konto?
                            </label>
                        </div>
                        <div class="m-auto text-center">
                            <input class = "btn bg-succ text-white border-dark" name="deleteUser" type="submit" value="Usuń"/>
                        </div>   
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary border-dark" data-bs-dismiss="modal">Zamknij</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row py-4 align-items-start gx-4">
            <div class="col-lg mb-5 justify-content-lg-center">
                <img src="images/player.png" class="w-75" alt = "...">
            </div>
            <div class="col-lg mb-5">
                <div class="card shadow-lg border-dark ">
                    <div class="card-header bg-dark text-center text-white">
                        <h3>Dane użytkownika</h3>
                    </div>
                    <ul class="list-group list-group-flush">
                    <li class="list-group-item">Nick: ' . $dane['nick'] . '</li>
                     <li class="list-group-item">Imię: ' . $dane['name'] . '</li>
                    <li class="list-group-item">Nazwisko: ' . $dane['surname'] . '</li>
                    <li class="list-group-item">Pozycja: ' . $dane['position'] . '</li>
                    <li class="list-group-item">Email: ' . $dane['email'] . '</li>
                    </ul>
                </div>
                <div class="row py-4">
                    <div class="col mb-5 text-center">
                        <button type="button" class="btn btn-secondary btn-lg border-dark btn-shadow" data-bs-toggle="modal" data-bs-target="#changeData">Edytuj dane</button>
                    </div>
                    <div class="col mb-5 text-center">
                        <button type="button" class="btn btn-secondary btn-lg border-dark btn-shadow" data-bs-toggle="modal" data-bs-target="#changePassword">Zmień hasło</button>
                    </div>
                    <div class="col mb-5 text-center">
                        <button type="button" class="btn btn-secondary btn-lg border-dark btn-shadow" data-bs-toggle="modal" data-bs-target="#deleteUser">Usuń konto</button>
                    </div>
                </div>
            </div>            
        </div>   
    </div>
   </main>
';
    $userPage->set_header($header);
    $userPage->set_content($content);

    if (filter_input(INPUT_POST, "changePassword")) {
        if ($um->changePassword($db, $id)) {
            $userPage->set_message('success', 'Udało się zmienić hasło!');
        } else {
            $userPage->set_message('danger', 'Nie udało się zmienić hasła!');
        }
        $userPage->display_All_with_message();
    } else if (filter_input(INPUT_POST, "deleteUser")) {
        if ($um->deleteAccount($db, $id)) {
            header("location:processLogin.php?akcja=wyloguj");
        } else {
            $userPage->set_message('danger', 'Konto nie zostało usunięte!');
            $userPage->display_All_with_message();
        }

    } else if (filter_input(INPUT_POST, 'changeData')) {
        if ($um->changeUserData($db, $id)) {
            header("location:userPanel.php");
        } else {
            $userPage->set_message('danger', 'Nie udało się zmienić danych! Zły format danych lub istnieje już taki użytkownik.');
        }
        $userPage->display_All_with_message();
    } else {
        $userPage->display_All();
    }

} else {
    header("location:processLogin.php");
}

?>

<?php
include_once "Classes/Page.php";
include_once "Classes/Registration.php";
include_once "Classes/User.php";
include_once "Classes/UserManager.php";

$db = new DataBase("localhost", "root", "", "clients");
$um = new UserManager();
session_start();
$session_id = session_id();
$id = $um->getLoggedInUser($db, $session_id);
if ($id > 0) {
    header("location:userPanel.php");
} else {
    $regisPage = new Page();

    $regisPage->set_styles("css/styles.css");
    $regisPage->set_Title('Rejestracja');
    $regisPage->set_nav_items(["Home" => "index.php", "Rejestracja" => "registrationForm.php", "Logowanie" => "processLogin.php"]);

    $header = '
    <header class="bg-dark py-4  bg-primary rounded-3 shadow">
        <div class="rounded-3 px-4">
            <div class="text-center">
                <h1 class="fw-bolder text-white">Dołącz do nas</h1>
                <p class="lead fw-bold text-white-50 mb-4 fs-4">
                Wypełniij formularz rejestracji aby stać się częścią naszej społeczności.
            </div>
        </div>
    </header>
    ';

    $content = '
    <!-- Features section-->
    <section class="py-5">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="bg-dark rounded-3 py-3 px-3 px-md-3 mb-3 fw-normal  fs-5 border-3 text-center shadow">
                    <h3 class=" fw-normal text-white mb-2 ">Uzupełnij formularz rejestracyjny</h3>
                    </div>
                    <br>
                    <form method="post" action="registrationForm.php"  >
                        <div id="formularz" >
                            <!-- The Modal -->
                            <div class="modal fade" id="modalForm">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Czy chcesz wysłać następujące dane:</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="modal-body" id = "modDatForm">
                                        </div>
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary btn-lg  gx-5" type="submit" name="submit" value = "save">Wyślij</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- nick -->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="nick" type="text" name = "nick"/>
                            <label for="nick">Twój nick...</label>
                            <div id="nick_error">
                            </div>
                        </div>
                        <!-- name -->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="name" type="text" name = "name"/>
                            <label for="name">Imię...</label>
                            <div id="name_error"></div>
                        </div>
                        <!-- surname -->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="surname" type="text" name = "surname"/>
                            <label for="surname">Nazwisko...</label>
                            <div id="surname_error"></div>
                        </div>
                        
                        <!-- email -->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="mail" name = "mail"/>
                            <label for="mail">E-mail...</label>
                            <div id="mail_error"></div>
                        </div>
                        
                        <!-- password -->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="password" name = "password" type="password"/>
                            <label for="password">Twoje hasło...</label>
                            <div id="password_error"></div>
                        </div>
                        
                        <div class="bg-light rounded-3 py-4 px-3 px-md-3 mb-3 fw-normal text-dark fs-5 border">
                            Preferowana pozycja:
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="setter" name = "position" id="rozgrywajacy" checked="checked">
                                <label class="form-check-label" for="rozgrywajacy">
                                    Rozgrywający
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="middleBlocker" name = "position" id="srodkowy">
                                <label class="form-check-label" for="srodkowy">
                                    Środkowy
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name = "position" value="oppositeHitter" id="atakujacy">
                                <label class="form-check-label" for="atakujacy">
                                    Atakujący
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="libero" name = "position" id="libero">
                                <label class="form-check-label" for="libero">
                                    Libero
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="outsideHitter" name = "position" id="przyjmujacy">
                                <label class="form-check-label" for="przyjmujacy">
                                    Przyjmujący
                                </label>
                            </div>
                            <div id="poz_error"></div>
                        </div>
                        <div class="container">
                        <div class = "d-block m-auto text-center">
                            <button class = "btn btn-secondary btn-lg gx-5 mt-2 border-dark btn-shadow" type="reset" value=" Wyczyść " >Wyczyść</button>
                        </div>
                        </div>
                    </form>
                        <!-- przycisk wyslij -->
                        <div class="container text-center">
                                <div class = "m-auto py-4">
                                    <button class="btn bg-succ text-white btn-lg border-dark btn-shadow" onclick="sprawdz()" >Wyślij</button>
                                </div>
                            </div>
                        </div>
                        </div>
                </div>
    </section>
</main>
    ';

    $regisPage->set_header($header);
    $regisPage->set_content($content);

    $rf = new Registration();
    $db = new DataBase("localhost", "root", "", "clients");

    if (isset($_POST['submit'])) {
        $user = $rf->checkUser(); //sprawdza poprawność danych
        if ($user === NULL) {

        } else {
            if ($user->save_to_db($db)) {
                header('location:registrationSuccess.php');
            } else {
                $regisPage->set_message("danger", "Istnieje już użytkownik o takich danych!");
                $regisPage->display_All_with_message();
            }
        }
    } else {
        $regisPage->display_All();
    }
}
?>
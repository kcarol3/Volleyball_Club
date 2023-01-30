<?php
include_once "Classes/Page.php";
include_once "Classes/UserManager.php";
include_once "Classes/DataBase.php";

$loginPage = new Page();
$loginPage->set_styles("css/styles.css");
$loginPage->set_Title('Logowanie');
$loginPage->set_nav_items(["Home" => "index.php", "Rejestracja" => "registrationForm.php", "Logowanie" => "processLogin.php"]);

$header = '
<header class="bg-dark py-3  bg-primary rounded-3 shadow">
        <div class="rounded-3 px-4 ">
            <div class="text-center">
                <h1 class="fw-bolder text-white">Zaloguj się</h1>
                <p class="lead fw-bold text-white-50 mb-0 fs-4">Zaloguj się, aby poznać pełne możliwości strony.</p>
            </div>
        </div>
</header>
';
$content = '
    <section class="py-5">
        <div class="container px-5">
            <div class="row gx-5 justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <form action="processLogin.php" method="post">
                        <!-- email -->
                        <div class="form-floating mb-3">
                            <input class="form-control" name="login" id="login" type="email"/>
                                <label for="login">E-mail...</label>
                        </div>
                        <!-- password -->
                        <div class="form-floating mb-3">
                            <input class="form-control" id="password" name = "password" type="password"/>
                                <label for="password">Twoje hasło...</label>
                            <div id="password_error"></div>
                        </div>                         
                        <div class = "text-center">
                            <button class = "btn btn-secondary btn-lg btn-block btn-shadow border-dark" type="reset" value=" Wyczyść " >Wyczyść</button>
                        </div>                  
                        <!-- przycisk wyslij -->
                        <div class="text-center">
                            <div class = "py-3">
                                    <button class="btn bg-succ text-white btn-lg btn-block btn-shadow border-dark" type="submit" name="logged" value="submit">Zaloguj</button>
                            </div>    
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
';

$loginPage->set_header($header);
$loginPage->set_content($content);

$db = new DataBase("localhost", "root", "", "clients");
$um = new UserManager();

if (filter_input(INPUT_GET, "akcja") == "wyloguj") {
    $um->logout($db);
}

if (filter_input(INPUT_POST, "logged")) {
    $userId = $um->login($db);
    if ($userId > 0) {
        header("location:userPanel.php");
    } else {
        $loginPage->set_message("danger", "Błędne dane! Nie znaleziono takiego użytkownika.");
        $loginPage->display_All_with_message();
    }
} else {
    $loginPage->display_All();
}

?>





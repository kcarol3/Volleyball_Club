<?php
include_once "Classes/Page.php";
include_once "Classes/UserManager.php";
include_once "Classes/DataBase.php";
include_once "Classes/Results.php";

$db = new DataBase("localhost", "root", "", "clients");
$um = new UserManager();
$rs = new Results();

session_start();
$session_id = session_id();
$id = $um->getLoggedInUser($db, $session_id);

if ($id > 0) {
    $calcPage = new Page();

    $calcPage->set_styles("css/styles.css");
    $calcPage->set_Title('Blok i Atak');
    $calcPage->set_nav_items(["Home" => "index.php", "O nas" => "about.php", "Sprawdź się" => "blockAndAttack.php", "Panel" => "userPanel.php", "Wyloguj" => "processLogin.php?akcja=wyloguj"]);
    $header = '
    <header class="bg-dark py-5  bg-primary rounded-3">
        <div class="container px-5 ">
            <div class="row gx-5 align-items-center justify-content-center">
                <div class="col-lg-8 col-xl-7 col-xxl-6">
                    <div class="my-5 text-center text-xl-start">
                        <h1 class="display-5 fw-bolder text-white mb-2">Oblicz swój zasięg w bloku i ataku</h1>
                        <p class="lead fw-bold text-white-50 mb-4 fs-4">Dzięki temu prostemu kalkulatorowi będziesz mógł policzyć przybliżone parametry dwóch bardzo ważnych parametrów:
                            zasięg w ataku mówi na jakiej wysokości będziesz mógł zaatakować piłkę,
                            zasięg w bloku z kolei odpowiada za wysokość blokowania piłki atakowanej przez przeciwnika.
                            Dane te mogą się różnić od rzeczywistych z uwagi np. na dyspozycję dnia czy styl nabiegu.
                            </p>
                    </div>
                </div>
                <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center rounded-3">
                    <img  class="d-block bg-mybg w-100 rounded-3" src="images/LOGO.png" alt="...">
                </div>
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
                    <!-- wzrost -->
                    <div class="form-floating mb-3">
                        <input  class="form-control" id="wzrost" required/>
                        <label for="wzrost">Wpisz swój wzrost (cm)</label>
                    </div>
                    <!-- d. ręki -->
                    <div class="form-floating mb-3">
                        <input  class="form-control" id="dReki" required/>
                        <label for="dReki">Wpisz długość ręki (cm)</label>
                    </div>
                    <!-- wyskok --><!-- type="number" min = "30" max = "120" -->
                    <div class="form-floating mb-3">
                        <input  class="form-control" id="wyskok" required/>
                        <label for="wyskok">Wpisz swój wyskok dosiężny (cm)</label>
                    </div>
                    <!-- przyciski -->
                    <div class="container ">
                        <div class="row-lg-2 align-items-start">
                            <div class = "col m-auto py-4 text-center">
                                <button class="btn bg-succ text-white fs-5 btn-sm btn-shadow border-dark w-50" type = "button" onclick="calculate()">Oblicz</button>
                            </div>                
                            <div class = "col m-auto text-center">
                                <button class="btn btn-secondary btn-sm btn-shadow border-dark w-50" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample" >
                                    Pokaż zapisane
                                </button>
                                <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
                                    <div class="offcanvas-header">
                                        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Twoje wyniki:</h5>
                                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        <div id = "dane"></div>
                                        ' . $rs->showResults($db, $id) . '
                                        <div class="dropdown mt-3">
                                        <form action="blockAndAttack.php" method="post">
                                            <button class="btn bg-secondary text-white btn-sm btn-shadow border-dark" name="delete" value="yes" type="submit">Usuń zapisane dane</button>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="atak" name="attack" value ="" disabled>
                        <label for="atak">Twój zasięg w ataku:</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="blok" name = "block" value ="" disabled>
                        <label for="blok">Twój zasięg w bloku:</label>
                    </div>
                    <div id = "zapis"></div>   
                </div>
            </div>
        </div>
    </section>
</main>';

    $calcPage->set_header($header);
    $calcPage->set_content($content);

    if (filter_input(INPUT_GET, "save") == "yes") {
        if ($rs->saveResultDB($db, $id)) {
            header('location:blockAndAttack.php?save=no');
        } else {
            $calcPage->set_message("danger", "Nie udało się zapisać danych!");
            $calcPage->display_All_with_message();
        }

    } else if (filter_input(INPUT_POST, "delete") == "yes") {
        if ($rs->deleteResults($db, $id)) {
            header('refresh: 1;');
        } else {
            $calcPage->set_message("danger", "Nie udało się usunąć wyników!");
            $calcPage->display_All_with_message();
        }
    } else {
        $calcPage->display_All();
    }
} else {
    header("location:processLogin.php");
}
?>
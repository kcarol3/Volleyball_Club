<?php
include_once "Classes/Page.php";
include_once "Classes/UserManager.php";
include_once "Classes/DataBase.php";

$db = new DataBase("localhost", "root", "", "clients");
$um = new UserManager();
session_start();
$session_id = session_id();
$id = $um->getLoggedInUser($db,$session_id);

if ($id>0){
    $aboutPage = new Page();
    $aboutPage->set_styles("css/styles.css");
    $aboutPage->set_Title('O naszym klubie');
    $aboutPage->set_nav_items(["Home"=>"index.php","O nas"=>"about.php","Sprawdź się"=>"blockAndAttack.php", "Panel"=>"userPanel.php", "Wyloguj"=>"processLogin.php?akcja=wyloguj"]);

    $header = '
    <header class="py-5 bg-dark shadow">
        <div class="container px-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xxl-6">
                    <div class="text-center my-5">
                        <h1 class="display-5 fw-bolder text-white mb-2">Nasza historia</h1>
                        <p class="lead fw-bold text-white-50 mb-4 fs-4">Zaczynaliśmy 7 lat temu, jako grupa chłopaków, która
                            zabijąc letnie weekendy zaczęła trenować siatkówkę. Z czasem zrodził się pomysł aby założyć
                            własny uczelniany klub. Zaczęlismy startować w turniejach już jako Volleyball Club. Liczne
                            sukcesy spowodowały, że musimy rozwinąć nasz klub, dlatego poszukujemy nowych
                            zawodników.</p>
                        <a class="btn btn-secondary btn-lg btn-shadow border-dark" href="#scroll-target">Zobacz więcej</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    ';

    $content = '
    <!-- About section one-->
    <section class="py-5 shadow" id="scroll-target">
        <div class="container px-5 my-5">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-6"><img class="img-fluid rounded mb-5 mb-lg-0" src="images/beach.jpg" alt="..."/>
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bolder">Początki</h2>
                    <p class="lead fw-normal text-muted mb-0">Zaczeliśmy od siatkówki plażowej, jednak ta forma sportu
                        nie do końca nam pasowała. Do naszej drużyny zaczęli zgłaszać się kolejni chętni do gry, więc
                        logicznym posunięciem było przejście na grę halową.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- About section two-->
    <section class="py-5 bg-light shadow">
        <div class="container px-5 my-5">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-6 order-first order-lg-last"><img class="img-fluid rounded mb-5 mb-lg-0"
                                                                     src="images/cup.png" alt="..."/></div>
                <div class="col-lg-6">
                    <h2 class="fw-bolder">Pierwsze sukcesy</h2>
                    <p class="lead fw-normal text-muted mb-0">Po roku zaczęliśmy odnosić pierwsze sukcesy na turniejach.
                        Początkowo były to drobne turnieje, jednak z każdym zwycięstwem nasza rozpoznawalność rosła i
                        pojawiły się zaproszenia na coraz ważniejsze imprezy.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- About section three-->
    <section class="py-5 ">
        <div class="container px-5 my-5">
            <div class="row gx-5 align-items-center">
                <div class="col-lg-6"><img class="img-fluid rounded mb-5 mb-lg-0" src="images/atak.jpg" alt="..."/>
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bolder">Obecne miejsce</h2>
                    <p class="lead fw-normal text-muted mb-0"> Pomimo ugruntowanej pozycji, chcemy się dalej rozwijać,
                        szukać nowych wyzwań. Celem są turnieje miedzynarodowe i dlatego szukamy nowych zawodników,
                        którzy pomogą nam w drodze do osiągnięcia celu.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Team members section-->
    <section class="py-5 ">
        <div class="container px-5 my-5 bg-light rounded-3 p-4">
            <div class="text-center">
                <h2 class="fw-bolder">Nasza Szóstka</h2>
                <p class="lead fw-normal text-muted mb-5">Meczowy skład</p>
            </div>
                <div class="row row-cols-1  row-cols-auto justify-content-center">
                    <img class="img-fluid rounded w-75" src="images/siatka.png" alt="...">
                </div>
                <div id="zawodnik" >
                    <!-- The Modal -->
                    <div class="modal fade" id="myModal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <h4 class="modal-title">Dane zawodnika:</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <!-- Modal body -->
                                <div class="modal-body" id = "modalData">
                                </div>
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gx-5 row-cols-1 row-cols-sm-2 row-cols-xl-4 justify-content-center">
                    <div class="col mb-5 mb-5 mb-xl-0">
                        <div class="text-center">
                            <img class="img-fluid rounded-circle mb-4 px-4"
                                 src="images/siatkarz2.jpeg" alt="..."/>
                            <h5 class="fw-bolder">Ricardo Junior</h5>
                            <div class="fst-italic text-muted">Rozgrywający</div>
                            <div class="mt-1">
                                <button class="btn btn-secondary btn-sm btn-shadow border-dark" id="0"  onclick="readPlayers(0)">Podgląd</button>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5 mb-5 mb-xl-0">
                        <div class="text-center">
                            <img class="img-fluid rounded-circle mb-4 px-4"
                                 src="images/siatkarz1.jpeg" alt="..."/>
                            <h5 class="fw-bolder">Jakub Zawisza</h5>
                            <div class="fst-italic text-muted">1 Środkowy</div>
                            <div class="mt-1">
                                <button class="btn btn-secondary btn-sm btn-shadow border-dark" id="1"  onclick="readPlayers(1)">Podgląd</button>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5 mb-5 mb-sm-0">
                        <div class="text-center">
                            <img class="img-fluid rounded-circle mb-4 px-4"
                                 src="images/siatkarz3.jpg" alt="..."/>
                            <h5 class="fw-bolder">Conrad Brokula</h5>
                            <div class="fst-italic text-muted">1 Przyjmujący</div>
                            <div class="mt-1">
                                <button class="btn btn-secondary btn-sm btn-shadow border-dark" id="2"  onclick="readPlayers(2)">Podgląd</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row gx-5 mt-5 row-cols-1 row-cols-sm-2 row-cols-xl-4 justify-content-center">
                    <div class="col mb-5 mb-5 mb-xl-0">
                        <div class="text-center">
                            <img class="img-fluid rounded-circle mb-4 px-4"
                                 src="images/siatkarz4.jpg" alt="..."/>
                            <h5 class="fw-bolder">Sebastian Problem</h5>
                            <div class="fst-italic text-muted">2 Przyjmujący</div>
                            <div class="mt-1">
                                <button class="btn btn-secondary btn-sm btn-shadow border-dark" id="3"  onclick="readPlayers(3)">Podgląd</button>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5 mb-5 mb-xl-0">
                        <div class="text-center">
                            <img class="img-fluid rounded-circle mb-4 px-4"
                                 src="images/siatkarz5.jpg" alt="..."/>
                            <h5 class="fw-bolder">Michał Kurek</h5>
                            <div class="fst-italic text-muted">2 Środkowy</div>
                            <div class="mt-1">
                                <button class="btn btn-secondary btn-sm btn-shadow border-dark" id="4"  onclick="readPlayers(4)">Podgląd</button>
                            </div>
                        </div>
                    </div>
                    <div class="col mb-5 mb-5 mb-sm-0">
                        <div class="text-center">
                            <img class="img-fluid rounded-circle mb-4 px-4"
                                 src="images/siatkarz6.jpg" alt="..."/>
                            <h5 class="fw-bolder">Janusz Miras</h5>
                            <div class="fst-italic text-muted">Atakujacy</div>
                            <div class="mt-1">
                                <button class="btn btn-secondary btn-sm btn-shadow border-dark" id="5"  onclick="readPlayers(5)">Podgląd</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</main>';

    $aboutPage->set_header($header);
    $aboutPage->set_content($content);
    $aboutPage->display_All();
} else {
    header("location:processLogin.php");
}

?>
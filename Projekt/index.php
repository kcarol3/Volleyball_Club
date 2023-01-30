<?php
include_once "Classes/Page.php";
include_once "Classes/UserManager.php";
include_once "Classes/DataBase.php";

$aboutPage = new Page();
$db = new DataBase("localhost", "root", "", "clients");
$um = new UserManager();

$aboutPage->set_styles("css/styles.css");
$aboutPage->set_Title('Volleyball Club');

session_start();
$session_id = session_id();
$id = $um->getLoggedInUser($db,$session_id);

if ($id>0){
    $aboutPage->set_nav_items(["Home"=>"index.php","O nas"=>"about.php","Sprawdź się"=>"blockAndAttack.php", "Panel"=>"userPanel.php", "Wyloguj"=>"processLogin.php?akcja=wyloguj"]);
}else{
    $aboutPage->set_nav_items(["Home"=>"index.php", "Rejestracja"=>"registrationForm.php", "Logowanie"=>"processLogin.php"]);
}

$header = '
<header class="bg-dark py-5   rounded-3 shadow">
                <div class="container px-5 ">
                    <div class="row gx-5 align-items-center justify-content-center">
                        <div class="col-lg-8 col-xl-7 col-xxl-6">
                            <div class="my-5 text-center text-xl-start">
                                <h1 class="display-5 fw-bolder text-white mb-2">Dołącz do naszego klubu </h1>
                                <p class="lead fw-bold text-white-50 mb-4 fs-4">Jesteśmy młodym, dynamicznym zespołem, pnącym się po kolejnych szczeblach lig. Ta strona ma na celu poszukiwanie młodych talentów, którzy pod naszym okiem rozwiną się i będą w przyszłości stanowili o sile naszej drużyny.</p>
                                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xl-start">
                                    <a class="btn btn-secondary btn-lg px-4 me-sm-3 border-dark btn-shadow" href="#features">Zacznij już teraz</a>
                                </div>
                            </div>
                        </div>
                       <div class="col-xl-5 col-xxl-6 d-none d-xl-block text-center rounded-3">
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="images/vol1.jpg" class="d-block w-100 rounded-3" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="images/vol2.jpg" class="d-block w-100 rounded-3" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="images/vol3.jpg" class="d-block w-100 rounded-3" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                           </div>
                    </div>
                </div>
            </header>
';

$newContent = '
<!-- Features section-->
            <section class="py-5">
                <div class="container px-5 my-5 ">
                    <!-- cytat -->
                    <figure class="text-center ">
                        <img src="images/LOGO.png"  class="d-block w-75 mb-5 m-auto" alt="...">
                    <blockquote class="blockquote fst-italic fs-2">
                        <p>
                            „Właściwie jedyny zespół, którego się jeszcze obawiam, to Polska. Zespół ten gra siatkówkę nie z tego świata.“
                        </p>
                    </blockquote>
                    <figcaption class="blockquote-footer fs-4">
                        Bernardo Rezende<cite title="Source Title"></cite>
                    </figcaption>
                </figure>
                    <br>
                    <br>
                    <span id = "features"></span>
                    <div class="row gx-5 justify-content-center mt-5">
                        <div class="col-lg-8 col-xl-6">
                            <div class="text-center">
                                <h2 class="fw-bolder">Poznaj Nas</h2>
                                <p class="lead fw-normal text-muted mb-5">Wybierz funkcjonalność, która cię interesuje.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row gx-5">
                        <div class="col-lg-4 mb-5" >
                            <div class="card h-100  border-0 card_features">
                                <img class="card-img-top" src="images/team.jpg" alt="..." />
                                <div class="card-body p-4">
                                    <a class="text-decoration-none link-dark stretched-link" href="about.php"><h5 class="card-title mb-3">Nasz team</h5></a>
                                    <p class="card-text mb-0">Znajdziesz tu historię zespołu i  naszą drużynę.</p>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-5">
                            <div class="card h-100  border-0 card_features">
                                <img class="card-img-top" src="images/atak.jpg" alt="..." />
                                <div class="card-body p-4">
                                    <a class="text-decoration-none link-dark stretched-link" href="blockAndAttack.php"><h5 class="card-title mb-3">Sprawdź swoje możliwośći</h5></a>
                                    <p class="card-text mb-0">Oblicz swój zasięg w bloku i ataku.</p>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-5">
                            <div class="card h-100 border-0 rounded card_features">
                                <img class="card-img-top" src="images/player.jpg" alt="..." />
                                <div class="card-body p-4">
                                    <a class="text-decoration-none link-dark stretched-link" href="registrationForm.php"><h5 class="card-title mb-3">Dołącz do nas</h5></a>
                                    <p class="card-text mb-0">Zarejestruj się aby odkryć pełne możliwości strony.</p>
                                </div>
                                <div class="card-footer p-4 pt-0 bg-transparent border-top-0">
                                    <div class="d-flex align-items-end justify-content-between">
                                        <div class="d-flex align-items-center">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>         
                </div>
            </section>
        </main>
';

$aboutPage->set_header($header);
$aboutPage->set_content($newContent);
$aboutPage->display_All();

?>
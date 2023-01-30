<?php
include_once "Classes/Page.php";
$regisPage = new Page();

$regisPage->set_styles("css/styles.css");
$regisPage->set_Title('Zarejetrowano');
$regisPage->set_nav_items(["Home"=>"index.php", "Rejestracja"=>"registrationForm.php", "Logowanie"=>"processLogin.php"]);

$header = '
<header class="bg-dark py-1  bg-primary rounded-3 shadow">
        <div class="rounded-3 px-4 mb-5">
            <div class="text-center">          
                    <img src="images/green.png"  class="d-block w-25 m-auto" alt="...">
            </div>           
        </div>       
</header>
';
$content = '
    <figure class="text-center m-5">
               <h1 class="fw-bolder">Udało Ci się poprawnie zarejestrować!</h1> 
               <br>
               <h4 class = "fw-light ">Możesz się teraz zalogować na swoje konto</h4>
               <br>
               <a class="btn bg-succ text-white btn-lg  gx-5 mt-2 btn-shadow border-dark" href="processLogin.php">Zaloguj się</a>
    </figure>
   </main>
';


$regisPage->set_header($header);
$regisPage->set_content($content);
$regisPage->display_All();

?>
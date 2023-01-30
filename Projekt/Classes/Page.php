<?php

class Page
{
    //klasa upraszcząjaca tworzenie strony html, dzięki której trzeba podawać jedynie zawartość oraz nagłówek

    protected $content;
    protected $title;
    protected $navItems;
    protected $styles;
    protected $header;
    protected $message;

    //początek znacznika body
    public function display_body(){
        echo '
            <body class="d-flex flex-column">
            <main class="flex-shrink-0">
            '.$this->display_nav_items();

    }


    public function set_header($newHeader){
        $this->header = $newHeader;
    }

    //wyświeltnie nagłówka
    public function display_header(){
        echo $this->header;
    }

    //wyświetlenie elementów nawigacyjnych
    public function display_nav_items(){
        $nav = '
        <nav class="navbar navbar-expand-lg navbar-light shadow-lg">
                <div class="container-fluid px-sm-5 fs-5 fw-normal">
                    <a class="navbar-brand" href="index.php"><img src="images/LOGO.png" width="96" height="64" alt="..."></a>
                    <button class="navbar-toggler " type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-sm-0 fw-bold nav-s">
        ';

        foreach ($this->navItems as $key => $value){
            $nav.='<li class="nav-item fs-4"><a class="nav-link nav-shadow" href = "'.$value.'">'.$key.'</a></li>';
        }

        $nav.='
        </ul>
                </div>
            </div>
        </nav>
        ';
        return $nav;
    }


    public function set_nav_items($newNavItems){
        $this->navItems = $newNavItems;
    }


    public function set_content($newContent){
        $this->content = $newContent;
    }


    public function set_Title($newTitle){
        $this->title=$newTitle;
    }


    public function set_styles($url) {
        $this->styles=$url;
         }

    //wyświetlenie nagłówka html
    public function display_head(){
        echo '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>'.
    $this->title
    .'
    </title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="images/LOGO.png"/>
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet"/>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <link rel="stylesheet" href="'.
            $this->styles
.'" />
  </head>
';
    }


    //wyświetlenie zawartości strony
    public function display_content(){
        echo $this->content;
    }

    //wyświetlenie wiadomości
    public function display_message(){
        echo $this->message;
    }

    //wyświetlenie stopki i koniec znacznika body
    public function display_footer(){
        echo '
        <footer class="bg-dark py-4 mt-auto shadow-lg">
    <div class="container px-5">
        <div class="row align-items-center justify-content-between flex-column flex-sm-row">
            <div class="col-auto"><div class="small m-0 text-white">Copyright &copy; Będziesz zwycięzcą 2k12</div></div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
        ';
    }

    //ustawienie typu wiadomości jaki chcemy wyświetlić na stronie oraz treści wiadomości
    public function set_message($type, $text){
        $this->message = '
                <div class="alert alert-'.$type.' text-center" role="alert">
                     <h3>'.$text.'</h3>
                 </div>
                ';
    }

    //wyświetl stronę
    public function display_All(){
        $this->display_head();
        $this->display_body();
        $this->display_header();
        $this->display_content();
        $this->display_footer();
    }

    //wyświetl stronę wraz z wiadomością
    public function display_All_with_message(){
        $this->display_head();
        $this->display_body();
        $this->display_header();
        $this->display_message();
        $this->display_content();
        $this->display_footer();
    }



}
?>
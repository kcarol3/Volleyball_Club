//oblicz wyniki ataku oraz bloku
function calculate() {
    var wz = document.getElementById('wzrost');
    var dr = document.getElementById('dReki');
    var wys = document.getElementById('wyskok');

    wz=wz.value;
    dr=dr.value;
    wys=wys.value;
    if(wz!="" && dr!="" && wys!=""){
        wz=parseFloat(wz);
        dr=parseFloat(dr);
        wys=parseFloat(wys);

        var atak = document.getElementById('atak');
        var at = wz*0.82 + dr*0.95 + wys*1.2;
        at = at.toFixed(2);
        atak.value=at;
        var blok = document.getElementById('blok');
        var bl = wz*0.8 + dr*0.95 + wys*1;
        bl = bl.toFixed(2);
        blok.value=bl;

        var save_button = '<div class="container-xl">'+'<a class="btn bg-succ text-white btn-lg btn-shadow border-dark" href = "blockAndAttack.php?save=yes&attack='+at+'&block='+bl+'">Zapisz</a>'+'</div>'+'<br>';
        document.getElementById('zapis').innerHTML = save_button;
    }
}


function sprawdzPole(pole_id, obiektRegex) {
    var obiektPole = document.getElementById(pole_id);
    if (!obiektRegex.test(obiektPole.value)) return (false);
    else return (true);
}

//Funkcja sprawdza czy przycisk typu checkbox o identyfikatorze box_id jest zaznaczony
function sprawdz_box(box_id) {
    var obiekt = document.getElementById(box_id);
    if (obiekt.checked) return true;
    else return false;
}

//wyświetl dane przed wysłaniem
function pokazDane()
{
    var dane = "\n";
    dane += "Email: " + document.getElementById('mail').value + "<br>";
    dane += "Imie: " + document.getElementById('name').value + "<br>";
    dane += "Nazwisko: " + document.getElementById('surname').value + "<br>";
    dane += "Nick: "+ document.getElementById('nick').value + "<br>";

    dane += "Preferowana Pozycja: ";
    if (sprawdz_box('przyjmujacy')) dane+=" przyjmujacy ";
    if (sprawdz_box('rozgrywajacy')) dane+=" rozgrywajacy ";
    if (sprawdz_box('srodkowy')) dane+=" srodkowy ";
    if (sprawdz_box('libero')) dane+=" libero ";
    if (sprawdz_box('atakujacy')) dane+=" atakujacy ";

    document.getElementById("modDatForm").innerHTML=dane;
    $('#modalForm').modal('show');
}

//sprawdź poprawność danych
function sprawdz() {
    var ok = true;
    obiektNick = /^[0-9A-Za-ząęłńśćźżó_-]{2,25}$/;
    obiektName = /^[A-ZŁ][a-ząęłńśćźżó]{1,25}$/;
    obiektSurname = /^[A-ZŁ][a-ząęłńśćźżó_-]{1,25}$/;
    obiektemail = /^([a-zA-Z0-9])+([.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-]+)+/;
    obiektPassword  = /^(?=.*[!@#$%^&*./])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/;

    if (!sprawdzPole("nick", obiektNick)) {
        ok = false;
        document.getElementById("nick_error").innerHTML = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">Wpisz poprawny nick!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div> ';
    }else document.getElementById("name_error").innerHTML = "";
    if (!sprawdzPole("name", obiektName)) {
        ok = false;
        document.getElementById("name_error").innerHTML = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">Wpisz poprawne imie!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div> ';
    }else document.getElementById("name_error").innerHTML = "";
    if (!sprawdzPole("surname", obiektSurname)) {
        ok = false;
        document.getElementById("surname_error").innerHTML = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">Wpisz poprawne nazwisko!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div> ';
    }else document.getElementById("surname_error").innerHTML = "";


    if (!sprawdzPole("mail", obiektemail)) {
        ok = false;
        document.getElementById("mail_error").innerHTML = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">Wpisz poprawny E-mail!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div> ';
    }else document.getElementById("mail_error").innerHTML = "";

    if (!sprawdzPole("password", obiektPassword)) {
        ok = false;
        document.getElementById("password_error").innerHTML = ' <div class="alert alert-danger alert-dismissible fade show" role="alert">Twoje hasło powinno zawierać conajmniej 8 znaków, 1 dużą literę, 1 małą literę oraz 1 znak specjalny!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div> ';
    }else document.getElementById("password_error").innerHTML = "";


    if (ok==true) pokazDane();
}

//pobieranie danych zawodników z pliku json
async function readPlayers(id)
{
    const response = await fetch('assets/players.json', {method: "GET"});
    const players = await response.json();

    player = players[id];
    output = "";

    document.getElementById('modalData').innerHTML=output;

    output += "Imię: "+player.name+"<br>";
    output += "Nazwisko: " + player.surName+"<br>";
    output += "Narodowość: " + player.national+"<br>";
    output += "Wiek: " + player.age+"<br>";
    output += "Wzrost: " + player.height+"<br>";
    output += "Masa: " + player.weight+"<br>";
    output += "Ostatni klub: " + player.latestClub+"<br>";
    output += "Pozycja: " + player.position+"<br>";

    document.getElementById('modalData').innerHTML=output;
    $('#myModal').modal('show');

}

(function () {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
})()


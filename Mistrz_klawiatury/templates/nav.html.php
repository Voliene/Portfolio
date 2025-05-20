<?php
/** @var $router \App\Service\Router */

?>
    <style>
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown a {
            text-decoration: none;
            color: black;
            padding: 10px;
            display: block;
        }

        .dropdown ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            z-index: 1;
        }

        .dropdown ul li {
            padding: 10px;
            text-align: left;
        }
        .dropdown:hover ul {
            display: block;
        }
    </style>

<ul>
    <li><a id= "home" href="<?= $router->generatePath('') ?>">Home</a></li>
    <li ><a id="courses" href="<?= $router->generatePath('courses-index') ?>">Courses</a></li>
    <li ><a id="login" href="<?= $router->generatePath('admin-login') ?>">Admin</a></li>
    <li ><a id="own" href="<?= $router->generatePath('own-text') ?>">Own Text</a></li>
    <li ><a id="reset" href="#">Reset Progress</a></li>
    <li>
        <a  href="#" id="ChangeLanguage">
            <div class="dropdown">
                <p id="language">
                Language
                </p>
                <ul>
                    <li>Angielski<button onclick="changeLanguage('en')" class="english_button"><img src="assets/src/pic/england_flag.png" alt="Flag" style="width: 100%; height: 100%;"></button></li>
                    <li>Polski<button onclick="changeLanguage('pl')" class="polish_button"><img src="assets/src/pic/poland_flag.png" alt="Flag" style="width: 85%; height: 85%;"></button></li>
                </ul>
            </div>
        </a>
    </li>

</ul>

    <script>

        function resetProgress() {
            if (confirm('Are you sure you want to reset your progress?')) {
                document.cookie = "courseProgress=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                alert('Progress has been reset.');
            }
        }

        window.addEventListener('load', function () {
            document.getElementById('reset').addEventListener('click', resetProgress);
        });



        /*tłumaczenie*/

        const languages = {
            pl: {
                home: "Strona Główna",
                courses: "Kursy",
                login: "Admin",
                own: "Własny tekst",
                reset: "Zresetuj postępy",
                language: "Język"
            },
            en: {
                home: "Home",
                courses: "Courses",
                login: "Admin",
                own: "Own Text",
                reset: "Reset progress",
                language: "language"
            }
        }


        // Funkcja zmiany języka
        function changeLanguage(lang) {
            console.log(document.getElementById('home'))
            localStorage.setItem("language",lang);
            let currentLanguage = lang;
            document.getElementById('home').innerText = languages[currentLanguage].home;
            document.getElementById('courses').innerText = languages[currentLanguage].courses;
            document.getElementById('login').innerText = languages[currentLanguage].login;
            document.getElementById('own').innerText = languages[currentLanguage].own;
            document.getElementById('reset').innerText = languages[currentLanguage].reset;
            document.getElementById('language').innerText = languages[currentLanguage].language;
        }


        window.onload = () =>
        {
          if (localStorage.getItem("language") !== null)
          {
              changeLanguage(localStorage.getItem("language"));
          }
          else
          {
              changeLanguage("en");
          }
        };
    </script>


<?php

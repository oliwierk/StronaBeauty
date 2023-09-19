<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css" />
</head>

<body>
    <nav class="nav-box">

        <a href="#home" class="nav-box__item">
            <p>HOME</p>
        </a>

        <a href="#services" class="nav-box__item">
            <p>USŁUGI</p>
        </a>
        <a href="#bmi" class="nav-box__item">
            <p>BMI</p>
        </a>
    </nav>
    <header id="home" class="header-box">
        <div class="header-box__img">
        </div>
        <div class="header-box__text ">
            <p class="header-box__text--main swing-in-top-fwd">Glamour Haven</p>
            <p class="header-box__text--second">Odkryj swoje piękno w naszym salonie.</p>
            <a href="#services">
                <i class="header-box__icon fa-solid fa-arrow-down"></i>
            </a>
        </div>
    </header>
    <section id="services" class="services wrapper">
        <div class="services-box">
            <h2 class="services-box__title">Nasza oferta:</h2>
            <?php 
				$conn = mysqli_connect('localhost','root','','bmi');
				$kw1 = "SELECT nazwa, cena FROM uslugi ORDER BY nazwa ASC";

				$q1 = mysqli_query($conn, $kw1);
				echo "<table class='services-box__table'>";
				echo "<th class='services-box__table--heading'>Nazwa zabiegu: <th class='services-box__table--heading'>Cena:";
				while ($row = mysqli_fetch_assoc($q1)) { 
					echo "<tr><td>".$row['nazwa']."</td><td>".$row['cena']."</td>";	
				}
				echo "</table>"
				?>
        </div>
    </section>
    <section id="bmi" class="bmi">
        <div class="wrapper">
            <h2 class="bmi__title">Sprawdż swoje BMI!</h2>
            <div class="bmi-box">
                <div class="bmi-box__left">
                    <img src="./img/forms.svg" alt="ZDJECIE" class="bmi-box__left--img">
                </div>
                <div class="bmi-box__right">

                    <form action="index.php" method="post">
                        <p>Wpisz swój wzrost:</p>
                        <input type="text" class="bmi-box__right--input" name="wzrost">
                        <p>Wpisz swoją wagę:</p>
                        <input type="text" class="bmi-box__right--input" name="waga">
                        <button type="submit" class="bmi-box__right--button">Oblicz!</button>
                    </form>
                    <?php 
		$conn = mysqli_connect('localhost','root','','bmi');
if (isset($_POST['wzrost']) && isset($_POST['waga'])) {
    $wzrost = $_POST['wzrost'];
    $waga = $_POST['waga'];


        $wynik = $waga / ($wzrost * $wzrost / 10000);
        $wynik = round($wynik, 2);
        $data_pomiaru = date('y-m-d');

        if ($wynik < 18) {
            $bmi_id = 1;
        } elseif ($wynik >= 19 && $wynik < 25) {
            $bmi_id = 2;
        } elseif ($wynik >= 26 && $wynik < 30) {
            $bmi_id = 3;
        } else {
            $bmi_id = 4;
        }

        $query = "INSERT INTO wynik (id, bmi_id, data_pomiaru, wynik) VALUES (NULL, '$bmi_id', '$data_pomiaru', '$wynik')";

      if (mysqli_query($conn, $query)) {
            switch ($bmi_id) {
                case 1:
                    echo "<p class='bmi-box__right--output'>Twoje BMI wynosi: " . $wynik . " - Masz niedowagę!</p>";
                    echo "<p class='bmi-box__right--output'>Skonsultuj się z lekarzem lub dietetykiem, aby poprawić swoją wagę.</p>";
                    break;
                case 2:
                    echo "<p class='bmi-box__right--output'>Twoje BMI wynosi: " . $wynik . " - Twoja waga jest prawidłowa.</p>";
                    echo "<p class='bmi-box__right--output'>Kontynuuj zdrowy styl życia, dbając o aktywność fizyczną i zdrową dietę.</p>";
                    break;
                case 3:
                    echo "<p class='bmi-box__right--output'>Twoje BMI wynosi: " . $wynik . " - Masz nadwagę!</p>";
                    echo "<p class='bmi-box__right--output'>Skonsultuj się z lekarzem lub dietetykiem, aby schudnąć i poprawić zdrowie.</p>";
                    break;
                case 4:
                    echo "<p class='bmi-box__right--output'>Twoje BMI wynosi: " . $wynik . " - Masz otyłość!</p>";
                    echo "<p class='bmi-box__right--output'>Skonsultuj się z lekarzem lub dietetykiem, aby podjąć działania zmierzające do utraty wagi i polepszenia zdrowia.</p>";
                    break;
                default:
                    echo "<p class='bmi-box__right--output'>Nieprawidłowy zakres BMI.</p>";
                    break;
            }
        } else {
            echo "<p class='bmi-box__right--output'>Błąd zapisu do bazy danych.</p>";
        }
    } else {
        echo "<p class='bmi-box__right--output'>Błąd: Wzrost i waga muszą być liczbami dodatnimi.</p>";
    }

?>
                </div>
            </div>


        </div>
    </section>
    <footer></footer>
    <script src="https://kit.fontawesome.com/d1641b1208.js" crossorigin="anonymous"></script>
</body>


</html>
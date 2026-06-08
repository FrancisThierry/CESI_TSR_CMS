<?php $title = "La marjolaine en php"; ?>

<?php
$numberarray = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

//accès à un index particulier
echo $numberarray[0];



//boucle for
for ($i = 0; $i < count($numberarray); $i++) {
    echo $numberarray[$i];
}

//un tableau associatif
$numberarray = array(
    "one" => 1,
    "two" => 2,
    "three" => 3,
    "four" => 4,
    "five" => 5,
    "six" => 6,
    "seven" => 7,
    "eight" => 8,
    "nine" => 9,
    "ten" => 10,
);

//accès à un index particulier
echo $numberarray["one"];

?>

<! doctype html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./assets/css/style.css">
        <title>La marjolaine</title>
    </head>

    <body >
        <h1><?php echo $title; ?></h1>
        <p class="enorange">La marjolaine ou origan des jardins (Origanum majorana) est une espèce de plantes à fleurs de la famille des
            Lamiacées. C'est une plante herbacée vivace originaire du bassin méditerranéen et cultivée ailleurs comme
            plante condimentaire pour ses feuilles aromatiques. C'est une espèce très proche de l'origan commun
            (Origanum vulgare).</p>
        <p>C'est une plante vivace, de 60 cm de haut. <br /> Les feuilles sont opposées, duveteuses, vert grisâtre, de
            forme ovale entière, de 1 à 2 cm de long. Les petites fleurs sont blanches ou mauves, réunies en groupes
            serrés à l'aisselle des feuilles avec deux bractées en forme de cuillère.</p>

            <a href="https://fr.wikipedia.org/wiki/Origanum_majorana" target="_blank">En savoir plus</a>

            <a href="./autrepage.html">Autre page</a>




        <p>
              <h1 class="enorange">En image</h1>

            <img src="./assets/images/500px-Origanum_majorana.jpg" alt="Origanum majorana" />
        </p>


    </body>



    </html>
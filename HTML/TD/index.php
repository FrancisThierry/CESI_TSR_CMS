<?php require_once("./content/data.php"); ?>

<?php

$flower = $_GET["flower"];
$color = $_GET["color"];

echo htmlspecialchars( "le parametre flower est $flower");


?>

<! doctype html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="./assets/css/style.css">
        <title>La marjolaine</title>
    </head>
    <body>
        <nav>
            <ul>
                <li><a href="./index.php?flower=marjolaine&color=orange">Marjolaine</a></li>
                <li><a href="./index.php?flower=petunia">Pétunia</a></li>
                <li><a href="./index.php?flower=coquelicot">Coquelicot</a></li>
            </ul>
        </nav>
        <h1><?php echo $blog["title"]; ?></h1>
        <p class="enorange"><?= $blog["firstparagraph"]; ?></p>
        <p><?= $blog["secondparagraph"]; ?></p>

        <a href=<?= $blog["link"]; ?> target="_blank">En savoir plus</a>

        <a href="./autrepage.html">Autre page</a>




        <p>
        <h1 class="enorange">En image</h1>

        <img src=<?= $blog["image"]; ?> alt="Origanum majorana" title="Origanum majorana" />
        </p>


    </body>



    </html>
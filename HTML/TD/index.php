<?php require_once("./content/data.php"); ?>
<?php require_once("./content/data_en_GB.php"); ?>
<?php require_once("./content/functions/stringutility.php"); ?>
<?php require_once("./content/functions/i18n.php"); ?>
<?php require_once("./content/src/blog/blog.php"); ?>
<?php

session_start();

$flower = $_GET["flower"];
$lang = isset($_SESSION["lang"]) ? $_SESSION["lang"] : $_GET["lang"];
$color = $_GET["color"];

if ($lang == "en_GB") {
    $blg = $blog_en_GB;
} else {
    $blg = $blog;
}

if ($flower == "marjolaine") {
    $blog = $blg["marjolaine"];
} elseif ($flower == "petunia") {
    $blog = $blg["petunia"];
} elseif ($flower == "coquelicot") {
    $blog = $blg["coquelicot"];
} else {
    $blog = $blg["marjolaine"];
}

$blogObject = new Blog($blog["title"], $blog["firstparagraph"], $blog["secondparagraph"], $blog["image"], $blog["link"]);


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
        <p></p>
        <nav>

            <ul>
                <li><a href="./changelang.php?lang=fr_FR&flower=<?= $flower ?>">Français</a></li>
                <li><a href="./changelang.php?lang=en_GB&flower=<?= $flower ?>">English</a></li>
            </ul>
        </nav>
        <h1><?php echo $blogObject->getTitle(); ?></h1>

        <h2><?= langBy($lang); ?> <?php echo Blog::author; ?></h2>

        <p class="enorange"><?= $blogObject->getFirstParagraph() ?></p>
        <p><?= gras($blogObject->getSecondParagraph()); ?></p>

        <a href=<?= $blogObject->getLink(); ?> target="_blank"><?= langMoreAbout($lang); ?></a>

        <p>
        <h1 class="enorange"><?= langInImage($lang) ?></h1>

        <img src=<?= $blogObject->getImage(); ?> alt="Origanum majorana" title="Origanum majorana" />
        </p>


    </body>



    </html>
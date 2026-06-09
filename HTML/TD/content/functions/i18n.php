<?php require_once("./content/data.php"); ?>
<?php require_once("./content/data_en_GB.php"); ?>
<?php
function langMoreAbout($lang)
{
    if ($lang == "en_GB") {
        return "More about";
    } else {
        return "En savoir plus";
    }
}


function langInImage($lang)
{
    if ($lang == "en_GB") {
        return "In images";
    } else {
        return "En images";
    }
}

function langBy($lang)
{
    if ($lang == "en_GB") {
        return "By";
    } else {
        return "Par";
    }
}

?>
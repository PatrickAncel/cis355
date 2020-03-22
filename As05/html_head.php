<?php

function echoHTMLHead($pageTitle, $path) {

    $bootstrapLink = '<link rel="stylesheet" href="' . $path . '../bootstrap-4.4.1-dist/css/bootstrap.css">';

    echo '<html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">'
        . "<title>$pageTitle</title>$bootstrapLink" . '</head>';
}

?>
<?php

function dep($data){
    echo "<pre>";
    var_dump($data);
    echo "</pre>";
}


function s($html) : string{//Funcion para sanitizar el html
    $s = htmlspecialchars($html);
    return $s;
}

<?php

function sanitizarNombre ($nombre){
    return filter_var(trim($nombre), FILTER_SANITIZE_SPECIAL_CHARS); //investigue y vi que esta version es mas segura y hace lo mismo y es mas actual.
}

function sanitizaEmail($email){
    return filter_var(trim($email), FILTER_SANITIZE_SPECIAL_CHARS);
}

function sanitizarEdad($edad){
    return filter_var(trim($edad),FILTER_SANITIZE_SPECIAL_CHARS);
}

function sanitizarSitioWeb($sitioWeb){
    return filter_var(trim($sitioWeb),FILTER_SANITIZE_URL);
}

function sanitizarGenero($genero){
    return filter_var(trim($genero),FILTER_SANITIZE_SPECIAL_CHARS);
}

function sanitizarIntereses($intereses){
    return array_map(function($intereses){
        return filter_var(trim($intereses),FILTER_SANITIZE_SPECIAL_CHARS);
    },$intereses);
}

function sanitizarComentarios($comentarios){
    return htmlspecialchars(trim($comentarios),ENT_QUOTES,'UTF-8');
}

?>
<?php 
//Funcione de contar palabras
function contar_palabras($texto){
    $palbras = str_word_count($texto);
    return $palbras;
};

//Funcion de contar vocales
function contar_vocales($texto){
    $vocales = ["a,e,i,o,u"];
    
};

//Funcion de invertir palabras
function invertir_palabras($texto){
        $palabras = explode(' ', $texto);
        $palabras_invertidas = array_reverse($palabras);
        return implode(' ', $palabras_invertidas);
};
?>
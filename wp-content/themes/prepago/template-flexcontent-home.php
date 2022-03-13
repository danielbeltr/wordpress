<?php 
/*
Template Name:flexible content home
*/
header("Access-Control-Allow-Origin: *");
header("Content-type:application/json");

echo json_encode(['content'=> get_field('contenido_home')]);
?>
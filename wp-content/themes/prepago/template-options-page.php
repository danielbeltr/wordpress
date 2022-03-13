<?php
/*
Template Name:template-options-page
*/
header("Access-Control-Allow-Origin: *");
header("Content-type:application/json");

$header = get_field('header_options','options');
$footer = get_field('footer_options','options');

echo json_encode(['header_options'=>$header,'footer_options'=>$footer]);
?>
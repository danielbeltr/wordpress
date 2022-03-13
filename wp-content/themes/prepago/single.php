<?php
header("Access-Control-Allow-Origin: *");
header("Content-type:application/json");
get_header();
//	echo json_encode( ['content'=> get_the_content()]);
//$p = get_post();
//echo json_encode(['content'=>$p->post_content]);
echo json_encode(['content'=>get_field('contenido_entrada')]);
?>
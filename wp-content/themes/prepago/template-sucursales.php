<?php
/*
Template Name: template lista sucursales
*/
header("Access-Control-Allow-Origin: *");
header("Content-type:application/json");
//echo json_encode(get_field('opciones_sucursales'));
//

$campo = get_field('campo');
$orden = get_field('orden');

$arr_sucursales = array('items_sucursales'=>[]);
$sucursales_posts = new WP_Query( array( 'post_type' => 'sucursal', 'posts_per_page'=>'-1', 'meta_key' => $campo,
										 'orderby'=> 'meta_value',
										 'order'=> $orden) );

while ( $sucursales_posts->have_posts() ) : $sucursales_posts->the_post();
	$sucursal = array(
						'nombre'=>get_field('nombre'),
						'direccion'=>get_field('direccion'),
						'comuna'=>get_field('comuna'),
						'servicios'=>get_field('servicios'),
						'horario'=>get_field('horario'),
						'coordenadas'=>get_field('coordenadas')
					 );
	array_push($arr_sucursales['items_sucursales'],$sucursal);
endwhile;

echo json_encode($arr_sucursales)
?>
<?php
header("Access-Control-Allow-Origin: *");
header("Content-type:application/json");
			// Start the Loop.
			while ( have_posts() ) :
				the_post();
			var_dump( get_field('contenido_entrada'));

			endwhile;
?>
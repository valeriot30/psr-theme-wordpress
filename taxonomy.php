<?php
global $obj;
$obj = get_queried_object();

if ($obj->taxonomy == "categorie_servizio")
	get_template_part("archive-servizio");
else if ( $obj->post_type=="documento_pubblico" ||  $obj->taxonomy == "tipi_documento" || $obj->taxonomy == "tipi_doc_albo_pretorio"){
	get_template_part( "archive-documento" );
}
else if ( $obj->post_type=="tipi_notizia" ||  $obj->taxonomy == "tipi_notizia" || $obj->taxonomy == "tipi_notizia"){
	get_template_part( "archive-notizia" );
}
else if($obj->taxonomy == "argomenti")
	get_template_part("archive-argomento");
else
	get_template_part("archive");
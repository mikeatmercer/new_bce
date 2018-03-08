<?php


function shortcode_reference() {
 add_meta_box("shortcode_reference", "Shortcode references", function(){ echo "[pagelink id=INT]LINK TEXT[/pagelink]<br/><br/>[postimage id=INT type={'poster','phone','desktop','normal'}] CAPTION [/postimage]";
   },
   null,
   'side',
   'high');

}

add_action( 'add_meta_boxes', 'shortcode_reference' );

?>

<?php
function codeblock_shortcode( $atts, $content = null ) {

  $text = $content;


	return '<div class="code-block"><pre><code>'.htmlentities(trim($text)).'</code></pre></div>';
}
add_shortcode( 'codeblock', 'codeblock_shortcode' );

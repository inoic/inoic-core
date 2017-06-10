<?php 

// Add Shortcode
function inoic_placeholder_shortcode( $atts , $content = null ) {

  // Attributes
  $atts = shortcode_atts(
    array(
      'width' => '350',
      'height' => '200',
      'color' => '#dedede',
      'text_color' => '#555555'
    ),
    $atts
  );

  $content = null == $content ? $atts['width'] . '&times;' . $atts['height'] : $content;

  $svg = '
  <svg xmlns="http://www.w3.org/2000/svg" width="'. $atts['width'] .'" height="'. $atts['height'] .'">
  <rect width="'. $atts['width'] .'" height="'. $atts['height'] .'" style="fill:'.$atts['color'].'"/>
  <text x="50%" y="50%" font-size="18" text-anchor="middle" alignment-baseline="middle" font-family="monospace, sans-serif" fill="'.$atts['text_color'].'"> '. $content .' </text>
  </svg>';

  return $svg;

}
add_shortcode( 'svg_placeholder', 'inoic_placeholder_shortcode' );

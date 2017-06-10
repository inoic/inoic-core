<?php

class Inoic_Helpers {

  protected static $instance;

  public function __construct() {
    add_filter('post_gallery', array($this, 'modify_post_gallery'), 10, 2);
    add_filter('the_content',array($this, 'strip_first_shortcode_gallery') );
  }

  public static function get_instance() {
    if ( null == self::$instance ) {
        self::$instance = new self;
    }
    return self::$instance;
  }

  /*
   * Set post views count using post meta
   */
  public static function set_post_views($postID) {
      $countKey = 'post_views_count';
      $count = get_post_meta($postID, $countKey, true);
      if ($count == '') {
          $count = 0;
          delete_post_meta($postID, $countKey);
          add_post_meta($postID, $countKey, '0');
      } else {
          $count++;
          update_post_meta($postID, $countKey, $count);
      }
  }

  /*
   * Get post views count using post meta
   */
  public static function get_post_views($postID) {
      $count_key = 'post_views_count';
      $count = get_post_meta($postID, $count_key, true);
      if ($count == '') {
          delete_post_meta($postID, $count_key);
          add_post_meta($postID, $count_key, '0');
          return "0 View";
      }
      $views_text = sprintf(_n('%s view', '%s views', $count, 'beatrice'), $count);
      return $views_text;
  }

  public static function post_has_gallery( $post ) {
  if( stripos( $post->post_content, '[gallery' ) ) {
    return true;
  }
  return false;
}

function modify_post_gallery($output, $attr) {

    global $post;
    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby']) {
            unset($attr['orderby']);
        }
    }
    extract(shortcode_atts(
        array(
        'order' => 'ASC',
        'orderby' => 'menu_order ID',
        'id' => $post->ID,
        'itemtag' => 'div',
        'icontag' => 'i',
        'captiontag' => 'span',
        'columns' => 3,
        'size' => 'thumbnail',
        'include' => '',
        'exclude' => '',
    ), $attr));

    $id = intval($id);
    if ('RAND' == $order) {
        $orderby = 'none';
    }

    if (!empty($include)) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    }

    if (empty($attachments)) {
      return '';
    }

    $output = "<div class=\"flick\">\n";
    foreach ($attachments as $id => $attachment) {
        $output .= "<div class=\"flick-cell\">\n";
        $img = wp_get_attachment_image_src($id, 'full');
        $output .= "<img src=\"{$img[0]}\" width=\"{$img[1]}\" height=\"{$img[2]}\" alt=\"\" />";
        $output .= !empty($attachment->post_excerpt) ? "<span class=\"flick-caption\"> $attachment->post_excerpt </span>" : '';
        $output .= "</div>\n";
    }

    $output .= "</div>\n";

    return $output;
}




function  strip_first_shortcode_gallery( $content ) {
  global $post;

    preg_match_all( '/'. get_shortcode_regex() .'/s', $content, $matches, PREG_SET_ORDER );
    if ( ! empty( $matches ) && ! has_post_format('gallery', $post->ID) ) {
        foreach ( $matches as $shortcode ) {
            if ( 'gallery' === $shortcode[2] ) {
                $pos = strpos( $content, $shortcode[0] );
                if ($pos !== false)
                    return substr_replace( $content, '', $pos, strlen($shortcode[0]) );
            }
        }
    }
    return $content;
  }

}

Inoic_Helpers::get_instance();

<?php

class PSC_Featured_Content {

	protected static $instance = null;

  var $options = array(
    'post_type' => 'page',
    'parent' => null,
		'pagename' => null,
    'order' => 'DESC',
    'orderby' => 'date',
    'excerpt' => 'false',
    'number' => null,
    'ids' => null,
    'template' => null,
    'filterby' => null,
    'taxonomy' => null,
    'paginate' => null,
    'term' => null,
    'no-posts-message' => null,
    'container' => null,
  );


	private function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ), 0 );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    add_shortcode('psc-featured-content', array( $this, 'shortcode' ));

	}

	public static function get_instance() {

		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}


	public function enqueue_styles(){
    wp_enqueue_style( 'psc-featured-content-style',plugins_url('/css/psc-featured-content.css', __FILE__) );
	}

	public function enqueue_scripts() {
  	wp_enqueue_media();
	}


  public function shortcode($atts){

		$options = shortcode_atts($this->options, $atts,'psc-featured');

		return $this->get_posts($options);

  }



  public function get_posts($options){

		$posts = array();

    $query_params = array();

    if($options['parent'] != null){
      if(strpos($options['parent'],',') !== false){
         $query_params['post_parent__in'] = explode(',',$options['parent']);
      }else{
         $query_params['post_parent'] = (int) $options['parent'];
      }
    }

    if($options['post_type'] != null){
      $query_params['post_type'] = array($options['post_type']);
    }

		if($options['pagename'] != null){
			$query_params['pagename'] = $options['pagename'];
		}

    if($options['orderby'] != null){
      $query_params['orderby'] = $options['orderby'];
    }

    if($options['order'] != null){
      $query_params['order'] = $options['order'];
    }

    if($options['ids'] != null){
      $query_params['post__in'] = explode(',',$options['ids']);
    }

    if($options['number']){
      $query_params['posts_per_page'] = $options['number'];
    }else{
      $query_params['posts_per_page'] = -1;
    }

    if($options['column_class']){
      $column_class = $options['column_class'];
    }else{
      $column_class = "one_fourth";
    }

    if(substr($options['template'],-4) == ".php"){
       $options['template'] = substr($options['template'],0,-4);
    }

    if($options['taxonomy'] && $options['term']){
      	$query_params['tax_query'] = array(
      		array(
      			'taxonomy' => $options['taxonomy'],
      			'field'    => 'slug',
      			'terms'    => $options['term'],
      		)
  	   );
    }

		$query = new WP_Query($query_params);

		$html = '';

		if($options['container'] != "none"){
			global $psc_fc_container_count;
			$psc_fc_container_count++;
			$container_id = 'psc-fc-container-'.$psc_fc_container_count;
    	$html .= '<div class="psc-fc-container" id="'.$container_id.'">';
		}

    $count = 1;


		while ($query->have_posts()) {

      $post_classes = '';

			$query->the_post();

      $taxonomies = get_post_taxonomies($query->post);

      foreach ($taxonomies as $key=>$taxonomy) {

        	$post_terms = get_the_terms($query->post,$taxonomy);

          if(is_array($post_terms)){
            foreach ($post_terms as $key=>$term) {
            	 $post_classes .= " ".$term->taxonomy.'-'.$term->slug;
            }
          }
       }



      $feat_image = wp_get_attachment_url(get_post_thumbnail_id($query->post->ID));

      // Todo: move this outside the loop and use placeholders in template, for performance...

      // Use a template file if available

      if($options['template'] && file_exists(get_stylesheet_directory() . '/featured-content-templates/' . $options['template'] . '.php')){

        ob_start();
        include get_stylesheet_directory() . '/featured-content-templates/' . $options['template'] . '.php';
        $html .= ob_get_clean();

      }else if($options['template'] && file_exists(PSC_FC_PATH . 'templates/' . $options['template'] . '.php')){

        ob_start();
        include PSC_FC_PATH . 'templates/' . $options['template'] . '.php';
        $html .= ob_get_clean();

      }else{ // Otherwise use default

        $html .= '
        <div class="psc-fc-post '.$column_class.$post_classes.'" '.$post_data_attributes.'>
          <div class="psc-fc-image">
            <a href="'.get_permalink().'"><img class="aligncenter" src="'.$feat_image.'" alt=""/></a>
          </div>
          <h5 class="psc-fc-title"><strong><a href="'.get_permalink().'">'.get_the_title().'</a></strong></h5>';

        if($options['excerpt'] == 'true'){
           $html .= '<div class="psc-fc-excerpt">'.get_the_excerpt().'</div>';

        }

        $html .= '</div>';

      }

      $count++;
		}

		// No posts found. Show the no posts message if set
		if($count == 1 && $options["no-posts-message"]){
			$html .= $options["no-posts-message"];
		}
		if($options['container'] != "none"){
			$html .= "</div>";
		}


    wp_reset_postdata();

    /* Call the filtering method */
    if($options['filterby'] && method_exists('PSC_Filter','filter_controls')){

      $filter_options = array('taxonomies'=>$options['filterby'],'container'=>$container_id);

      if($options['paginate']){
         $filter_options['paginate'] = $options['paginate'];
      }

      $filters_html = PSC_Filter::filter_controls($filter_options);
      $html = $filters_html.$html;

    }

		return $html;
	}

}

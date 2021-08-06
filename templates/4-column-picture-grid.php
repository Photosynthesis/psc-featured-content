<div id="post-<?php echo $query->post->ID ?>" class="psc-fc-post <?php echo $post_classes?>" style="width: 21%; margin-right: 3%; float:left;">
  <a href="<?php echo get_permalink() ?>">                                
    <span class="psc-fc-image">
      <img src="<?php echo $feat_image ?>" alt="<?php echo get_the_title() ?>" class="aligncenter">
    </span>
	</a>
  <h5 class="psc-fc-title" style="text-align: center; margin-top: 15px; line-height: 1.3em;"><strong><a href="<?php echo get_permalink() ?>"><?php echo get_the_title() ?></a></strong></h5>
</div>
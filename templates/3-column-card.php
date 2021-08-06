<div id="post-<?php echo $query->post->ID ?>" class="<?php echo $post_classes ?> psc-fc-post psc-one-third psc-fc-card">
  <a href="<?php echo get_permalink() ?>">
     <span class="psc-fc-image">
       <img src="<?php echo $feat_image ?>" alt="<?php echo get_the_title() ?>" class="aligncenter">
     </span>
 	</a>

  <h5 class="psc-fc-title"><strong><a href="<?php echo get_permalink() ?>"><?php echo get_the_title() ?></a></strong></h5>
  <?php
  if(has_excerpt($query->post->ID)){
  ?>
    <div class="psc-fc-card-excerpt">
    <?php echo the_excerpt(); ?>
    </div>
  <?php
  }
  ?>
</div>

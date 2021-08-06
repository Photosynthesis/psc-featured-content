<div id="post-<?php echo $query->post->ID ?>" class="<?php echo $post_classes?> psc-fc-list-post">
    <?php if($feat_image): ?>
    <a href="<?php echo get_permalink() ?>"><img src="<?php echo $feat_image ?>" alt="<?php echo get_the_title() ?>"  class="psc-fc-alignleft psc-one-third psc-post-list-thumbnail" ></a>
<?php endif; ?>

    <h3 style="clear:none"><strong><a href="<?php echo get_permalink() ?>"><?php echo get_the_title() ?></a></strong></h3>
    <span class="psc-fc-posted-on">Posted on <?php echo get_the_date(); ?></span>
    <p style="overflow:hidden">
    <?php
    if ( has_post_format( 'video' )) {
        the_content();
    }else{
        the_excerpt();
    }
?>
    </p>
    <?php if(! has_post_format( 'video' )){ ?>
    <div class="psc-fc-read-more"><a href="<?php echo get_permalink() ?>">Read more &gt; </a></div>
    <?php } ?>
</div>

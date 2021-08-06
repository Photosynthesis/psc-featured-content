<?php

$article_url = $query->post->murmurations_feed_item_url;
$node_name = $query->post->murmurations_feed_item_data['node_name'];
$node_url = $query->post->murmurations_feed_item_data['node_url'];
$image = $query->post->murmurations_feed_item_data['image'];

?>

<div id="post-<?php echo $query->post->ID ?>" class="<?php echo $post_classes?>  murmurations-feed-item">
  <?php if($image): ?>
  <a href="<?php echo get_permalink() ?>"><img src="<?php echo $image ?>" alt="<?php echo get_the_title() ?>"  class="psc-fc-alignleft psc-one-third psc-post-list-thumbnail" ></a>
  <?php endif; ?>

  <h3 style="clear:none"><strong><a href="<?php echo $article_url ?>"><?php echo get_the_title() ?></a></strong></h3>
  <span class="psc-fc-posted-on"><?php echo get_the_date(); ?> from <a href="<?= $node_url ?>"><?= $node_name ?></a></span>
  <div class="content">
    <?php
    echo get_the_excerpt();
    ?>
  </div>

  <?php
  $tags = array();

  $post_tags = get_the_terms( $query->post, 'murms_feed_item_tag' );

  if ( $post_tags ) {
    foreach( $post_tags as $tag ) {
      $tags[] = $tag->name;
    }
  }

  if(count($tags) > 0): ?>
    <div class="tags">
      <svg class="svg-icon" width="16" height="16" aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7z"></path><path d="M0 0h24v24H0z" fill="none"></path></svg>
      <?= join(', ',$tags) ?>
    </div>
  <?php
  endif;
  ?>
</div>

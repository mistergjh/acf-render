<div class="acf-template acf-template-post-object">
  <?php

    $post_object = $template->getFieldValue( $field );

    if( $post_object ):

    	// override $post
    	$post = $post_object;
    	setup_postdata( $post );

    	?>
      <div>
      	<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
      </div>
      <?php wp_reset_postdata(); ?>

  <?php endif; ?>
</div>

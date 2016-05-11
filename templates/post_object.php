<div class="acf-field col-md-12">
  <?php

    $post_object = $view->getFieldValue( $fields );

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

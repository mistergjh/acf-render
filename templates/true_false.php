<div class="acf-template acf-template-true-false">
  <?php
    if( $template->getFieldValue( $field ) ) {
      print 'true';
    } else {
      print 'false';
    }
  ?>
</div>

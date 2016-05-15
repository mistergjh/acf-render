<div class="acf-field acf-field-$templatese col-md-12">
  <?php
    if( $template->getFieldValue( $field ) ) {
      print 'true';
    } else {
      print 'false';
    }
  ?>
</div>

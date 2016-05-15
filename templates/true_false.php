<div class="acf-field acf-field-true-false col-md-12">
  <?php
    if( $view->getFieldValue( $fields ) ) {
      print 'true';
    } else {
      print 'false';
    }
  ?>
</div>

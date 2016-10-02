<div class="acf-template acf-template-checkbox">
  <div class="acf-checkbox-values">
    <?php
      $vals = $template->getFieldValue( $field );
      if( !empty($vals)) {
      foreach( $vals as $val ):
    ?>
      <div class="acf-checkbox-value">
        <?php print $val; ?>
      </div>
    <?php endforeach; } else { ?>
      <div class="acf-checkbox-value acf-checkbox-empty">
        <?php print $template->emptyMessage; ?>
      </div>
    <?php } ?>
  </div>
</div>

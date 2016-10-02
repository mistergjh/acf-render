<div class="acf-template acf-template-select">
  <div class="acf-checkbox-values">
    <?php
      $vals = $template->getFieldValue( $field );
      if( is_array($vars) && count($vals) >= 1 ) {
      foreach( $vals as $val ):
    ?>
      <div class="acf-checkbox-value">
        <?php print $val; ?>
      </div>
    <?php endforeach; } elseif( $vals ) { ?>
      <div class="acf-checkbox-value acf-checkbox-empty">
        <?php print $vals; ?>
      </div>
    <?php } ?>
  </div>
</div>

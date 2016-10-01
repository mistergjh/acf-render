<div class="acf-field acf-template-text">

  <?php if( $template->showLabel() ) : ?>
    <div class="acf-field-label">
      <?php print $template->getLabel(); ?>
    </div>
  <?php endif; ?>

  <div class="acf-field-value">
    <?php print $template->getFieldValue(); ?>
  </div>
  
</div>

<div class="acf-field col-md-12">

  <?php if( $template->showLabel() ) : ?>
    <div class="acf-field-label">
      <?php print $template->getLabel(); ?>
    </div>
  <?php endif; ?>

  <div class="acf-field-value">
    <?php print $template->getFieldValue(); ?>
  </div>
</div>

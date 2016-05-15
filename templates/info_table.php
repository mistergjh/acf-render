<div class="container">
  <div class="row">
    <div class="col-md-12">

      <table class="table table-striped">

        <?php foreach( $fields as $field ) :
          print $view->getInfoTableRow( $field );
        endforeach;
        ?>

      </table>

    </div>
  </div>
</div>

<?php if(Session::get('errorMessage') || isset($errorMessage)): ?>
<div class="alert alert-danger alert-dismissible" role="alert" id="alertOnProcess">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <?php echo Session::get('errorMessage')? Session::get('errorMessage') : $errorMessage; ?>

</div>
<?php endif; ?>
<?php if(Session::get('successMessage') || isset($successMessage)): ?>
<div class="alert alert-success alert-dismissible" role="alert" id="alertOnProcess">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <?php echo Session::get('successMessage')? Session::get('successMessage') : $successMessage; ?>

</div>
<?php endif; ?>

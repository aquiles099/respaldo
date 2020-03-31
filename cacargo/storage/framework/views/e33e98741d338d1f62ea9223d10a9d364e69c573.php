<div class="help-block with-errors">
  <?php if(isset($errors) && $errors->get($name)): ?>
    <ul class="list-unstyled">
      <?php foreach($errors->get($name) as $error): ?>
        <li><?php echo $error; ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</div>

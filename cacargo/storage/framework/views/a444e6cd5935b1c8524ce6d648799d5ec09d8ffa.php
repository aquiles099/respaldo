<?php if(isset($errors)): ?>
<span class="help-block" style="margin-bottom: 0px;">
  <?php if($errors->get($field)): ?>
    <?php foreach($errors->get($field) as $error): ?>
      <?php echo e($error); ?>

    <?php endforeach; ?>
  <?php else: ?>
    <?php $ul = false; ?>
    <?php foreach($errors->getMessages() as $key => $error): ?>
      <?php if(preg_match("/$field\.\\d+/", $key)): ?>
        <?php if(!$ul): ?>
          <ul>
          <?php $ul = true; ?>
        <?php endif; ?>
        <li><?php echo e($error[0]); ?></li>
      <?php endif; ?>
    <?php endforeach; ?>
    <?php if($ul): ?>
      </ul>
    <?php endif; ?>
  <?php endif; ?>
</span>
<?php endif; ?>

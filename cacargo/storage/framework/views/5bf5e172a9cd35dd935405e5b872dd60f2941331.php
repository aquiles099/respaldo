<?php if(isset($picks)): ?>
  $.fn.pickList = function(options) {
    var opts = $.extend({selected: [], data: []}, $.fn.pickList.defaults, options);
    this.fill = function() {
      var option = '';
      var optionSelected = '';
      $.each(opts.data, function(key, val) {
        if (opts.selected.indexOf(val.id) != -1) {
          optionSelected += `<option value="${val.id}">${val.text}</option>`;
        } else {
          option += `<option value="${val.id}">${val.text}</option>`;
        }
      });
      this.source.append(option);
      this.selected.append(optionSelected);
    };
    this.controll = function() {
      var pick = this;
      this.add.on('click', function() {
        var p = pick.source.find('option:selected');
        p.clone().appendTo(pick.selected);
        p.remove();
      });
      //
      this.addAll.on('click', function() {
        var p = pick.source.find('option');
        p.clone().appendTo(pick.selected);
        p.remove();
      });
      //
      this.remove.on('click', function() {
        var p = pick.selected.find('option:selected');
        p.clone().appendTo(pick.source);
        p.remove();
      });
      //
      this.removeAll.on('click', function() {
        var p = pick.selected.find('option');
        p.clone().appendTo(pick.source);
        p.remove();
      });
    };
    this.init = function() {
      var html =
        `<div class="row">`                                                                                                                +
        `  <div class="col-sm-5">`                                                                                                         +
        `	 <select class='form-control pickListSelect pick-source' <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> multiple></select>`                           +
        ` </div>`                                                                                                                          +
        ` <div class="col-sm-2 pickListButtons">`                                                                                          +
        <?php if(!(isset($readonly) && $readonly)): ?>
          `	  <button type="button" class='btn btn-primary btn-sm pick-add'>${opts.add}</button>`                                          +
          `   <button type="button" class='btn btn-primary btn-sm pick-add-all'>${opts.addAll}</button>`                                   +
          `	  <button type="button" class='btn btn-primary btn-sm pick-remove'>${opts.remove}</button>`                                    +
          `	  <button type="button" class='btn btn-primary btn-sm pick-remove-all'>${opts.removeAll}</button>`                             +
        <?php endif; ?>
        ` </div>`                                                                                                                          +
        `  <div class="col-sm-5">`                                                                                                         +
        `    <select class="form-control pickListSelect pick-selected" <?php echo $__env->make('form.readonly', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> multiple name="${opts.name}[]"></select>` +
        `  </div>`                                                                                                                         +
        `</div>`;
      this.append(html);
      this.source = this.find('.pick-source');
      this.selected =  this.find('.pick-selected');
      this.add =  this.find('.pick-add');
      this.remove =  this.find('.pick-remove');
      this.addAll =  this.find('.pick-add-all');
      this.removeAll =  this.find('.pick-remove-all');
      this.fill();
      this.controll();
    };
    this.init();
    return this;
  };
  $.fn.pickList.defaults = {
    add: '<?php echo e(trans('messages.add')); ?>',
    addAll: '<?php echo e(trans('messages.addAll')); ?>',
    remove: '<?php echo e(trans('messages.remove')); ?>',
    removeAll: '<?php echo e(trans('messages.removeAll')); ?>'
  };
  <?php foreach($picks as $key => $pick): ?>
    $("#pick<?php echo e($key); ?>").pickList({
      name : '<?php echo e($pick['name']); ?>',
      selected : [
        <?php foreach($pick['selected'] as $row): ?>
          '<?php echo e($row); ?>',
        <?php endforeach; ?>
      ],
      data: [
        <?php foreach($pick['data'] as $row): ?>
          <?php
            try {
              $option = $row->toOption();
            } catch(\Exception $e) {
              $option = ['id' => '-1', 'text' => 'Error :('];
            }
          ?>
          {id: '<?php echo e($option['id']); ?>', text: '<?php echo e($option['text']); ?>'},
        <?php endforeach; ?>
    ]});
  <?php endforeach; ?>
<?php endif; ?>;

@if(isset($picks))
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
        `	 <select class='form-control pickListSelect pick-source' @include('form.readonly') multiple></select>`                           +
        ` </div>`                                                                                                                          +
        ` <div class="col-sm-2 pickListButtons">`                                                                                          +
        @if(!(isset($readonly) && $readonly))
          `	  <button type="button" class='btn btn-primary btn-sm pick-add'>${opts.add}</button>`                                          +
          `   <button type="button" class='btn btn-primary btn-sm pick-add-all'>${opts.addAll}</button>`                                   +
          `	  <button type="button" class='btn btn-primary btn-sm pick-remove'>${opts.remove}</button>`                                    +
          `	  <button type="button" class='btn btn-primary btn-sm pick-remove-all'>${opts.removeAll}</button>`                             +
        @endif
        ` </div>`                                                                                                                          +
        `  <div class="col-sm-5">`                                                                                                         +
        `    <select class="form-control pickListSelect pick-selected" @include('form.readonly') multiple name="${opts.name}[]"></select>` +
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
    add: '{{trans('messages.add')}}',
    addAll: '{{trans('messages.addAll')}}',
    remove: '{{trans('messages.remove')}}',
    removeAll: '{{trans('messages.removeAll')}}'
  };
  @foreach ($picks as $key => $pick)
    $("#pick{{$key}}").pickList({
      name : '{{$pick['name']}}',
      selected : [
        @foreach ($pick['selected'] as $row)
          '{{$row}}',
        @endforeach
      ],
      data: [
        @foreach ($pick['data'] as $row)
          <?php
            try {
              $option = $row->toOption();
            } catch(\Exception $e) {
              $option = ['id' => '-1', 'text' => 'Error :('];
            }
          ?>
          {id: '{{$option['id']}}', text: '{{$option['text']}}'},
        @endforeach
    ]});
  @endforeach
@endif;

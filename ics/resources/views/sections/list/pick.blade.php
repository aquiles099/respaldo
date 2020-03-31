<?php
    global $picks;
    if (!isset($picks) || is_null($picks) || !is_array($picks)) {
      $picks = [];
    }
    $name = isset($name) ? $name : 'pick'.(count($picks));
    $picks[] = [
      'name' => $name,
      'data' => isset($data) ? $data : [],
      'selected' => isset($selected) ? $selected : []
    ];
?>
<div class="form-group row @include('errors.field-class', ['field' => $name])">
  @if (isset($label))
    @if(isset($large))
      @else
      <label class="col-lg-3 control-label">{{$label}}</label>
    @endif
    <div @if(isset($large)) class="col-lg-12" @else class="col-lg-9"  @endif>
      <div id="pick{{count($picks) - 1}}"></div>
      @include('errors.field', ['field' => $name])
    </div>
  @else
    <div class="col-lg-12">
      <div id="pick{{count($picks) - 1}}"></div>
      @include('errors.field', ['field' => $name])
    </div>
  @endif
</div>

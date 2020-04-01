<div class="help-block with-errors">
  @if(isset($errors) && $errors->get($name))
    <ul class="list-unstyled">
      @foreach ($errors->get($name) as $error)
        <li>{!! $error !!}</li>
      @endforeach
    </ul>
  @endif
</div>

@if(isset($errors))
<span class="help-block" style="margin-bottom: 0px;">
  @if($errors->get($field))
    @foreach($errors->get($field) as $error)
      {{$error}}
    @endforeach
  @else
    <?php $ul = false; ?>
    @foreach($errors->getMessages() as $key => $error)
      @if(preg_match("/$field\.\\d+/", $key))
        @if(!$ul)
          <ul>
          <?php $ul = true; ?>
        @endif
        <li>{{$error[0]}}</li>
      @endif
    @endforeach
    @if($ul)
      </ul>
    @endif
  @endif
</span>
@endif

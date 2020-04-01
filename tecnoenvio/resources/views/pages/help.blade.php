@set('buttonPadding', 20)
@set('user')
@set('toolbar')
@set('only')
@set('noTitle')
@extends('pages.blank')
@include('sections.translate')
@section('pageTitle', trans('messages.help'))
@section('title', trans('messages.register'))
@if(!isset($session) || $session == null)
  @section('toolbar-custom-pre')
    <li><a href="{{asset('/register')}}" id ="drdusr"><i class="fa fa-user" aria-hidden="true"></i> {{trans('messages.register')}}</a></li>
  @stop
@endif
@section('body')
<div class="row">
  <div class="col-md-10 col-md-offset-1">
    <div class="login-panel panel panel-default">
      <div class="panel-heading">
        <div class="text-center text-muted">
          <i class="fa fa-question-circle" aria-hidden="true"></i>
            {{trans('messages.help')}}
        </div>
      </div>
      <div class="panel-body">

        Ut a nisl id ante tempus hendrerit. In ut quam vitae odio lacinia tincidunt. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros. Phasellus consectetuer vestibulum elit. Curabitur at lacus ac velit ornare lobortis.

Donec venenatis vulputate lorem. Aenean imperdiet. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Donec venenatis vulputate lorem. Nunc nonummy metus.

Curabitur turpis. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. Quisque rutrum. Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo.

Nam commodo suscipit quam. Vestibulum dapibus nunc ac augue. Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Sed magna purus, fermentum eu, tincidunt eu, varius ut, felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.

Donec sodales sagittis magna. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Donec sodales sagittis magna. Sed aliquam ultrices mauris. Fusce vulputate eleifend sapien.

        Ut a nisl id ante tempus hendrerit. In ut quam vitae odio lacinia tincidunt. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros. Phasellus consectetuer vestibulum elit. Curabitur at lacus ac velit ornare lobortis.

Donec venenatis vulputate lorem. Aenean imperdiet. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Donec venenatis vulputate lorem. Nunc nonummy metus.

Curabitur turpis. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. Quisque rutrum. Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo.

Nam commodo suscipit quam. Vestibulum dapibus nunc ac augue. Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Sed magna purus, fermentum eu, tincidunt eu, varius ut, felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.

Donec sodales sagittis magna. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Donec sodales sagittis magna. Sed aliquam ultrices mauris. Fusce vulputate eleifend sapien.

        Ut a nisl id ante tempus hendrerit. In ut quam vitae odio lacinia tincidunt. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros. Phasellus consectetuer vestibulum elit. Curabitur at lacus ac velit ornare lobortis.

Donec venenatis vulputate lorem. Aenean imperdiet. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Donec venenatis vulputate lorem. Nunc nonummy metus.

Curabitur turpis. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. Quisque rutrum. Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo.

Nam commodo suscipit quam. Vestibulum dapibus nunc ac augue. Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Sed magna purus, fermentum eu, tincidunt eu, varius ut, felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.

Donec sodales sagittis magna. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Donec sodales sagittis magna. Sed aliquam ultrices mauris. Fusce vulputate eleifend sapien.

        Ut a nisl id ante tempus hendrerit. In ut quam vitae odio lacinia tincidunt. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros. Phasellus consectetuer vestibulum elit. Curabitur at lacus ac velit ornare lobortis.

Donec venenatis vulputate lorem. Aenean imperdiet. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Donec venenatis vulputate lorem. Nunc nonummy metus.

Curabitur turpis. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. Quisque rutrum. Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo.

Nam commodo suscipit quam. Vestibulum dapibus nunc ac augue. Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Sed magna purus, fermentum eu, tincidunt eu, varius ut, felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.

Donec sodales sagittis magna. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Donec sodales sagittis magna. Sed aliquam ultrices mauris. Fusce vulputate eleifend sapien.

        Ut a nisl id ante tempus hendrerit. In ut quam vitae odio lacinia tincidunt. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros. Phasellus consectetuer vestibulum elit. Curabitur at lacus ac velit ornare lobortis.

Donec venenatis vulputate lorem. Aenean imperdiet. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Donec venenatis vulputate lorem. Nunc nonummy metus.

Curabitur turpis. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. Quisque rutrum. Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo.

Nam commodo suscipit quam. Vestibulum dapibus nunc ac augue. Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Sed magna purus, fermentum eu, tincidunt eu, varius ut, felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.

Donec sodales sagittis magna. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Donec sodales sagittis magna. Sed aliquam ultrices mauris. Fusce vulputate eleifend sapien.

        Ut a nisl id ante tempus hendrerit. In ut quam vitae odio lacinia tincidunt. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros. Phasellus consectetuer vestibulum elit. Curabitur at lacus ac velit ornare lobortis.

Donec venenatis vulputate lorem. Aenean imperdiet. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Donec venenatis vulputate lorem. Nunc nonummy metus.

Curabitur turpis. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. Quisque rutrum. Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo.

Nam commodo suscipit quam. Vestibulum dapibus nunc ac augue. Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Sed magna purus, fermentum eu, tincidunt eu, varius ut, felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.

Donec sodales sagittis magna. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Donec sodales sagittis magna. Sed aliquam ultrices mauris. Fusce vulputate eleifend sapien.

        Ut a nisl id ante tempus hendrerit. In ut quam vitae odio lacinia tincidunt. Etiam sollicitudin, ipsum eu pulvinar rutrum, tellus ipsum laoreet sapien, quis venenatis ante odio sit amet eros. Phasellus consectetuer vestibulum elit. Curabitur at lacus ac velit ornare lobortis.

Donec venenatis vulputate lorem. Aenean imperdiet. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Donec venenatis vulputate lorem. Nunc nonummy metus.

Curabitur turpis. Vestibulum turpis sem, aliquet eget, lobortis pellentesque, rutrum eu, nisl. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. Quisque rutrum. Curabitur ligula sapien, tincidunt non, euismod vitae, posuere imperdiet, leo.

Nam commodo suscipit quam. Vestibulum dapibus nunc ac augue. Donec elit libero, sodales nec, volutpat a, suscipit non, turpis. Sed magna purus, fermentum eu, tincidunt eu, varius ut, felis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.

Donec sodales sagittis magna. Vestibulum purus quam, scelerisque ut, mollis sed, nonummy id, metus. Donec sodales sagittis magna. Sed aliquam ultrices mauris. Fusce vulputate eleifend sapien.

      </div>
    </div>
  </div>
</div>
@stop

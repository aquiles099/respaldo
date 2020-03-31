@if ($errors->has($field))
  has-error
@else
  <?php
    foreach($errors->getMessages() as $key => $error) {
       if(preg_match("/$field\.\\d+/", $key)) {
         echo "has-error";
         break;
       }
    }
  ?>
@endif

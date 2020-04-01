<?php

  /**
   * Dado un numero en base 10 retorna su equivalente en base 36
   */
  function toBase36($number = null, $pad = 4) {
    return sprintf("%0${pad}s", $number == null || !preg_match('/^\d+$/', $number)? '0' : strtoupper(base_convert($number , 10 , 36)));
  }

  /**
   * Dado un numero en base 36 retorna el numero en base 10
   */
  function toBase10($number = null, $pad = 4) {
    return sprintf("%0${pad}s", $number == null || !preg_match('/^[\da-zA-Z]+$/', $number)? '0' : strtoupper(base_convert($number , 36 , 10)));
  }

  /**
   *
   */
  function fill($data, $min = 10) {
    $fill = [];
    if(count($data) < $min)  {
      for($i = count($data); $i < $min; $i++) {
        $fill[] = true;
      }
    }
    return [$data, $fill];
  }

  /**
   *
   */
  function clear($data) {
    if(is_string($data)) {
      return clearString($data);
    }
    if(is_array($data)) {
        $return = [];
        foreach ($data as $key => $value) {
          $return[$key] = clear($value);
        }
        return $return;
    }
    return $data;
  }

  /**
   *
   */
  function clearString($text) {
    $text = preg_replace('/[\t\n\r\0\x0B]/', '', $text);
    $text = preg_replace('/([\s])\1+/', ' ', $text);
    $text = trim($text);
    return $text;
  }

  /**
   *
   */
  function getIds($values) {
    $return = [];
    try {
      if($values instanceof \Illuminate\Database\Eloquent\Relations\BelongsToMany) {
        foreach ($values->get()->toArray() as $value) {
          $return[] = isset($value['id']) ? $value['id'] : -1;
        }
      }
    } catch(\Exception $exception) {

    }
    return $return;
  }

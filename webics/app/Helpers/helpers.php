<?php
  /**
   * Dado un numero en base 10 retorna su equivalente en base 36
   */
  function toBase36 ($number = null, $pad = 4) {
    return sprintf("%0${pad}s", $number == null || !preg_match('/^\d+$/', $number)? '0' : strtoupper(base_convert($number , 10 , 36)));
  }
  /**
   * Dado un numero en base 36 retorna el numero en base 10
   */
  function toBase10 ($number = null, $pad = 4) {
    return sprintf("%0${pad}s", $number == null || !preg_match('/^[\da-zA-Z]+$/', $number)? '0' : strtoupper(base_convert($number , 36 , 10)));
  }
  /**
  * Resta dos numeros
  */
  function substract ($firstNumber, $secondNumber) {
    return ($firstNumber - $secondNumber);
  }
  /**
   * determina si un numero es cero [0]
   */
  function isZero ($value) {
    return ($value == 0 || $value == '0' || $value == "0");
  }
  /**
  * calcula el mayor de dos numeros [ a > b]
  */
  function isMajor ($firstNumber, $secondNumber) {
    return ($firstNumber > $secondNumber);
  }
  /**
  * @array: coleccion de permisos que posee el usuario
  * @access:
  */
  function hasAccess ($array, $access) {
    in_array($access, $array);
    return true;
  }

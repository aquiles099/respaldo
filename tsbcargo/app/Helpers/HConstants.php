<?php
  namespace App\Helpers;

  class HConstants {
    const EVENT_CERO	        = 0;
    const EVENT_INITIAL       = 1;
    /**
    *
    */
    const EVENT_RECEIVED      = 1;
    const EVENT_PROCESED      = 2;
    const EVENT_TRANSIT       = 3;
    const EVENT_ARRIVED       = 4;
    const EVENT_AVAILABLE     = 5;
    const EVENT_DELIVERED     = 6;
    /**
    *
    */
    const FIRST_CONFIGURATION = 1;
    /**
    *
    */
    const RESPONSE_NULL       = NULL;
    const RESPONSE_TRUE       = TRUE;
    /**
    * Tipos de Transportes
    */
    const TRANSPORT_MARITHIME = 1;
    const TRANSPORT_AERIAL    = 2;
    const TRANSPORT_GROUND    = 3;
  }

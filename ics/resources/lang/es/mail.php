<?php

return [
  'name'                  => '<b>NOMBRE: </b> :name',
  'last_name'             => '<b>APELLIDO: </b> :last_name',
  'user_code'             => '<b>CODIGO DE USUARIO: </b> :user_code',
  'package_code'          => '<b>CODIGO DE ENVIO: </b> :package_code',
  'package_type'          => '<b>TIPO DE CONTENIDO: </b> :package_type',
  'package_tracking'      => '<b>TRACKING: </b> :package_tracking',
  'booking_code'          => '<b>CODIGO DE RESERVA: </b> :booking_code',
  'booking_shipper'       => '<b>ENVIADO POR: </b> :shipperName :shipperLastName ',
  'shipper_last_name'     => '<b>ENVIADO POR: </b> :shipperLastName',
  'booking_to_country'    => '<b>PAIS DE ORIGEN: </b> :to_country',
  'booking_from_country'  => '<b>PAIS DESTINO: </b> :from_country',
  'departure_date'        => '<b>FECHA DE SALIDA: </b> :since_departure_date',
  'arrived_date'          => '<b>FECHA DE LLEGADA: </b> :since_arrived_date',
  'package_weight'        => '<b>PESO </b> :package_weight lbs',
  'package_value'         => '<b>VALOR DE PAQUETE </b> :package_value $',
  'package_destiny'       => '<b>DIRECION DESTINO </b> :package_destiny_country, :package_destiny_region, :package_destiny_city',
  'ics'                   => '<b><a href=":url">:company<a/></b>',
  'received'              => 'Saludos, :company le informa que a nuestra oficina ubicada en :office ha arrivado un paquete con los siguientes datos',
  'status'                => 'Saludos, :company notifica el estatus :event para su paquete, el cual tiene lo siguientes datos',
  'package_noinvoice'     => '<b>ATENCION:</b> Este paquete no cuenta con un invoice asociado, por favor, carguelo cuanto antes, saludos'
];

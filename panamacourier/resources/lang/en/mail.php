<?php

return [
  'name'                  => '<b>FIRST NAME: </b> :name',
  'last_name'             => '<b>LAST NAME: </b> :last_name',
  'user_code'             => '<b>USER CODE: </b> :user_code',
  'package_code'          => '<b>CODE SHIPPING: </b> :package_code',
  'package_type'          => '<b>TYPE OF CONTENT: </b> :package_type',
  'package_tracking'      => '<b>TRACKING: </b> :package_tracking',
  'booking_code'          => '<b>RESERVATION CODE: </b> :booking_code',
  'booking_shipper'       => '<b>SENT BY: </b> :shipperName :shipperLastName ',
  'shipper_last_name'     => '<b>SENT BY: </b> :shipperLastName',
  'booking_to_country'    => '<b>COUNTRY OF ORIGIN: </b> :to_country',
  'booking_from_country'  => '<b>DESTINATION COUNTRY: </b> :from_country',
  'departure_date'        => '<b>DEPARTURE DATE: </b> :since_departure_date',
  'arrived_date'          => '<b>ARRIVAL DATE: </b> :since_arrived_date',
  'package_weight'        => '<b>WEIGHT </b> :package_weight lbs',
  'package_value'         => '<b>PACKAGE VALUE </b> :package_value $',
  'package_destiny'       => '<b>ADDRESS DESTINATION </b> :package_destiny_country, :package_destiny_region, :package_destiny_city',
  'ics'                   => '<b><a href=":url">:company<a/></b>',
  'received'              => 'Regards, :company Informs you that our office has arrived a package with the following data',
  'status'                => 'Regards, :company notify you the status :event for your package, with te following information',
  'package_noinvoice'     => '<b>ATTENTION:</b> This package does not have an associated invoice, please download it as soon as possible, regards'
];

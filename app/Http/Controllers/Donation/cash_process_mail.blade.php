<?php
/**
 * Created by PhpStorm.
 * User: masroor
 * Date: 7/30/2019
 * Time: 11:41 AM
 */


?>

Date: {{$current_date}}
REF# {{$ref_no}}


Depot-In-Charge
Incepta Pharmaceuticals Ltd
{{$depot_name}} Depot
{{$depot_name}}


Dear Colleague,
You are requested to disburse Tk. {{$total_val_in_money}} ({{$total_val_in_words}}) only to {{$authorised_person}}, {{$auth_desig}}, {{$depot_name}} Depot,
on request of {{$sender_name}}, {{$sender_desig}}, Sales.

We have received this amount at Head Office as remittance.

Best regards,

{{ $mail_sender_name }}
{{ $mail_sender_desig }}
{!!$mail_sender_dept !!}
Incepta Pharmaceuticals Ltd
Mobile: {{ $mail_sender_mob }}Ext: {{ $mail_sender_ext }}





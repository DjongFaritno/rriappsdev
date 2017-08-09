<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function io_date_format($var,$format){

    if(trim($var)==''){

        $mydate = NULL;
    }
    else{

        $date   = date_create($var);
        $mydate = date_format($date,$format);
    }

    return $mydate;
}

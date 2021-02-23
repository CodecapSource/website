<?php

function normal_text($data)
{
    if (gettype($data) !== "array") {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
    return '';
}

function normal_text_back($text)
{
    if (gettype($text) !== "array") {
        return htmlspecialchars_decode(trim($text), ENT_QUOTES);
    }
    return '';
}

function normal_date($date, $format = 'M d, Y h:i A')
{
    $d = date_create($date);
    return date_format($d, $format);
}

function current_date($format = 'Y-m-d H:i:s')
{
    return date($format);
}

function normal_to_db_date($date, $format = 'Y-m-d H:i:s')
{
    $d = date_create($date);
    return date_format($d, $format);
}

function get_date_difference ($from, $to) { 
    $from = new DateTime(date("Y-m-d\TH:i:sP",  strtotime($from)));
    $to= new DateTime(date("Y-m-d\TH:i:sP",  strtotime($to)));

    $diff = $from->diff($to);
    $age = ['years' => $diff->y, 'months' => $diff->m, 'days' => $diff->d, 'hours' => $diff->h, 'minutes' => $diff->i, 'seconds' => $diff->s, 'positive' => $diff->invert === 1 ? true : false];
    
    return $age;
}

function get_ip()
{
    /* if share internet */
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    /* if proxy */
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    /* if remote address */
    else{  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;
}

function go ($URL)
{
    header("location: $URL");
    die();
}

function get_event_status_text ($event_status)
{
    if ($event_status === 'A') {
        return 'Active';
    }
    if ($event_status === 'D') {
        return 'Disabled';
    }
    if ($event_status === 'C') {
        return 'Completed';
    }
    return '';
}

function get_event_type_text ($event_type)
{
    if ($event_type === 'V') {
        return 'Online';
    }
    if ($event_type === 'P') {
        return 'Onsite';
    }
    return '';
}

function generate_random_string($length = 10)
{
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}

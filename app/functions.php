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

function current_date($format = 'M d, Y h:i A')
{
    return date($format);
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

<?php 
require_once 'Session.php';
 
function old($key, $default = null)
{
    return Session::instance()->old($key, $default);
}
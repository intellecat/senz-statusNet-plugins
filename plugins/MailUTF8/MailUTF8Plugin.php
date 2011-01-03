<?php
if (!defined('STATUSNET')) {
    exit(1);
}

class MailUTF8Plugin extends Plugin
{
    function onAutoload($cls)
    {
        $dir = dirname(__FILE__);
        switch ($cls)
        {
            case 'Mail_utf8':
                include_once $dir . '/'.$cls.'.php';
                return false;
            default:
                return true;
        }
    }
}
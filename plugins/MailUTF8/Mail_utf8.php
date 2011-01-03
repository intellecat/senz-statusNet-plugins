<?php
require_once INSTALLDIR.'/extlib/Mail/mail.php';

class Mail_utf8 extends Mail_mail
{
    function send($recipients, $headers, $body)
    {
        if (!is_array($headers)) {
            return PEAR::raiseError('$headers must be an array');
        }
        foreach ($headers as $key => $value) {
            if(in_array($key,array('To','Subject')))
                $headers[$key] = Mail_UTF8::specifyUTF8($value);
        }
        parent::send($recipients, $headers, $body);
    }
    
    static function specifyUTF8($string){
        return "=?UTF-8?B?" . base64_encode($string) . '?=';
    }
    
}
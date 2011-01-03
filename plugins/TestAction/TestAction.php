<?php

if (!defined('STATUSNET') && !defined('LACONICA')) {
    exit(1);
}

function showConfig()
{
    global $config;
    return $config;
}

class TestAction extends Action
{
    function handle($args)
    {
        parent::handle($args);
        $this->showPage();
    }
    
    function showContent()
    {
        //$this->raw(var_dump(showConfig()));
        //$this->raw(common_config('design','optional'));
        
        //$this->user = User::staticGet('nickname', 'chuck911');
        //if (!(common_config('site','closed') || common_config('site','inviteonly'))) {
        //    $m = sprintf(_('**%s** has an account on %%%%site.name%%%%, a [micro-blogging](http://en.wikipedia.org/wiki/Micro-blogging) service ' .
        //                   'based on the Free Software [StatusNet](http://www.status.net/) tool. ' .
        //                   '[Join now](%%%%action.register%%%%) to follow **%s**\'s notices and many more! ([Read more](%%%%doc.help%%%%))'),
        //                 $this->user->nickname, $this->user->nickname);
        //} else {
        //    $m = sprintf(_('**%s** has an account on %%%%site.name%%%%, a [micro-blogging](http://en.wikipedia.org/wiki/Micro-blogging) service ' .
        //                   'based on the Free Software [StatusNet](http://www.status.net/) tool. '),
        //                 $this->user->nickname, $this->user->nickname);
        //}
        //$this->raw(common_markup_to_html($m));
        
        //$googl = new goo_gl('http://ioio.name/page/6?auth=0');
        //echo $googl->result();
        //$recipients = 'cat@birdbird.net';
        //$headers['From']    = mail_notify_from() . ' <noreply@t.1place.cn> ';
        //$headers['To']      = '鸟鸟' . ' < cat@birdbird.net >';
        //$headers['Subject'] =  '鸟鸟你好';
        //$body = 'just 4 test,好了吗';
        //common_log(7,'???????');
        //print_r( mail_notify_from());
        //print_r(mail_send($recipients, $headers, $body));
        
        $body = sprintf(_("Hey, %1\$s.\n\n".
            "Someone just entered this email address on %2\$s.\n\n" .
            "If it was you, and you want to confirm your entry, ".
            "use the URL below:\n\n\t%3\$s\n\n" .
            "If not, just ignore this message.\n\n".
            "Thanks for your time, \n%2\$s\n"),
          'chuck911',
          common_config('site', 'name'),
          common_local_url('confirmaddress', array('code' => '123')));
        $this->raw($body);
    }
    
    function title()
    {
        return 'Test';
    }
}
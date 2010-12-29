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
        

            $m = _('Registration');

        //$this->elementStart('div', array('id' => 'anon_notice'));
        //$this->raw(common_markup_to_html($m));
        $this->raw(_m('MENU', 'Register'));
        
    }
    
    function title()
    {
        return 'Test';
    }
}
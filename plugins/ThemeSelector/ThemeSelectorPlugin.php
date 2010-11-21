<?php
if (!defined('STATUSNET')) {
    exit(1);
}

class ThemeSelectorPlugin extends Plugin
{    
    function onStartAccountSettingsDesignMenuItem($nav)
    {
	$title = _('Design your profile');
	$nav->showMenuItem('userdesignsettings2',_('Design'),$title);
	return false;
    }
    
    function onAutoload($cls)
    {
	$dir = dirname(__FILE__);
	switch ($cls)
	{
		case 'Userdesignsettings2Action':
		include_once $dir . '/'.$cls.'.php';
	    return false;
		default:
		return true;
	}
    }

    function onRouterInitialized($m)
    {//return;
        $m->connect('settings/userdesign',
                    array('action' => 'userdesignsettings2'));
    }
}
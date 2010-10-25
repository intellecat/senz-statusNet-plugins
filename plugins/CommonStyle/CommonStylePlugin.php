<?php
/**
 * MyTest Plugin
 *
 * @category Plugin
 * @package  Statusnet
 * @author   chuck911
 * @license  http://www.fsf.org/licensing/licenses/agpl-3.0.html GNU Affero General Public License version 3.0
 * @version  CommonStylePlugin.php,v 0.1
 *
 */

if (!defined('STATUSNET')) {
    exit(1);
}

class CommonStylePlugin extends Plugin
{
	// function onStartShowFooter($action)
	//     {
	//         //return false;
	//     }

	public function onStartShowSections($action)
	{
		if(!property_exists($action,'user'))return true;
		$briefStats = new BriefStats($action,$action->user);
		$briefStats->show();
	}
	
	function onAutoload($cls)
    {
        $dir = dirname(__FILE__);

        switch ($cls)
        {
        	case 'BriefStats':
            	include_once $dir . '/'.$cls.'.php';
            return false;
        	default:
            	return true;
        }
    }
}
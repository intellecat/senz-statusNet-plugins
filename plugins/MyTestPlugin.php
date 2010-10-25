<?php
/**
 * MyTest Plugin
 *
 * @category Plugin
 * @package  Statusnet
 * @author   chuck911
 * @license  http://www.fsf.org/licensing/licenses/agpl-3.0.html GNU Affero General Public License version 3.0
 * @version  MyTestPlugin.php,v 0.1
 *
 */

if (!defined('STATUSNET')) {
    exit(1);
}

class MyTestPlugin extends Plugin
{
	function onStartShowFooter($action)
    {
		//common_log(7,'footer deleted');
        //return false;
    }

	function onStartShowLocalNavBlock($action)
	{
		//return false;
	}
	
	function onStartShowExportData($action)
	{
		return false;
	}
	
	function onStartShowBody($action)
	{
		$this->showBody($action);
		return false;
	}
	
	function showBody($action)
    {
        $action->elementStart('body', (common_current_user()) ? array('id' => $action->trimmed('action'),
                                                                    'class' => 'user_in')
                            : array('id' => $action->trimmed('action')));
        $action->elementStart('div', array('id' => 'wrap'));
        if (Event::handle('StartShowHeader', array($action))) {
            $action->showHeader();
            Event::handle('EndShowHeader', array($action));
        }
        $this->showCore($action);
        if (Event::handle('StartShowFooter', array($action))) {
            $action->showFooter();
            Event::handle('EndShowFooter', array($action));
        }
        $action->elementEnd('div');
        $action->showScripts();
        $action->elementEnd('body');
    }

	function showCore($action)
	{
		$action->elementStart('div', array('id' => 'core'));
		
		if (Event::handle('StartShowContentBlock', array($action))) {
            $action->showContentBlock();
            Event::handle('EndShowContentBlock', array($action));
        }
		
        if (Event::handle('StartShowLocalNavBlock', array($action))) {
            $action->showLocalNavBlock();
            Event::handle('EndShowLocalNavBlock', array($action));
        }
		if (Event::handle('StartShowAside', array($action))) {
            $action->showAside();
            Event::handle('EndShowAside', array($action));
        }
               
        $action->elementEnd('div');
	}
}
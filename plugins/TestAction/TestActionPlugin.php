<?php
/**
 * TestAction Plugin
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

class TestActionPlugin extends Plugin
{
    function onRouterInitialized($m)
    {
        $m->connect('test/test',
                    array('action' => 'test'));

        return true;
    }
    
    function onAutoload($cls)
    {
        $dir = dirname(__FILE__);

        switch ($cls)
        {
        case 'TestAction':
            include_once $dir . '/'.$cls.'.php';
            return false;
        default:
            return true;
        }
    }
}
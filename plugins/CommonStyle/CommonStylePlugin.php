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
	
	function onEndShowDesign($action)
	{
	    $user = common_current_user();

	    if (empty($user) || $user->viewdesigns) {
		$design = $action->getDesign();

		if (!empty($design)) {
		    $css = '';
		    //$design->showCSS($this);
		    //$css .= '#aside_primary { background-color: #'. $sbcolor->hexValue() . ' }' . "\n";
		    $sbcolor = Design::toWebColor($design->sidebarcolor);
		    if (!empty($sbcolor)) {
			$css = '#site_nav_local_views,#brief_stats_container { background-color: #'. $sbcolor->hexValue() . ' }' . "\n";
		    }
		    if (0 != mb_strlen($css)) {
			$action->style($css);
		    }
		}
	    }
	}
	
	function onStartShowInnerContent($action){
	    if(!$action->trimmed('action')=='userdesignsettings') return true;
	    $design = $action->getWorkingDesign();
	
	    if (empty($design)) {
		$design = Design::siteDesign();
	    }
	    $this->showThemeSelections($action);
	    $action->showDesignForm($design);
	    return false;
	}
	
	function showThemeSelections($action)
	{
	    $action->elementStart('div',array('id'=>'theme_selections'));
	    $action->elementStart('h3');
	    $action->text(_('select a theme'));
	    $action->elementEnd('h3');
	    $action->elementStart('div',array('id'=>'themes'));
	    for($i=1;$i<=16;$i++)
	    {
		$action->elementStart('a',array('title'=>"Theme {$i}",'id'=>"Theme{$i}",'href'=>'#'));
		$action->element('img',array('src'=>"http://static.leihou.com/v319001/images/themes/swatch-{$i}.gif",'alt'=>"Theme $i"));
		$action->elementEnd('a');
	    }

	    $action->elementEnd('div');
	    $action->elementEnd('div');
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
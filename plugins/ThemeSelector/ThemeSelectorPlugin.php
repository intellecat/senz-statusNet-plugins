<?php
if (!defined('STATUSNET')) {
    exit(1);
}

class ThemeSelectorPlugin extends Plugin
{
    function onStartShowInnerContent($action){
	    if($action->trimmed('action')!='userdesignsettings') return true;
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
            $action->elementStart('a',array('title'=>"Theme {$i}",'id'=>"Theme{$i}",'href'=>'#','class'=>'theme'));
            $action->element('img',array('src'=>"http://static.leihou.com/v319001/images/themes/swatch-{$i}.gif",'alt'=>"Theme $i"));
            $action->elementEnd('a');
        }

        $action->elementEnd('div');
        $action->elementEnd('div');
    }
    
    function onEndShowScripts($action)
    {
        $action->script('local/plugins/ThemeSelector/ThemeSelector.js');
    }
}
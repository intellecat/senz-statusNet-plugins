<?php
if (!defined('STATUSNET')) {
    exit(1);
}

class CustomEventPlugin extends Plugin
{
    function onStartShowContentBlock($action){
        $actionNames = array("public","showstream");
        if(!in_array($action->trimmed('action'),$actionNames))return true;
        
        $action->elementStart('div', array('id' => 'content'));
        if (Event::handle('StartShowPageTitle', array($action))) {
            $action->showPageTitle();
            Event::handle('EndShowPageTitle', array($action));
        }
        $action->showPageNoticeBlock();
        $action->elementStart('div', array('id' => 'content_inner'));
        // show the actual content (forms, lists, whatever)
        if (Event::handle('StartShowContent', array($action))) {
            $action->showContent();
            Event::handle('EndShowContent', array($action));
        }
        $action->elementEnd('div');
        $action->elementEnd('div');
        return false;
    }
    
//    function onStartShowContent($action){
//    }
}
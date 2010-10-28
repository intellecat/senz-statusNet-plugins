<?php
if (!defined('STATUSNET')) {
    exit(1);
}

class NoticesBottomAdPlugin extends Plugin
{
    function onStartShowContentBlock($action){
        if($action->trimmed('action')!="public")return true;
        
        $action->elementStart('div', array('id' => 'content'));
        if (Event::handle('StartShowPageTitle', array($action))) {
            $action->showPageTitle();
            Event::handle('EndShowPageTitle', array($action));
        }
        $action->showPageNoticeBlock();
        $action->elementStart('div', array('id' => 'content_inner'));
        // show the actual content (forms, lists, whatever)
        $this->showContent($action);
        $action->elementEnd('div');
        $action->elementEnd('div');
        return false;
    }
    
    function showContent($action){
        $nl = new NoticeList($action->notice, $action);

        $cnt = $nl->show();

        if ($cnt == 0) {
            $action->showEmptyList();
        }
        $this->showAd($action);
        $action->pagination($action->page > 1, $cnt > NOTICES_PER_PAGE,
                          $action->page, 'public');
    }
    
    function showAd($action){
        $action->raw('<img border="0" src="http://eiv.baidu.com/uapimg/vancl/220x60.gif">');
        //$action->inlineScript("var cpro_id = 'u172659';");
        //$action->script("http://cpro.baidu.com/cpro/ui/c.js");
    }
}
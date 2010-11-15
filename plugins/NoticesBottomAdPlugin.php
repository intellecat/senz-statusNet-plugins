<?php
if (!defined('STATUSNET')) {
    exit(1);
}

//require StartShowContent Event
class NoticesBottomAdPlugin extends Plugin
{   
    function onStartShowInnerContent($action){
        if( in_array($action->trimmed('action'),array('public','showstream')))
            return true;
        $this->showContent($action);
        return false;
    }
    
    function showContent($action){
        switch($action->trimmed('action'))
        {
            case 'public':
                $this->publicContent($action);
                break;
            case 'showstream':
                $this->showstreamContent($action);
                break;
        }
    }
    
    function publicContent($action)
    {
        $nl = new NoticeList($action->notice, $action);

        $cnt = $nl->show();

        if ($cnt == 0) {
            $action->showEmptyList();
        }
        $this->showAd($action);
        $action->pagination($action->page > 1, $cnt > NOTICES_PER_PAGE,
                          $action->page, 'public');
    }
    
    function showstreamContent($action)
    {
        $action->showProfile();
        $this->showstreamNotices($action);
    }
    
    function showstreamNotices($action)
    {
        $notice = empty($action->tag)
          ? $action->user->getNotices(($action->page-1)*NOTICES_PER_PAGE, NOTICES_PER_PAGE + 1)
            : $action->user->getTaggedNotices($action->tag, ($action->page-1)*NOTICES_PER_PAGE, NOTICES_PER_PAGE + 1, 0, 0, null);

        $pnl = new ProfileNoticeList($notice, $action);
        $cnt = $pnl->show();
        if (0 == $cnt) {
            $action->showEmptyListMessage();
        }

        $args = array('nickname' => $action->user->nickname);
        if (!empty($action->tag))
        {
            $args['tag'] = $action->tag;
        }
        $action->elementStart('div',array('style'=>'float:left;'));
        $this->showAd($action);
        $action->elementEnd('div');
        $action->pagination($action->page>1, $cnt>NOTICES_PER_PAGE, $action->page,
                          'showstream', $args);
        
    }
    
    function showAd($action){
        $action->raw('<img border="0" src="http://eiv.baidu.com/uapimg/vancl/220x60.gif">');
        //$action->inlineScript("var cpro_id = 'u172659';");
        //$action->script("http://cpro.baidu.com/cpro/ui/c.js");
    }
}
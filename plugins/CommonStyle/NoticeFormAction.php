<?php

if (!defined('STATUSNET') && !defined('LACONICA')) {
    exit(1);
}

class NoticeFormAction extends Action
{
    function showPage()
    {
        if (Event::handle('StartShowBody', array($this))) {
            $this->showCore();
            Event::handle('EndShowBody', array($this));
        }
    }

    function handle($args)
    {
        $this->showPage();
    }

    function showCore()
    {
        $this->elementStart('div', array('id' => 'core'));
        if (Event::handle('StartShowContentBlock', array($this))) {
            $this->showContentBlock();
            Event::handle('EndShowContentBlock', array($this));
        }
        $this->elementEnd('div');
    }
    
    function showContent()
    {
        $notice_form = new NoticeForm($this, '');
        $notice_form->show();
    }
}
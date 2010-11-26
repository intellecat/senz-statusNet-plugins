<?php

if (!defined('STATUSNET') && !defined('LACONICA')) {
    exit(1);
}

function showConfig()
{
    global $config;
    return $config;
}

class TestAction extends Action
{
    function handle($args)
    {
        parent::handle($args);
        $this->showPage();
    }
    
    function showContent()
    {
        //$this->raw(var_dump(showConfig()));
        $this->raw(common_config('design','optional'));
        
    }
    
    function title()
    {
        return 'Test';
    }
}
<?php
if (!defined('STATUSNET') && !defined('LACONICA')) {
    exit(1);
}

class BaiduAdIframePlugin extends UAPPlugin
{
    public $adScript = 'http://cpro.baidu.com/cpro/ui/c.js';
    public $client   = null;

	function __construct()
	{
		parent::initialize();
	}
	
    /**
     * Show a medium rectangle 'ad'
     *
     * @param Action $action Action being shown
     *
     * @return void
     */

    protected function showMediumRectangle($action)
    {
        $this->showAdsenseCode($action);
    }

    /**
     * Show a rectangle 'ad'
     *
     * @param Action $action Action being shown
     *
     * @return void
     */

    protected function showRectangle($action)
    {
        $this->showAdsenseCode($action);
    }

    /**
     * Show a wide skyscraper ad
     *
     * @param Action $action Action being shown
     *
     * @return void
     */

    protected function showWideSkyscraper($action)
    {
        $this->showAdsenseCode($action);
    }

    /**
     * Show a leaderboard ad
     *
     * @param Action $action Action being shown
     *
     * @return void
     */

    protected function showLeaderboard($action)
    {
        $this->showAdsenseCode($action);
    }

    /**
     * Output the bits of JavaScript code to show Adsense
     *
     * @param Action  $action Action being shown
     * @param integer $width  Width of the block
     * @param integer $height Height of the block
     * @param string  $slot   Slot identifier
     *
     * @return void
     */

	protected function showAdsenseCode($action)
    {
		// var cpro_id = 'u172659';
        $code  = "var cpro_id = '{$this->client}';";

        $action->inlineScript($code);
        $action->script($this->adScript);
    }
}

<?php
if (!defined('STATUSNET') && !defined('LACONICA')) {
    exit(1);
}


class BriefStats extends Widget
{
	var $user;
	var $profile;
	
	function __construct($out,$user,$profile=null)
	{
		parent::__construct($out);
		if(!$profile) $profile = $user->getProfile();
		$this->user = $user;
		$this->profile = $profile;
	}
	
	public function show()
	{
		$avatar = $this->profile->getAvatar(AVATAR_MINI_SIZE);
		$subs_count   = $this->profile->subscriptionCount();
		$subbed_count = $this->profile->subscriberCount();
        $notice_count = $this->profile->noticeCount();
		
		$this->out->elementStart('div', array('id' => 'brief_stats_container',
                                              'class' => 'section'));
		$this->out->elementStart('h2',array('id'=>'brief_stats_title'));
		$this->out->element('img', array('src' => ($avatar) ? $avatar->displayUrl() : Avatar::defaultImage(AVATAR_MINI_SIZE),
                                    // 'class' => 'photo avatar',
                                    'width' => AVATAR_MINI_SIZE,
                                    'height' => AVATAR_MINI_SIZE,
                                    'alt' => $this->profile->nickname));
		$this->out->text($this->profile->nickname);
		$this->out->elementEnd('h2');
		$this->out->elementStart('ul',array('id' => 'brief_stats'));
		
		$this->out->elementStart('li', 'subscriptions');
		$this->out->elementStart('a', array('href' => common_local_url('subscriptions',
			array('nickname' => $this->profile->nickname))));
		$this->out->element('span', array('class' => 'stats_count'), $subs_count);
		$this->out->element('span', array('class' => 'stats_label'), _('Subscriptions'));
		$this->out->elementEnd('a');
		$this->out->elementEnd('li');
		
		$this->out->elementStart('li', 'subscribers');
		$this->out->elementStart('a', array('href' => common_local_url('subscribers',
			array('nickname' => $this->profile->nickname))));
		$this->out->element('span', array('class' => 'stats_count'), $subbed_count);
		$this->out->element('span', array('class' => 'stats_label'), _('Subscribers'));
		$this->out->elementEnd('a');
		$this->out->elementEnd('li');
		
		$this->out->elementStart('li', 'notices');
		$this->out->elementStart('a', array('href' => common_local_url('all',
			array('nickname' => $this->profile->nickname))));
		$this->out->element('span', array('class' => 'stats_count'), $notice_count);
		$this->out->element('span', array('class' => 'stats_label'), _('Notices'));
		$this->out->elementEnd('a');
		$this->out->elementEnd('li');

		$this->out->elementEnd('ul');
		$this->out->elementEnd('div');
	}
}



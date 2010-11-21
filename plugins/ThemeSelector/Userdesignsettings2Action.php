<?php

if (!defined('STATUSNET') && !defined('LACONICA')) {
    exit(1);
}

class UserDesignSettings2Action extends UserDesignSettingsAction
{
    function prepare($args)
    {
        parent::prepare($args);
        $this->submitaction = common_local_url('userdesignsettings2');
        return true;
    }
    
    function showContent()
    {
        $design = $this->getWorkingDesign();

        if (empty($design)) {
            $design = Design::siteDesign();
        }
        $this->showThemeSelections();
        $this->showDesignForm($design);
    }
    
    function showThemeSelections()
    {
        $this->elementStart('div',array('id'=>'theme_selections'));
        $this->elementStart('h3');
        $this->text(_('select a theme'));
        $this->elementEnd('h3');
        $this->elementStart('div',array('id'=>'themes'));
        for($i=1;$i<=16;$i++)
        {
            $this->elementStart('a',array('title'=>"Theme {$i}",'id'=>"Theme{$i}",'href'=>'#','class'=>'theme'));
            $this->element('img',array('src'=>"http://static.leihou.com/v319001/images/themes/swatch-{$i}.gif",'alt'=>"Theme $i"));
            $this->elementEnd('a');
        }

        $this->elementEnd('div');
        $this->elementEnd('div');
    }

    function saveDesign()
    {
        $selectedThemeID = $this->args['selected_theme_id'];
        $modefied = $this->args['modefied'] == 'true';
        
        if($selectedThemeID!='0' && !$modefied) {
            $this->showForm(_('Design preferences saved.'), true);
            return;
        }
        
        if($selectedThemeID!='0' && $modefied) {
            $this->showForm(_('Design preferences saved.'), true);
            return;
        }

        try {
            $bgcolor = new WebColor($this->trimmed('design_background'));
            $ccolor  = new WebColor($this->trimmed('design_content'));
            $sbcolor = new WebColor($this->trimmed('design_sidebar'));
            $tcolor  = new WebColor($this->trimmed('design_text'));
            $lcolor  = new WebColor($this->trimmed('design_links'));
        } catch (WebColorException $e) {
            $this->showForm($e->getMessage());
            return;
        }

        $onoff = $this->arg('design_background-image_onoff');

        $on   = false;
        $off  = false;
        $tile = false;

        if ($onoff == 'on') {
            $on = true;
        } else {
            $off = true;
        }

        $repeat = $this->boolean('design_background-image_repeat');

        if ($repeat) {
            $tile = true;
        }

        $user   = common_current_user();
        $design = $user->getDesign();

        if (!empty($design)) {

            $original = clone($design);

            $design->backgroundcolor = $bgcolor->intValue();
            $design->contentcolor    = $ccolor->intValue();
            $design->sidebarcolor    = $sbcolor->intValue();
            $design->textcolor       = $tcolor->intValue();
            $design->linkcolor       = $lcolor->intValue();

            $design->setDisposition($on, $off, $tile);

            $result = $design->update($original);

            if ($result === false) {
                common_log_db_error($design, 'UPDATE', __FILE__);
                $this->showForm(_('Couldn\'t update your design.'));
                return;
            }

            // update design
        } else {

            $user->query('BEGIN');

            // save new design
            $design = new Design();

            $design->backgroundcolor = $bgcolor->intValue();
            $design->contentcolor    = $ccolor->intValue();
            $design->sidebarcolor    = $sbcolor->intValue();
            $design->textcolor       = $tcolor->intValue();
            $design->linkcolor       = $lcolor->intValue();

            $design->setDisposition($on, $off, $tile);

            $id = $design->insert();

            if (empty($id)) {
                common_log_db_error($id, 'INSERT', __FILE__);
                $this->showForm(_('Unable to save your design settings.'));
                return;
            }

            $original        = clone($user);
            $user->design_id = $id;
            $result          = $user->update($original);

            if (empty($result)) {
                common_log_db_error($original, 'UPDATE', __FILE__);
                $this->showForm(_('Unable to save your design settings.'));
                $user->query('ROLLBACK');
                return;
            }

            $user->query('COMMIT');

        }

        $this->saveBackgroundImage($design);

        $this->showForm(_('Design preferences saved.'), true);
    }
    
    function showScripts()
    {
        AccountSettingsAction::showScripts();

        $this->script('farbtastic/farbtastic.js');
        //$this->script('userdesign.go.js');

        //$this->autofocus('design_background-image_file');
        $this->script('local/plugins/ThemeSelector/userdesign2.go.js');
    }
    
    function showDesignForm($design)
    {

        $this->elementStart('form', array('method' => 'post',
                                          'enctype' => 'multipart/form-data',
                                          'id' => 'form_settings_design',
                                          'class' => 'form_settings',
                                          'action' => $this->submitaction));
        $this->elementStart('fieldset');
        $this->hidden('token', common_session_token());
//begin add
        $this->hidden('selected_theme_id','0');
        $this->hidden('modefied','false');
//end add
        $this->elementStart('fieldset', array('id' =>
            'settings_design_background-image'));
        $this->element('legend', null, _('Change background image'));
        $this->elementStart('ul', 'form_data');
        $this->elementStart('li');
        $this->element('label', array('for' => 'design_background-image_file'),
                                _('Upload file'));
        $this->element('input', array('name' => 'design_background-image_file',
                                      'type' => 'file',
                                      'id' => 'design_background-image_file'));
        $this->element('p', 'form_guide', _('You can upload your personal ' .
            'background image. The maximum file size is 2MB.'));
        $this->element('input', array('name' => 'MAX_FILE_SIZE',
                                      'type' => 'hidden',
                                      'id' => 'MAX_FILE_SIZE',
                                      'value' => ImageFile::maxFileSizeInt()));
        $this->elementEnd('li');

        if (!empty($design->backgroundimage)) {

            $this->elementStart('li', array('id' =>
                'design_background-image_onoff'));

            $this->element('img', array('src' =>
                Design::url($design->backgroundimage)));

            $attrs = array('name' => 'design_background-image_onoff',
                           'type' => 'radio',
                           'id' => 'design_background-image_on',
                           'class' => 'radio',
                           'value' => 'on');

            if ($design->disposition & BACKGROUND_ON) {
                $attrs['checked'] = 'checked';
            }

            $this->element('input', $attrs);

            $this->element('label', array('for' => 'design_background-image_on',
                                          'class' => 'radio'),
                                          _('On'));

            $attrs = array('name' => 'design_background-image_onoff',
                           'type' => 'radio',
                           'id' => 'design_background-image_off',
                           'class' => 'radio',
                           'value' => 'off');

            if ($design->disposition & BACKGROUND_OFF) {
                $attrs['checked'] = 'checked';
            }

            $this->element('input', $attrs);

            $this->element('label', array('for' => 'design_background-image_off',
                                          'class' => 'radio'),
                                          _('Off'));
            $this->element('p', 'form_guide', _('Turn background image on or off.'));
            $this->elementEnd('li');

            $this->elementStart('li');
            $this->checkbox('design_background-image_repeat',
                            _('Tile background image'),
                            ($design->disposition & BACKGROUND_TILE) ? true : false);
            $this->elementEnd('li');
        }

        $this->elementEnd('ul');
        $this->elementEnd('fieldset');

        $this->elementStart('fieldset', array('id' => 'settings_design_color'));
        $this->element('legend', null, _('Change colours'));
        $this->elementStart('ul', 'form_data');

        try {

            $bgcolor = new WebColor($design->backgroundcolor);

            $this->elementStart('li');
            $this->element('label', array('for' => 'swatch-1'), _('Background'));
            $this->element('input', array('name' => 'design_background',
                                          'type' => 'text',
                                          'id' => 'swatch-1',
                                          'class' => 'swatch',
                                          'maxlength' => '7',
                                          'size' => '7',
                                          'value' => ''));
            $this->elementEnd('li');

            $ccolor = new WebColor($design->contentcolor);

            $this->elementStart('li');
            $this->element('label', array('for' => 'swatch-2'), _('Content'));
            $this->element('input', array('name' => 'design_content',
                                          'type' => 'text',
                                          'id' => 'swatch-2',
                                          'class' => 'swatch',
                                          'maxlength' => '7',
                                          'size' => '7',
                                          'value' => ''));
            $this->elementEnd('li');

            $sbcolor = new WebColor($design->sidebarcolor);

            $this->elementStart('li');
            $this->element('label', array('for' => 'swatch-3'), _('Sidebar'));
            $this->element('input', array('name' => 'design_sidebar',
                                        'type' => 'text',
                                        'id' => 'swatch-3',
                                        'class' => 'swatch',
                                        'maxlength' => '7',
                                        'size' => '7',
                                        'value' => ''));
            $this->elementEnd('li');

            $tcolor = new WebColor($design->textcolor);

            $this->elementStart('li');
            $this->element('label', array('for' => 'swatch-4'), _('Text'));
            $this->element('input', array('name' => 'design_text',
                                        'type' => 'text',
                                        'id' => 'swatch-4',
                                        'class' => 'swatch',
                                        'maxlength' => '7',
                                        'size' => '7',
                                        'value' => ''));
            $this->elementEnd('li');

            $lcolor = new WebColor($design->linkcolor);

            $this->elementStart('li');
            $this->element('label', array('for' => 'swatch-5'), _('Links'));
            $this->element('input', array('name' => 'design_links',
                                         'type' => 'text',
                                         'id' => 'swatch-5',
                                         'class' => 'swatch',
                                         'maxlength' => '7',
                                         'size' => '7',
                                         'value' => ''));
            $this->elementEnd('li');

        } catch (WebColorException $e) {
            common_log(LOG_ERR, 'Bad color values in design ID: ' .$design->id);
        }

        $this->elementEnd('ul');
        $this->elementEnd('fieldset');

        $this->submit('defaults', _('Use defaults'), 'submit form_action-default',
            'defaults', _('Restore default designs'));

        $this->element('input', array('id' => 'settings_design_reset',
                                     'type' => 'reset',
                                     'value' => 'Reset',
                                     'class' => 'submit form_action-primary',
                                     'title' => _('Reset back to default')));

        $this->submit('save', _('Save'), 'submit form_action-secondary',
            'save', _('Save design'));

        $this->elementEnd('fieldset');
        $this->elementEnd('form');
    }
}
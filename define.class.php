<?php
/**
 * @package    profilefield_json
 * @copyright  Copyright 2023 onwards Kelson da Costa Medeiros {@link https://github.com/kelsoncm}
 * @license    https://opensource.org/license/mit/ The MIT License (MIT)
 */

class profile_define_json extends profile_define_base {
    public function define_form_specific($form) {
        // Default data.
        $form->addElement('text', 'defaultdata', get_string('profiledefaultdata', 'admin'));
        $form->setType('defaultdata', PARAM_TEXT);
    }
}
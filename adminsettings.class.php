<?php

// This file is part of the EQUELLA Moodle Integration - https://github.com/equella/moodle-module
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

require_once($CFG->libdir.'/adminlib.php');

class admin_setting_openlink extends admin_setting {
    public function write_setting($data) {
    // do not write any setting
        return '';
    }
    public function get_setting() {
        return true;
    }
    public function output_html($data, $query='') {
        global $CFG;
        $redirect_url = equella_rest_api::get_redirect_url();
        $options = array('client_id'=>$CFG->equella_oauth_client_id, 'redirect_uri'=>$redirect_url->out(), 'endpoint'=>equella_rest_api::get_end_point(), 'response_type'=>'code');
        $url = equella_rest_api::get_auth_code_url($options);
        return format_admin_setting($this, $this->visiblename, '<a href="javascript:window.open(\'' . $url . '\')">Open the link to obtain access token</a>', $this->description, true);
    }
}

class admin_setting_text extends admin_setting {
    public function write_setting($data) {
    // do not write any setting
        return '';
    }
    public function get_setting() {
        return true;
    }
    public function output_html($data, $query='') {
        global $CFG;
        return format_admin_setting($this, $this->visiblename, 'Access token set', $this->description, true);
    }

}

/**
 * Provides some custom settings classes for the manage_users global settings
 * page
 *
 * @author Michael Avelar <michaela@moodlerooms.com>
 * @version $Id: adminsettings.class.php,v 1.1 2010/03/05 03:40:02 dev Exp $
 **/
class equella_setting_left_heading extends admin_setting {
    /**
     * not a setting, just text
     * @param string $name of setting
     * @param string $heading heading
     * @param string $information text in box
     */
	public function __construct($name, $heading, $information) {
		$this->nosave = true;
		parent::__construct($name, $heading, $information, '');
	}

    function get_setting() {
        return true;
    }

    function get_defaultsetting() {
        return true;
    }

    function write_setting($data) {
        // do not write any setting
        return '';
    }

    function output_html($data, $query='') {
    	global $OUTPUT;
        $return = '';
        if ($this->visiblename != '') {
            $return .= $OUTPUT->heading($this->visiblename, 3, '', true);
        }
        if ($this->description != '') {
        	$return .= $OUTPUT->box(highlight($query, markdown_to_html($this->description)), 'generalbox formsettingheading', '', true);
        }
        return $return;
    }
}

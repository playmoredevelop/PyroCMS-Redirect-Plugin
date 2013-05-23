<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Redirect Plugin
 *
 * Redirect with status code.
 *
 * @author  	Playmore Dev
 * @package		PyroCMS\Addon\Plugins
 * @copyright	Copyright (c) 2013 Playmore
 */
class Plugin_Redirect extends Plugin {

    public $version = '1.0.0';
    public $name = array(
	'en' => 'Redirects',
	'ru' => 'Редиректы'
    );
    public $description = array(
	'en' => 'Redirects with status code',
	'ru' => 'Редиректы с кодом перенаправления'
    );
    private $_url = NULL;

    public function _self_doc() {
	$info = array(
	    'refresh' => array(
		'description' => array(
		    'en' => 'Redirect to url',
		    'ru' => ''
		),
		'single' => true, 
		'double' => false, 
		'variables' => 'url', 
		'attributes' => array(
		    'url' => array(
			'type' => 'text', 
			'flags' => '', 
			'default' => '', 
			'required' => false, 
		    ),
		),
	    ),
	    'w301' => array(
		'description' => array(
		    'en' => '301 Moved Permanently if page not found. Add a tag to your page with an error 404',
		    'ru' => ''
		),
		'single' => true, 
		'double' => false, 
		'variables' => 'if|url', 
		'attributes' => array(
		    'if' => array(
			'type' => 'text', 
			'flags' => '', 
			'default' => '',
			'required' => true,
		    ),
		    'url' => array(
			'type' => 'text',
			'flags' => '',
			'default' => '',
			'required' => true,
		    ),
		),
	    ),
	    'with' => array(
		'description' => array(
		    'en' => 'Manually specify the code to redirect',
		    'ru' => ''
		),
		'single' => true,
		'double' => false,
		'variables' => 'code|url',
		'attributes' => array(
		    'code' => array(
			'type' => 'text',
			'flags' => '',
			'default' => '',
			'required' => true,
		    ),
		    'url' => array(
			'type' => 'text',
			'flags' => '',
			'default' => '',
			'required' => true,
		    ),
		),
	    ),
	);

	return $info;
    }

    /*
     * {{ redirect:refresh }} <-- base url
     * {{ redirect:refresh url="/news" }}
     */
    public function refresh() {

	$this->_init();
	return redirect($this->attribute('url', base_url()), 'refresh');
    }

    /*
     * 301 Moved Permanently
     * {{ redirect:w301 if="_url404_" url="_redirect_" }}
     */
    public function w301() {
	$this->_init();

	if ($url404 = $this->attribute('if', FALSE) AND $url404 = $this->uri->uri_string()) {

	    return redirect($this->_url, 'auto', 301);
	}
    }

    /*
     * {{ redirect:with code="302" url="?" }}
     */
    public function with() {

	$this->_init();
	return redirect($this->_url, 'auto', $this->attribute('code', NULL));
    }

    private function _init() {

	$this->load->helper('url');
	$this->_url = $this->attribute('url');
    }

}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Redirect Plugin
 *
 * Redirect with status code.
 *
 * @author		PyroCMS Dev Team
 * @package		PyroCMS\Addon\Plugins
 * @copyright	Copyright (c) 2009 - 2010, PyroCMS
 */
class Plugin_Redirect extends Plugin {

    public $version = '1.0.0';
    public $name = array(
	'en' => 'Redirect',
	'ru' => 'Редиректы'
    );
    public $description = array(
	'en' => 'With',
	'ru' => 'Редиректы с кодом.'
    );
    private $_url = NULL;

    /**
     *
     * @var CI_Uri
     */
    public $uri;

    public function _self_doc() {
	$info = array(
	    'refresh' => array(
		'description' => array(// a single sentence to explain the purpose of this method
		    'en' => 'Redirect to url',
		    'ru' => ''
		),
		'single' => true, // will it work as a single tag?
		'double' => false, // how about as a double tag?
		'variables' => 'url', // list all variables available inside the double tag. Separate them|like|this
		'attributes' => array(
		    'url' => array(// this is the name="World" attribute
			'type' => 'text', // Can be: slug, number, flag, text, array, any.
			'flags' => '', // flags are predefined values like asc|desc|random.
			'default' => '', // this attribute defaults to this if no value is given
			'required' => false, // is this attribute required?
		    ),
		),
	    ),
	    'w301' => array(
		'description' => array(// a single sentence to explain the purpose of this method
		    'en' => '301 Moved Permanently if page not found. Add a tag to your page with an error 404',
		    'ru' => ''
		),
		'single' => true, // will it work as a single tag?
		'double' => false, // how about as a double tag?
		'variables' => 'if|url', // list all variables available inside the double tag. Separate them|like|this
		'attributes' => array(
		    'if' => array(// this is the name="World" attribute
			'type' => 'text', // Can be: slug, number, flag, text, array, any.
			'flags' => '', // flags are predefined values like asc|desc|random.
			'default' => '', // this attribute defaults to this if no value is given
			'required' => true, // is this attribute required?
		    ),
		    'url' => array(// this is the name="World" attribute
			'type' => 'text', // Can be: slug, number, flag, text, array, any.
			'flags' => '', // flags are predefined values like asc|desc|random.
			'default' => '', // this attribute defaults to this if no value is given
			'required' => true, // is this attribute required?
		    ),
		),
	    ),
	    'with' => array(
		'description' => array(// a single sentence to explain the purpose of this method
		    'en' => 'Manually specify the code to redirect',
		    'ru' => ''
		),
		'single' => true, // will it work as a single tag?
		'double' => false, // how about as a double tag?
		'variables' => 'code|url', // list all variables available inside the double tag. Separate them|like|this
		'attributes' => array(
		    'code' => array(// this is the name="World" attribute
			'type' => 'text', // Can be: slug, number, flag, text, array, any.
			'flags' => '', // flags are predefined values like asc|desc|random.
			'default' => '', // this attribute defaults to this if no value is given
			'required' => true, // is this attribute required?
		    ),
		    'url' => array(// this is the name="World" attribute
			'type' => 'text', // Can be: slug, number, flag, text, array, any.
			'flags' => '', // flags are predefined values like asc|desc|random.
			'default' => '', // this attribute defaults to this if no value is given
			'required' => true, // is this attribute required?
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
     * {{ redirect:moved if="_url404_" url="_redirect_" }}
     */
    public function moved() {

	if ($url404 = $this->attribute('if', FALSE) AND $url404 == $_SERVER['REQUEST_URI']) {

	    $this->_init();
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

/* End of file example.php */

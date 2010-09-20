<?php
require_once(dirname(__FILE__).'/OpenID_Auth_Module.php');
require_once(dirname(__FILE__).'/OpenID/OpenID.php');
require_once(Auth_OpenID_BaseDir.'/OpenID/Consumer.php');
require_once(Auth_OpenID_BaseDir.'/OpenID/FileStore.php');
require_once(Auth_OpenID_BaseDir.'/OpenID/AX.php');

class OpenID extends Auth_OpenID_Consumer {
	const REQUEST_ATTR_TYPE_AX = 'AX';
	const REQUEST_ATTR_TYPE_SREG = 'SREG';

	public $status = true;

	protected $_auth_req = null;
	protected $_callback_uri;
	protected $_response;
	protected $_response_data;

	protected $_auth_module = null;

	public function __construct($storePath, $openIdModule = null) {
		if( !is_dir($storePath) || !is_writeable($storePath) ) {
			$this->status = Auth_OpenID_FAILURE;
			return;
		}

		$store = new Auth_OpenID_FileStore($storePath);
		parent::__construct($store);

		if( !is_null($openIdModule) && $this->makeAuthModule($openIdModule) ) {
			$this->buildAuthRequest();
		}
	}

	protected function makeAuthModule($module) {
		$module_file = dirname(__FILE__)."/OpenID_Modules/{$module}.php";
		if( !is_readable($module_file) ) return false;

		include_once($module_file);

		$moduleClass = 'OpenID_'.$module;
		$this->_auth_module = new $moduleClass();

		return true;
	}

	public function getResponseData() {
		return $this->_response_data;
	}

	public function setAuthModule($module, $buildAuthRequest = false) {
		if( false === $this->status ) return false;

		if( $this->makeAuthModule($openIdModule) ) {
			if( (bool)$buildAuthRequest ) {
				return $this->buildAuthRequest();
			}
			return true;
		}
		$this->status = Auth_OpenID_FAILURE;
		return false;
	}

	public function setCallbackURI($callbackUri) {
		if( false === $this->status ) return false;
		$this->_callback_uri = $callBackUri;
	}

	public function addRequestAttributes($attributes) {
		if( !$this->status || !$this->_auth_req ) return false;

		$request_extension = $this->_auth_module->requestProfileFields($attributes);
		if( $request_extension ) {
			$this->_auth_req->addExtension($request_extension);
		}
	}

	public function sendAuthRequest($callbackUri = null) {
		if( false === $this->status ) return false;

		if( is_null($callbackUri) ) {
			if( is_null($this->_callback_uri) ) return false;
			$callbackUri = $this->_callback_uri;
		}

		if( is_null($this->_auth_req) ) {
			if( empty($this->_auth_module) ) return false;

			if( !$this->buildAuthRequest($this->_auth_module->getOpenIdURI()) ) return false;
		}

		$redirectUri = $this->_auth_req->redirectURL(
			// TODO: Make this SSL Aware
			'http://'.$_SERVER['HTTP_HOST'], $callbackUri
		);

		header('Location: '.$redirectUri);
		exit;
	}

	public function completeAuthRequest($callbackUri = null, $parseData = true) {
		// No callback uri provided, so attempt to discern it automagically.
		if( is_null($callbackUri) ) {
			// TODO: Make this SSL Aware
			$callbackUri = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
		}

		$response = $this->complete($callbackUri);
		$this->_response = $response;
		$this->status = $response->status;
		if( Auth_OpenID_SUCCESS !== $this->status ) return false;

		// TODO: yeah, remove this eventually. good for debugging ATM though.
		var_dump($response);

		if( (bool)$parseData ) {
			$this->_response_data = $this->_auth_module->parseResponse($response);
		}

		return true;
	}

	/**
	 *
	 * TODO: Currently this only handles Attribute Exchange (AX) response data
	 * Add support for SReg response data.
	 */
	public function parseResponseData() {
		$this->_response_data = $this->parseAxResponseData();

		return $this->_response_data;
	}

	protected function parseAxResponseData() {
		$data = array();

		$ax = new Auth_OpenID_AX_FetchResponse();
		$ax_data = $ax->fromSuccessResponse($this->_response);
		if( !empty($ax_data) && !empty($ax_data->data) ) {
			 $data = $ax_data->data;
		}
		return $data;
	}

	protected function buildAuthRequest() {
		if( is_a($this->_auth_module, 'OpenID_Auth_Module') ) {
			$this->_auth_req = $this->begin($this->_auth_module->getOpenIdURI());
			if( $this->_auth_req ) {
				return true;
			}
		}
		$this->status = Auth_OpenID_FAILURE;
		return false;
	}
}

?>

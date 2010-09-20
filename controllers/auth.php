<?php

class auth_Controller extends MDController {
	public function index() {
		
	}
	
	public function openid() {
		$oid_module = 'google'; // TODO: Make this key off form field.
		$oid = new OpenID(sliMVC::config('auth.openid.store'), $oid_module);
		if( Auth_OpenID_FAILURE === $oid->status ) {
			throw new sliMVC_User_Exception('Unable to initialize OpenID',
				'Unable to initialize OpenID store.');
		}
		if( !$oid->addRequestAttributes(sliMVC::config('auth.openid.attributes')) ) {
			throw new sliMVC_User_Exception('Unable to initalize OpenID',
				'Unable to set OpenID request attributes.');
		}
		$oid->sendAuthRequest("http://{$_SERVER['HTTP_HOST']}/auth/openid_complete/{$oid_module}?url=auth/openid_complete/{$oid_module}");
		exit;
	}
	public function openid_complete($oid_module) {
		$oid = new OpenID(sliMVC::config('auth.openid.store'), $oid_module);
		if( Auth_OpenID_FAILURE === $oid->status ) {
			throw new sliMVC_User_Exception('Unable to initialize OpenID',
				'Unable to initialize OpenID store.');
		}
		$oid->completeAuthRequest("http://{$_SERVER['HTTP_HOST']}/auth/openid_complete/{$oid_module}?url=auth/openid_complete/{$oid_module}");		
		if( Auth_OpenID_SUCCESS === $oid->status ) {
			$userData = $oid->getResponseData();
			var_dump($userData);
			exit;
		}
		else {
			die("oid login failed");
		}
	}
		
	public function login() {
		
	}
	
	public function logout() {
		
	}

}
?>
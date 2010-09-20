<?php

abstract class OpenID_Auth_Module {
	protected $_openid_uri;
	protected $_profile_field_map;

	public function getOpenIdURI() {
		return $this->_openid_uri;
	}

	abstract public function requestProfileFields($field_array);
	abstract public function parseResponse($response);
	
	abstract public function getProfileFieldBySchemaURI($schemaURI);
	abstract public function getProfileFieldByName($fieldName);
}
?>

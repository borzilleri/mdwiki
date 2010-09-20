<?php

class OpenID_Google extends OpenID_Auth_Module {
	protected $_openid_uri = 'https://www.google.com/accounts/o8/id';

	protected $_profile_field_map = array(
		'country' => 'http://axschema.org/contact/country/home',
		'email' => 'http://axschema.org/contact/email',
		'firstname' => 'http://axschema.org/namePerson/first',
		'lastname' => 'http://axschema.org/namePerson/last',
		'language' => 'http://axschema.org/pref/language'
	);

	public function requestProfileFields($field_array) {
		$ax_req = new Auth_OpenID_AX_FetchRequest();
		foreach($field_array as $field_alias => $field) {
			if( !array_key_exists($field, $this->_profile_field_map) ) continue;

			$alias = is_int($field_alias) ? $field : $field_alias;
			$ax_req->add(Auth_OpenID_AX_AttrInfo::make($this->_profile_field_map[$field], 1, true, $alias));
		}

		return $ax_req;
	}
	
	public function parseResponse($response) {
		$data = array();
		
		$keys = $response->message->args->keys;
		$values = $response->message->args->values;
		
		foreach($keys as $i => $key) {
			if( 'http://specs.openid.net/auth/2.0' == $key[0] && 'claimed_id' == $key[1] ) {
				// Search for our "claimed_id" argument.
				$data['id'] = $values[$i];
			}
			elseif( 'http://openid.net/srv/ax/1.0' == $key[0] && 'type' == substr($key[1],0,4) ) {
				// We have an Attribute Exchange type field.
				// See if it's actually in this spec.				
				$schema = $values[$i];
				if( false !== array_search($schema, $this->_profile_field_map) ) {
					if( $keys[$i+1][1] == 'value.'.substr($key[1],5) ) {
						$data[substr($key[1],5)] = $values[$i+1];
					}
				}
			}
		}
		return $data;
	}

	public function getProfileFieldBySchemaURI($schemaURI) {
		return array_search($schemaURI, $this->_profile_field_map);
	}

	public function getProfileFieldByName($fieldName) {
		return empty($this->_profile_field_map[$fieldName]) ? false : $this->_profile_field_map[$fieldName];
	}

}

?>

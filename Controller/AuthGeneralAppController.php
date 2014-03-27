<?php

App::uses('AuthController', 'Auth.Controller');

class AuthGeneralAppController extends AuthController {

/**
 * Return authentication adapter name
 *
 * @return string Authentication adapter name
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 **/
	public function getAuthenticator() {
		return 'Form';
	}
}

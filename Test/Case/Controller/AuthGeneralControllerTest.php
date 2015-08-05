<?php
/**
 * Summary for AuthGeneralController Test Case
 */

App::uses('AuthGeneralController', 'Controller');
App::uses('AuthComponent', 'Controller/Component');

/**
 * AuthGeneralController Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */
class AuthGeneralControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @var      array
 */
	public $fixtures = array(
		'plugin.m17n.language',
		'plugin.net_commons.site_setting',
		'plugin.pages.page',
		'plugin.roles.role',
		'plugin.users.user',
	);

/**
 * setUp
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @return   void
 */
	public function setUp() {
		parent::setUp();
		$this->generate('AuthGeneral.AuthGeneral', array(
			'components' => array(
				'Auth' => array('user'),
				'Session',
			),
		));
		$this->controller->plugin = 'AuthGeneral';
		$this->controller->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnCallback(array($this, 'authUserCallback')));
	}

/**
 * authUserCallback
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @param    int $key
 * @return   mixed
 */
	public function authUserCallback($key) {
		$auth = array(
			'id' => 1,
			'username' => 'admin',
		);
		if (empty($key) || !isset($auth[$key])) {
			return $auth;
		}
		return $auth[$key];
	}

/**
 * testIndex action
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @return   void
 */
	public function testIndex() {
		$this->testAction('/auth/index');
		$this->assertEqual($this->headers['Location'], Router::url('/auth/login', true));
	}

/**
 * testLogin action
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @return   void
 */
	public function testLogin() {
		$this->testAction('/auth_general/auth_general/login', array(
			'method' => 'POST',
			'data' => array(
				'User' => array(
					'username' => 'admin',
					'password' => 'admin',
				),
			),
		));
		$this->assertTrue($this->controller->Auth->loggedIn());
	}

/**
 * testLogout action
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @return   void
 */
	public function testLogout() {
		$this->testAction('/auth_general/auth_general/logout', array(
			'data' => array(
			),
		));
		$this->assertEqual($this->headers['Location'], Router::url('/setting', true));
		/* $this->assertFalse($this->controller->Auth->loggedIn()); */
	}

/**
 * Call logout action
 *
 * @param CakeTestCase $test CakeTestCase instance
 * @return void
 */
	public static function logout($test) {
		/* $test->testAction('/auth_general/auth_general/logout', array( */
		/* 	'data' => array( */
		/* 	), */
		/* )); */
	}
}

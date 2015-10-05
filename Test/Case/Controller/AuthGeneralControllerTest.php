<?php
/**
 * AuthGeneralControllerのテスト
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AuthGeneralController', 'Controller');
App::uses('AuthComponent', 'Controller/Component');
App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('Role', 'Roles.Model');

/**
 * AuthGeneralControllerのテスト
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AuthGeneral\Test\Case\Controller
 */
class AuthGeneralControllerTest extends NetCommonsControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Plugin name
 *
 * @var array
 */
	public $plugin = 'auth_general';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'auth_general';

/**
 * setUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->controller->plugin = 'AuthGeneral';
		$this->controller->Auth
			->staticExpects($this->any())
			->method('user')
			->will($this->returnCallback(function ($key = null) {
				$role = Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR;
				if (isset(TestAuthGeneral::$roles[$role][$key])) {
					return TestAuthGeneral::$roles[$role][$key];
				} else {
					return TestAuthGeneral::$roles[$role];
				}
			}));
	}

/**
 * ログイン表示のテスト
 *
 * @return void
 */
	public function testIndex() {
		$this->testAction('/auth/index');
		$this->assertEqual($this->headers['Location'], Router::url('/auth/login', true));
	}

/**
 * ログインのテスト
 *
 * @return void
 */
	public function testLogin() {
		$this->testAction('/auth_general/auth_general/login', array(
			'method' => 'post',
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
 * ログアウトのテスト
 *
 * @return void
 */
	public function testLogout() {
		$this->testLogin();

		$this->testAction('/auth_general/auth_general/logout', array(
			'data' => array(),
		));
		$this->assertEqual(null, CakeSession::read('Auth.User'));
	}

/**
 * Call logout action
 * 後で削除
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

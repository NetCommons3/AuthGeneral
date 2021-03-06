<?php
/**
 * AuthGeneralController::login()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');
App::uses('TestAuthGeneral', 'AuthGeneral.TestSuite');

/**
 * AuthGeneralController::login()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AuthGeneral\Test\Case\Controller
 */
class AuthGeneralControllerLoginTest extends NetCommonsControllerTestCase {

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
 * ログイン状態と判定させるMock生成する
 *
 * @return void
 */
	protected function _mockLoggedIn() {
		$this->generateNc(Inflector::camelize($this->_controller),
			array(
				'components' => array(
					'Auth' => array('login'),
				),
				'uses' => array(
					'Users.User' => array('updateLoginTime'),
				)
			)
		);

		$this->controller->Auth
			->expects($this->once())
			->method('login')
			->will($this->returnCallback(function () {
				TestAuthGeneral::login($this);
				return true;
			}));
	}

/**
 * ログインのテスト
 *
 * @return void
 */
	public function testLogin() {
		$this->assertFalse($this->controller->Auth->loggedIn());

		//ログイン状態と判定させるMock生成
		$this->_mockLoggedIn();

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
}

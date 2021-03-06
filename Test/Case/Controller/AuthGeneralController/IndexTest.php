<?php
/**
 * AuthGeneralController::index()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * AuthGeneralController::index()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AuthGeneral\Test\Case\Controller
 */
class AuthGeneralControllerIndexTest extends NetCommonsControllerTestCase {

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
 * ログイン表示のテスト
 *
 * @return void
 */
	public function testIndex() {
		$this->testAction('/auth_general/auth_general/index');
		$this->assertTextContains('/auth/login', $this->headers['Location']);
	}
}

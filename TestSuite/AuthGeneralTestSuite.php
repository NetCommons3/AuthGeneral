<?php
/**
 * AuthGeneralTestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Role', 'Roles.Model');
App::uses('AuthComponent', 'Controller/Component');
App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * AuthGeneralTestSuite
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\AuthGeneral\TestSuite
 */
class AuthGeneralTestSuite {

/**
 * Roles data for testing
 *
 * @var array
 */
	public static $roles = [
		Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR => [
			'id' => 1,
			'username' => 'admin',
			'password' => 'admin',
			'role_key' => 'system_administrator',
			'handlename' => 'handle of admin'
		],
		Role::ROOM_ROLE_KEY_CHIEF_EDITOR => [
			'id' => 2,
			'username' => 'chief_editor',
			'password' => 'chief_editor',
			'role_key' => 'administrator',
			'handlename' => 'chief_editor of admin'
		],
		Role::ROOM_ROLE_KEY_EDITOR => [
			'id' => 3,
			'username' => 'editor',
			'password' => 'editor',
			'role_key' => 'common_user',
			'handlename' => 'editor of admin'
		],
		Role::ROOM_ROLE_KEY_GENERAL_USER => [
			'id' => 4,
			'username' => 'general_user',
			'password' => 'general_user',
			'role_key' => 'common_user',
			'handlename' => 'general_user of admin'
		],
		Role::ROOM_ROLE_KEY_VISITOR => [
			'id' => 5,
			'username' => 'visitor',
			'password' => 'visitor',
			'role_key' => 'common_user',
			'handlename' => 'visitor of admin'
		],
	];

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

		CakeSession::write('Auth.User', null);
	}

/**
 * Login as given roles
 *
 * @param CakeTestCase $test CakeTestCase instance
 * @param string $role role key
 * @return void
 */
	public static function login(CakeTestCase $test, $role = Role::ROOM_ROLE_KEY_ROOM_ADMINISTRATOR) {
		$test->controller->Components->Auth
			->staticExpects($test->any())
			->method('user')
			->will($test->returnCallback(function ($key = null) use ($role) {
				CakeSession::write('Auth.User', self::$roles[$role]);
				if (isset(self::$roles[$role][$key])) {
					return self::$roles[$role][$key];
				} else {
					return self::$roles[$role];
				}
			}));

		$test->controller->Components->Auth->login([
			'username' => self::$roles[$role]['username'],
			'password' => self::$roles[$role]['password'],
		]);
	}

}
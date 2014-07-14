<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
 * @link       http://fuelphp.com
 */

namespace Auth\Model;

class Auth_Grouppermission extends \Orm\Model
{
	/**
	 * @var  string  connection to use
	 */
	protected static $_connection = null;
	
	/**
	 * @var  string  write connection to use
	 */
    protected static $_write_connection = null;

	/**
	 * @var  string  table name to overwrite assumption
	 */
	protected static $_table_name;

	/**
	 * @var  array  name or names of the primary keys
	 */
	protected static $_primary_key = array('id');

	/**
	 * @var array	model properties
	 */
	protected static $_properties = array(
		'id',
		'group_id',
		'perms_id',
		'actions'         => array(
			'data_type'	  => 'serialize',
			'default' 	  => array(),
			'null'		  => false,
			'form'  	  => array('type' => false),
		),
	);

	/**
	 * @var array	defined observers
	 */
	protected static $_observers = array(
		'Orm\\Observer_Typing' => array(
			'events' => array('after_load', 'before_save', 'after_save')
		),
	);

	/**
	 * @var array	belongs_to relationships
	 */
	protected static $_belongs_to = array(
		'group' => array(
			'key_from' => 'group_id',
			'model_to' => 'Model\\Auth_Group',
			'key_to' => 'id',
		),
		'permission' => array(
			'key_from' => 'perms_id',
			'model_to' => 'Model\\Auth_Permission',
			'key_to' => 'id',
		),
	);

	/**
	 * init the class
	 */
   	public static function _init()
	{
		// auth config
		\Config::load('ormauth', true);

		// set the connection this model should use
		static::$_connection = \Config::get('ormauth.db_connection');
		
		// set the write connection this model should use
		static::$_write_connection = \Config::get('ormauth.db_write_connection');

		// set the models table name
		static::$_table_name = \Config::get('ormauth.table_name', 'users').'_group_permissions';
	}
}

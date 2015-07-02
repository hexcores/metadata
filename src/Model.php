<?php namespace Hexcores\Metadata;

use Jenssegers\Mongodb\Model as MongoModel;

/**
 * Metadata Model for ecommerce project
 *
 * @package Hexcores
 * @author  Hexcores Web and Mobile Studio <support@hexcores.com>
 * @link http://hexcores.com
 **/

class Model extends MongoModel {

	const KEY_NAME = "key";
	const VALUE_NAME = "value";

	protected $collection = 'metadata';

	protected $guarded = array('_token');
}
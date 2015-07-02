<?php namespace Hexcores\Metadata;

/**
 * Metadata Helper for project metadata store
 *
 * @package Hexcores
 * @author  Hexcores Web and Mobile Studio <support@hexcores.com>
 * @link http://hexcores.com
 **/

class Metadata {

	/**
	 * Loaded metadata cache.
	 * 
	 * @var array
	 */
	protected $cache = [];

	/**
	 * Get metadata by key. If given key is doesn't exists in store,
	 * will be return default value.
	 * 
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		// 1. Result return from cache, if result have in cache
		if ( isset($this->cache[$key]))
		{
			return $this->cache[$key];
		}

		// 2. Result cann't found in cache data
		// Fetch from database
		$result = $this->getFromDatabase($key);

		// 3. If result found in database, set to cache and return data
		if ( ! is_null($result))
		{
			$this->cache[$key] = $result[Model::VALUE_NAME];

			return $result[Model::VALUE_NAME];
		}

		// 4. Finally data is not found in database.
		// return default data
		return value($default);
	}

	/**
	 * Set metadata to store
	 * @param string $key
	 * @param mixed $value
	 * @param null|string $type
	 * @return boolean
	 */
	public function set($key, $value, $type = null)
	{
		$model = $this->getFromDatabase($key);

		if ( is_null($model))
		{
			$model = new Model();
			$model->{Model::KEY_NAME} = $key;
		}

		$model->{Model::VALUE_NAME} = $this->normalizeValue($value, $type);

		if ( $model->save())
		{
			$this->cache[$key] = $model->{Model::VALUE_NAME};

			return true;
		}

		return false;
	}

	/**
	 * Remove meta data
	 * 
	 * @param  string $key
	 * @return void
	 */
	public function destroy($key)
	{
		unset($this->cache[$key]);

		Model::where(Model::KEY_NAME, $key)->delete();
	}

	/**
	 * Get data from database with given key.
	 * 
	 * @param  string $key
	 * @return mixed
	 */
	protected function getFromDatabase($key)
	{
		return Model::where(Model::KEY_NAME, $key)->first();
	}

	/**
	 * Make normalize value with given type.
	 * @param  mixed $value
	 * @param  integer $type
	 * 
	 * @return mixed
	 */
	protected function normalizeValue($value, $type)
	{
		if ( is_null($type)) return $value;

		switch ($type) {
			case 'int':
			case 'integer':
				return is_int($value) ? $value : (int) $value;
				break;
			
			case 'float':
				return is_float($value) ? $value : (float) $value;
				break;

			case 'str':
			case 'string':
				return is_string($value) ? $value : (string) $value;
				break;

			case 'array':
				return is_array($value) ? $value : (array) $value;
				break;

			case 'bool':
			case 'boolean':
				return is_bool($value) ? $value : (boolean) $value;
				break;

			default:
				return $value;
		}
	}
}

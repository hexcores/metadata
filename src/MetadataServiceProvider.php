<?php namespace Hexcores\Metadata;

use Illuminate\Support\ServiceProvider;

/**
 * Metadata ServiceProvider Class.
 *
 * @package Hexcore\Metadata
 * @author  Hexcores Web and Mobile Studio <support@hexcores.com>
 * @link http://hexcores.com
 */
class MetadataServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bindShared('hex.metadata', function($app)
		{
			return new Metadata();
		});
	}

	public function boot() {}
	
	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}
}
<?php

if ( ! function_exists('get_meta'))
{
	function get_meta($key, $default = null)
	{
		return app('hex.metadata')->get($key, $default);
	}
}

if ( ! function_exists('set_meta'))
{
	function set_meta($key, $value, $type = null)
	{
		return app('hex.metadata')->set($key, $value, $type);
	}
}

if ( ! function_exists('destroy_meta'))
{
	function destroy_meta($key)
	{
		return app('hex.metadata')->destroy($key);
	}
}
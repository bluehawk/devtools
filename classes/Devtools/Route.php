<?php defined('SYSPATH') or die('No direct script access.');

class Devtools_Route extends Kohana_Route {
	
	/**
	 * Test a URL or an array of URLs to see which routes they match.
	 *
	 * If no param is passed it will test the current url:
	 *
	 *     // Test the current url
	 *     echo Route::test();
	 * 
	 * To test on a single url:
	 *
	 *     echo Route::test('some/url/to/test');
	 *
	 * To test several urls:
	 *
	 *     echo Route::test(array(
	 *         'some/url/to/test',
	 *         'another/url',
	 *         'guide/api/Class',
	 *         'guide/media/image.png',
	 *     ));
	 *
	 * You may also pass the route and parameters you expect, by passing each
	 * url as a key with an array of expected values.
	 *
	 *     $urls = array(
	 *         'guide/media/image.png' = array(
	 *             'route' => 'docs/media',
	 *             'controller' => 'userguide',
	 *             'action' => 'media',
	 *             'file' => 'image.png',
	 *         ),
	 *
	 *         'blog/5/some-title` = array(
	 *             'route' => 'blog',
	 *             'controller' => 'blog',
	 *             'action' => 'article',
	 *             'id' => '5',
	 *             'title' => 'some-title',
	 *         ),
	 *     );
	 *     echo Route::test($urls);
	 *
	 * It's useful to store your array of urls to be tested in a config file,
	 * for example in `application/config/my-route-tests.php` return an array
	 * similar to the previous examples then call:
	 *
	 *     echo Route::test(Kohana::config('your-route-tests'));
	 *
	 *@author    Michael Peters
	 *@license   http://creativecommons.org/licenses/by-sa/3.0/
	 */
	public static function test($urls = NULL)
	{
		// If no url provide, use the current url
		if ($urls === NULL)
		{
			$urls = Request::$current->uri;
		}
		return View::factory('devtools/route-test',array(
			// Get all the tests
			'tests' => Route_Tester::create_tests($urls),
		));
	}

} // End Route

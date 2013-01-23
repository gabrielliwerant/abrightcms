<?php if ( ! defined('DENY_ACCESS')) exit('403: No direct file access allowed');

/**
 * A Bright CMS
 * 
 * Core MVC/CMS framework used in TaskVolt and created for lightweight, custom
 * web applications.
 * 
 * @package A Bright CMS
 * @author Gabriel Liwerant
 */

/**
 * Bootstrap Class
 * 
 * Acts as a controller factory and loader. As the application object, we use it
 * to find our first controller to run the application.
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 */
class Bootstrap
{
	/**
	 * Holds an instance of the application factory object.
	 *
	 * @var object $_application_factory
	 */
	private $_application_factory;
	
	/**
	 * Holds the user-entered URL, broken up into an array.
	 *
	 * @var array $_url
	 */
	private $_url = array();
	
	/**
	 * Holds the controller object instance.
	 *
	 * @var object $_controller
	 */
	private $_controller;
	
	/**
	 * Holds the name of the method to call
	 *
	 * @var string $_method
	 */
	private $_method;
	
	/**
	 * Holds the parameters for methods.
	 *
	 * @var array $_parameter
	 * @todo consider using a different way of passing parameters to methods
	 */
	private $_parameter = array();
	
	/**
	 * We are sad if new bootstrap object doesn't load the application, so we
	 * make sure it does what it must to find the controller and load 
	 * dependencies.
	 * 
	 * Upon construction, we set the URL, controller, method, and parameters.
	 * Then we send them to the router.
	 * 
	 * @param object $application_factory Application factory object
	 * @param array $get_data Loads data from the URL query string
	 */
	public function __construct($application_factory, $get_data)
	{
		$this->_application_factory = $application_factory;
		
		$this->_setUrl($get_data);
		$this->_setController($this->_getUrl(0));
		$this->_setMethod($this->_controller, $this->_getUrl(1));
		$this->_setParameter($this->_getUrl(), $this->_method);
        
		$this->_router($this->_controller, $this->_method, $this->_parameter);
	}
	
	/**
	 * Sets the URL property.
	 * 
	 * If we have a URL GET request, send it for sanitization and set it. 
	 * Otherwise, initialize it as an empty value. Then we create an array of 
	 * slash-separated values to store in the URL property.
	 */
	private function _setUrl($get_data)
	{
		if (isset($get_data['url']))
		{
			$url = $this->_sanitizeUrl($get_data['url']);
		}
		else
		{
			$url = '';
		}
		
		$this->_url = explode('/', $url);
	}
	
	/**
	 * Returns part of the stored URL array according to the given key or the 
	 * entire URL array if no key is specified.
	 * 
	 * @param int $key Array index to return
	 * @return string URL value for the given index or entire array
	 */
	private function _getUrl($key = null)
	{
		//Must use null because empty will be true for 0
		if (is_null($key))
		{
			return $this->_url;
		}
		else
		{
			if (array_key_exists($key, $this->_url))
			{
				return $this->_url[$key];
			}
			else
			{
				return false;
			}
		}
	}
	
	/**
	 * Call the controller object with given method and any parameters.
     * 
	 * @param object $controller Controller object
	 * @param string $method Name of method to call on controller
	 * @param string/integer array $parameter Any parameters to load in method
	 */
	private function _router($controller, $method, $parameter)
	{
		$controller->{$method}($parameter);
	}
	
	/**
	 * Allows us to make sure that the user-entered URL is sanitized.
	 * 
	 * We get rid of any trailing slashes so we don't confuse any explodes 
	 * later. We also kill the URL GET value.
	 * 
	 * @param string $url URL string to check
	 * @return string The sanitized URL
	 */
	private function _sanitizeUrl($url)
	{
		//unset($_GET);
		
		$url = rtrim($url, '/');
		$url = strip_tags($url);
		
		return $url;
	}
	
	/**
	 * Get the controller according to URL entered for .htaccess redirect.
	 * 
	 * Check if we have a controller for the URL given. If no URL has been set, 
	 * send the user to a default page. If our URL is incorrect, send the user
	 * to an error page. Otherwise return the URL as given.
	 * 
	 * @param string $url User-entered URL to check
	 */
	private function _setController($url)
	{
		// If not set, send to index, otherwise run checks to find the matching 
		// controller
		if (empty($url))
		{
			$this->_controller = $this->_application_factory->makeController('index');
		}	
		else
		{
			// Scan the controllers directory for all valid files
			$controllers_arr = scandir(CONTROLLER_PATH, 1);

			$is_controller = false;
			
			foreach ($controllers_arr as $controller)
			{
				// Separate the file name from the extension
				$controller = explode('.', $controller);

				if ($url === $controller[0])
				{
					$is_controller = true;
				}
			}

			// Set the URL if it passed the checks above and is not error
			if ($is_controller AND $url !== 'error')
			{
				$this->_controller = $this->_application_factory->makeController($url);
			}
			else
			{
				$this->_error('404');
			}
		}
	}
	
	/**
	 * Find controller name from the object name and return it.
	 * 
	 * @return string The controller name
	 */
	private function _getControllerName()
	{
		if (PHP_VERSION < 5.3)
		{
			return strtolower(get_class($this->_controller));
		}
		else
		{
			return lcfirst(get_class($this->_controller));
		}
	}
	
	/**
	 * If a second parameter (method) was specified in the URL, then set it in
	 * our method property. Otherwise, assume default index method to display
	 * page.
	 * 
	 * @param object $controller Used to check for existing methods
	 * @param string $method Possible secondary URL value (method)
	 */
	private function _setMethod($controller, $method)
	{
		if (empty($method))
		{
			$this->_method = 'index';
		}
		elseif (method_exists($controller, $method))
		{
			$this->_method = $method;
		}
		else
		{
			$this->_error('404');
		}
	}
	
	/**
	 * Set parameters called from the URL.
	 * 
	 * We skip this step if we have an error. If we have an index method call,
	 * we send the controller name as a parameter to render the page. Otherwise,
	 * we loop through the rest of the URL and store the results.
	 * 
	 * @param string/integer $url
	 * @param string $method
	 */
	private function _setParameter($url, $method)
	{
		// Find controller name from the object name
		$controller_name = $this->_getControllerName();
		
		if ($controller_name !== 'error')
		{
			// Index to begin looking for parameters (0 is the first)
			$index_start = 2;
			
			if ( ($method === 'index') AND (count($url) <= $index_start) )
			{
				$this->_parameter = array($controller_name);
			}
			else
			{
				foreach ($url as $key => $value)
				{
					if ($key >= $index_start)
					{
						$this->_parameter[$key - $index_start] = $value;
					}
				}
			}
		}
	}
	
	/**
	 * Handles the error controller, method, parameters.
	 * 
	 * Error pages are always loaded from the error controller and index method.
	 * The parameters then decide what messages to display. Finally, we call the
	 * router method to send us immediately to the error page.
	 * 
	 * @param string $type Name of the error to display.
	 */
	public function _error($type)
	{
		// Make sure to have an error controller and the proper page name.
		$this->_controller	= $this->_application_factory->makeController('error');
		$page				= $this->_getControllerName();

		switch ($type)
		{
			case '404'	: 
				$this->_method      = 'index';
				$this->_parameter   = array($type);
				break;
		}
		
		$this->_router($this->_controller, $this->_method, $this->_parameter);
	}
}
// End of Bootstrap Class

/* EOF lib/Bootstrap.php */
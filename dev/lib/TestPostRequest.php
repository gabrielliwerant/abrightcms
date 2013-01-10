<?php

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
 * TestPostRequest Class
 * 
 * Use for testing post requests without actually opening the sockets or sending
 * data.
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 */
class TestPostRequest
{
	/**
	 * Holds boolean value for whether or not we should use in SSL mode.
	 *
	 * @var boolean $use_ssl
	 */
	public $use_ssl;
	
	/**
	 * Set the SSL setting boolean.
	 * 
	 * @param boolean $test_use_ssl
	 */
	public function __construct($test_use_ssl = false)
	{
		$this->use_ssl = $test_use_ssl;
	}

	/**
	 * Get the correct port number based upon URL scheme.
	 *
	 * @param string $url_scheme URL scheme to return port for
	 * @return integer Port number
	 */
	private function _getPortNumber($url_scheme)
	{
		if ($this->use_ssl)
		{
			if ( ($url_scheme === 'http') OR ($url_scheme === 'https') )
			{
				return 443;
			}
			else
			{
				throw new MyException('Error: Only HTTP requests are supported!');
			}
		}
		else
		{
			if ( ($url_scheme === 'http') OR ($url_scheme === 'https') )
			{
				return 80;
			}
			else
			{
				throw new MyException('Error: Only HTTP requests are supported!');
			}
		}
	}
	
	/**
	 * Get the host value depending on whether or not we are using SSL.
	 *
	 * @param string $url_host Host value to alter or return
	 * @return string Proper host if using SSL
	 */
	private function _getHostIfSsl($url_host)
	{
		if ($this->use_ssl)
		{
			return 'ssl://' . $url_host;
		}
		else
		{
			return $url_host;
		}
	}
	
	/**
	 * Destroy the data from the Post request after it is no longer needed. We
	 * may also want to log it from here in the future.
	 *
	 * @param string &$post_data Post data, passed by reference
	 */
	private function _destroyPostData(&$post_data)
	{
		$post_data = null;
	}
	
	/**
	 * Run through the standard, non-invasive operations of for this class, then
	 * spit out some data as we successfully completed our post.
	 *
	 * @param string $url URL that is sending the request
	 * @param string &$data Post data being sent
	 * @param integer $timeout Timeout in seconds
	 * @param type $referer
	 * @return array Information about request success
	 */
	public function postRequest($url, &$data, $timeout = 30, $referer = null)
	{
		// Convert the data array into URL Parameters like a=b&foo=bar etc.
		$data_query_string = http_build_query($data);

		// Parse the given URL
		$url = parse_url($url);

		$port	= $this->_getPortNumber($url['scheme']);
		$host	= $this->_getHostIfSsl($url['host']);
		$path	= $url['path'];
		
		$this->_destroyPostData($data);
		
		return array(
			'is_successful'	=> true,
			'port'			=> $port,
			'host'			=> $host,
			'path'			=> $path
		);
	}
}
// End of TestPostRequest Class

/* EOF lib/TestPostRequest.php */
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
 * PostRequest Class
 * 
 * @subpackage lib
 * @author Jonas John, modified by Gabriel Liwerant
 * @link http://www.jonasjohn.de/snippets/php/post-request.htm
 */
class PostRequest
{
	/**
	 * Tells us whether or not we're using SSL to send data. Apache must have
	 * ssl_module and PHP must have php_openssl extension enabled if true.
	 *
	 * @var boolean $use_ssl
	 */
	public $use_ssl;
	
	/**
	 * We must set whether or not we expect SSL values.
	 * 
	 * @param boolean $use_ssl Tells us whether or not to use SSL port
	 */
	public function __construct($use_ssl = false)
	{
		$this->use_ssl = $use_ssl;
	}

	/**
	 * Get the correct port number based upon URL scheme.
	 *
	 * @param string $url_scheme URL scheme to return port for
	 * @return integer Port number
	 * 
	 * @todo use proper error reporting
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
	 * This function recreates the post request method for form data and sends 
	 * to the original URL.
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

		$fp = fsockopen($host, $port, $err_number, $err_string, $timeout);

		if ($fp)
		{
			// Send the request headers:
			fwrite($fp, "POST $path HTTP/1.1\r\n");
			fwrite($fp, "Host: $host\r\n");

			if ( ! empty($referer))
			{
				fwrites($fp, "Referer: $referer\r\n");
			}

			fwrite($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fwrite($fp, "Content-length: " . strlen($data_query_string) . "\r\n");
			fwrite($fp, "Connection: close\r\n\r\n");
			fwrite($fp, $data_query_string);

			$result = null; 
			
			while ( ! feof($fp))
			{
				// Receive the results of the request
				$result .= fgets($fp, 128);
			}
		}
		else
		{
			$this->_destroyPostData($data);
			
			return array(
				'is_successful'	=> 'false', 
				'error'			=> $err_string . '(' . $err_number . ')'
			);
		}

		// Close the socket connection
		fclose($fp);

		// Split the result header from the content
		$result = explode("\r\n\r\n", $result, 2);

		$header		= isset($result[0]) ? $result[0] : null;
		$content	= isset($result[1]) ? $result[1] : null;
		
		$this->_destroyPostData($data);
		
		return array(
			'is_successful'	=> 'true',
			'header'		=> $header,
			'content'		=> $content
		);
	}
}
// End of PostRequest Class

/* EOF lib/PostRequest.php */
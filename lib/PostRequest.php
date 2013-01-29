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
	 * Error codes for PostRequest Class
	 */
	const INCORRECT_PORT_FOR_SSL		= 1001;
	const INCORRECT_PORT_FOR_NOT_SSL	= 1002;
	
	/**
	 * Tells us whether or not we're using SSL to send data. Apache must have
	 * ssl_module and PHP must have php_openssl extension enabled if true.
	 *
	 * @var boolean $_use_ssl
	 */
	private $_use_ssl;
	
	/**
	 * We must set whether or not we expect SSL values.
	 * 
	 * @param boolean $use_ssl Tells us whether or not to use SSL port
	 */
	public function __construct($use_ssl = false)
	{
		$this->_setUseSsl($use_ssl);
	}

	/**
	 * Setter for use ssl property
	 *
	 * @param boolean $use_ssl 
	 * 
	 * @return object PostRequest
	 */
	private function _setUseSsl($use_ssl)
	{
		$this->_use_ssl = $use_ssl;
		
		return $this;
	}
	
	/**
	 * Get the correct port number based upon URL scheme.
	 *
	 * @param string $url_scheme URL scheme to return port for
	 * 
	 * @return integer Port number
	 */
	private function _getPortNumber($url_scheme)
	{
		if ($this->_use_ssl)
		{
			if ( ($url_scheme === 'http') OR ($url_scheme === 'https') )
			{
				$port = 443;
			}
			else
			{
				throw ApplicationFactory::makeException('PostRequest Exception', self::INCORRECT_PORT_FOR_SSL);
				//throw new Exception('PostRequest Exception', self::INCORRECT_PORT_FOR_SSL);
			}
		}
		else
		{
			if ( ($url_scheme === 'http') OR ($url_scheme === 'https') )
			{
				$port = 80;
			}
			else
			{
				throw ApplicationFactory::makeException('PostRequest Exception', self::INCORRECT_PORT_FOR_NOT_SSL);
				//throw new Exception('PostRequest Exception', self::INCORRECT_PORT_FOR_NOT_SSL);
			}
		}
		
		return $port;
	}
	
	/**
	 * Get the host value depending on whether or not we are using SSL.
	 *
	 * @param string $url_host Host value to alter or return
	 * 
	 * @return string Proper host if using SSL
	 */
	private function _getHostIfSsl($url_host)
	{
		if ($this->_use_ssl)
		{
			$url_host = 'ssl://' . $url_host;
		}
		
		return $url_host;
	}
	
	/**
	 * This function recreates the post request method for form data and sends 
	 * to the original URL.
	 *
	 * @param string $url URL that is sending the request
	 * @param string &$data Post data being sent
	 * @param integer $timeout Timeout in seconds
	 * @param string $referer
	 * 
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
		
		return array(
			'is_successful'	=> 'true',
			'header'		=> $header,
			'content'		=> $content
		);
	}
}
// End of PostRequest Class

/* EOF lib/PostRequest.php */
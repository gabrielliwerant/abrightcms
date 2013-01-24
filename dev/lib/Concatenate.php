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
 * Concatenate Class
 * 
 * Allows us to load many files back-to-back in a single page for concatenation
 * purposes.
 * 
 * @subpackage
 * @author Gabriel Liwerant
 */
class Concatenate
{
	/**
	 * Stores our header for when we load page with files
	 *
	 * @var string $_header 
	 */
	private $_header;
	
	/**
	 * Stores path we use to load files for concatenation
	 *
	 * @var string $_path
	 */
	private $_path;
	
	/**
	 * Stores list of files to concatenate as array
	 *
	 * @var array $_file_arr
	 */
	private $_file_arr;
	
	/**
	 * Our constructor sets all the parameters we'll need to run the 
	 * concatenator.
	 * 
	 * @param string $header
	 * @param string $path
	 * @param array $file_arr
	 */
	public function __construct($header, $path, $file_arr)
	{
		$this->_setHeader($header)
			->_setPath($path)
			->_setFileArr($file_arr);
	}

	/**
	 * Setter for header
	 *
	 * @param string $header Tells us how to load files on the page
	 * @return object Concatenate
	 */
	private function _setHeader($header)
	{
		$this->_header = $header;
		
		return $this;
	}
	
	/**
	 * Setter for path
	 *
	 * @param string $path Path for loading files to concatenate
	 * @return object Concatenate 
	 */
	private function _setPath($path)
	{
		$this->_path = $path;
		
		return $this;
	}
	
	/**
	 * Setter for file array
	 *
	 * @param array $file_arr
	 * @return object Concatenate 
	 */
	private function _setFileArr($file_arr)
	{
		$this->_file_arr = $file_arr;
		
		return $this;
	}
	
	/**
	 * Loads the page with the appropriate header and all the files we're 
	 * concatenating, then exit.
	 */
	public function loadPageConcatenator()
	{
		header($this->_header);

		foreach ($this->_file_arr as $file)
		{
			include $this->_path . $file;
		}
		
		exit();
	}
}
// End of Concatenate Class

/* EOF dev/lib/Concatenate.php */
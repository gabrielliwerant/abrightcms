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
 * View Class
 * 
 * Contains the methods necessary to build and render the standard pieces of the
 * template. They are stored as strings to be echoed in the view pages.
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 */
class View
{
	/**
	 * Nothing to see here...
	 */
	public function __construct()
	{
		//
	}
	
	/**
	 * Builds the meta tags for the head view.
	 * 
	 * @param string $type Type section of meta tag
     * @param string $value Content section of meta tag
     * @return string Completed meta tag or error message
	 */
	public function buildHeadMeta($type, $value)
	{
		if (is_string($type) AND is_string($value))
		{
            $meta = '<meta ' . $type . ' content="' . $value . '" />';
		}
		else
		{
			$meta = 'Incorrect Data Type for Meta';
		}
        
        return $meta;
	}
	
	/**
	 * Builds the css link tags for the head view.
	 * 
	 * @param string $name CSS file name
	 * @param string $cache_buster Appends query string to bust cache
     * @return string Completed CSS link tag or error message
	 */
	public function buildHeadCss($name, $cache_buster = null)
	{
		if (is_string($name))
		{
			$css = '<link rel="stylesheet" href="' . CSS_PATH . '/' . $name . '.css' . $cache_buster . '" />';
		}
		else
		{
			$css = 'Incorrect Data Type for CSS';
		}
        
        return $css;
	}

	/**
	 * Builds the header navigation for the header view.
	 * 
	 * @param string $name Name of navigation item
	 * @param string $path Navigation path
     * @return string Navigation item or error message
	 */
	public function buildHeaderNav($name, $path)
	{
		if (is_string($name) AND is_string($path))
		{
			$header_nav = '<li><a href="' . HTTP_ROOT_PATH . '/' . $path .'" target="_self">' . $name . '</a></li>';
		}
		else
		{
			$header_nav = 'Incorrect Data Type for Header Navigation';
		}
        
        return $header_nav;
	}
	
	/**
	 * Builds the starting copyright section for the footer in our view.
	 * 
	 * @param string array $footer_data Used to build the copyright section
	 */
	public function buildFooterCopyrightStart($value)
	{
		if (is_string($value))
		{			
            $footer_copyright_start = $value . ' ';
		}
		else
		{
			$footer_copyright_start = 'Incorrect Data Type for Footer Copyright';
		}
        
        return $footer_copyright_start;
	}
    
    /**
     * Used to build the end date section of the copyright part of the footer in
     * our view.
     * 
     * @param string $start_date Begin date will help determine if we show end
     * @return string Completed end data section
     */
    public function buildFooterCopyrightEnd($start_date)
    {
        if ((int)$start_date < (int)date('Y'))
        {
            $footer_copyright_end = '- ' . date('Y');
        }
        else
        {
            $footer_copyright_end = '';
        }
        
        return $footer_copyright_end;
    }
	
	/**
	 * Builds the script tags for the javascript we include in our footer.
	 * 
	 * @param string $file_name Name used to build the script tags
	 * @param string $cache_buster Appends query string to bust cache
	 * @return string Script tag with file.
	 */
	public function buildFooterJs($file_name, $cache_buster = null)
	{
		if (is_string($file_name))
		{
			$footer_js = "<script src=" . JS_PATH . '/' . $file_name . ".js" . $cache_buster . "></script>";
		}
		else
		{
			$footer_js = 'Incorrect Data Type for Footer Javascript';
		}

		return $footer_js;
	}
	
	/**
	 * Calls the body view file for display depending upon the page name.
	 * 
	 * @param string $page_name The name of the page gathered from the bootstrap
	 */
	public function renderPage($page_name)
	{
		require_once TEMPLATE_PATH	. '/head.php'; 
		require_once TEMPLATE_PATH	. '/header.php';
		require_once VIEW_PATH		. '/' . $page_name . '/index.php';
		require_once TEMPLATE_PATH	. '/footer.php';
	}
}
// End of View Class

/* EOF lib/View.php */
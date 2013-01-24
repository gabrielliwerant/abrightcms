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
	 * Error codes for View
	 */
	const INCORRECT_DATA_TYPE_FOR_META_TAG	= 1001;
	
	/**
	 * Nothing to see here...
	 */
	public function __construct()
	{
		//
	}
	
	/**
	 * Build IE conditional tags with embeded code.
	 *
	 * @param string $conditional The conditional statement to use
	 * @param string $embed Any code to embed in the statement
	 * 
	 * @return string Built IE conditional with embeded code
	 */
	private function _buildIeConditional($conditional, $embed)
	{
		$conditional = '<!--[if ' . $conditional . ']>' . $embed . '<![endif]-->';
		
		return $conditional;
	}
	
	/**
	 * Take an array of key => values and build a list of attributes out of it.
	 *
	 * @param array $attribute_data
	 * 
	 * @return string 
	 */
	private function _buildAttributeList($attribute_data)
	{
		$attribute_list = null;
		foreach ($attribute_data as $key => $value)
		{
			if ( ! empty($value))
			{
				$attribute		= $key . '="' . $value . '"';
				$attribute_list	.= $attribute . ' ';
			}
		}
		
		return $attribute_list;
	}
	
	/**
	 * Builds the meta tags for the head view.
	 * 
	 * @param string $type Type section of meta tag
     * @param string $value Content section of meta tag
	 * 
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
			throw new MyException(ApplicationFactory::makeLogger(), 'View Exception', self::INCORRECT_DATA_TYPE_FOR_META_TAG);
		}
        
        return $meta;
	}
	
	/**
	 * Builds the HTML for a favicon.
	 *
	 * @param array $favicon_data Data used to build favicon
	 * @param string $cache_buster Optional random string to force re-caching
	 * 
	 * @return string Built HTML for favicon
	 */
	public function buildFavicon($favicon_data, $cache_buster = null)
	{
		if ((boolean)$favicon_data['is_internal'])
		{
			$favicon = '<link href="' . IMAGES_PATH . '/favicon.ico' . $cache_buster . '" rel="shortcut icon" />';
		}
		else
		{
			$favicon = '<link href="' . $favicon_data['href'] . $cache_buster . '" rel="shortcut icon" />';
		}
		
		if ($favicon_data['ie_conditional'] !== '')
		{
			$favicon = $this->_buildIeConditional($favicon_data['ie_conditional'], $favicon);
		}
        
        return $favicon;
	}
	
	/**
	 * Build the HTML link tag for CSS files.
	 *
	 * @param string $name CSS file name
	 * @param array $css_data CSS file associated data
	 * @param string $cache_buster Appends query string to bust cache
	 * 
	 * @return string Built CSS link tag
	 */
	public function buildHeadCss($name, $css_data, $cache_buster = null)
	{
		if ((boolean)$css_data['is_internal'])
		{			
			$css = '<link rel="stylesheet" href="' . CSS_PATH . '/' . $name . '.css' . $cache_buster . '" />';
		}
		else
		{
			$css = '<link rel="stylesheet" href="' . $css_data['href'] . $cache_buster . '" />';
		}
		
		if ($css_data['ie_conditional'] !== '')
		{
			$css = $this->_buildIeConditional($css_data['ie_conditional'], $css);
		}
        
        return $css;
	}
	
	/**
	 * Build the script tags for JS files in the head section.
	 *
	 * @param array $js_data JS file associated data
	 * @param string $cache_buster Appends query string to bust cache
	 * 
	 * @return string Built script tag for JS file
	 */
	public function buildJs($js_data, $cache_buster = null)
	{
		$cache_buster = null;
		
		if ((bool)$js_data['is_internal'])
		{
			if ( ! empty($js_data['src']))
			{
				$src = 'src="' . JS_PATH . '/' . $js_data['src'] . '.js' . $cache_buster . '"';
			}
			else
			{
				$src = null;
			}
			
			if ( ! isset($js_data['code']) OR empty($js_data['code']))
			{
				$code = null;
			}
			else
			{
				$code = $js_data['code'];
			}
			
			$js = '<script ' . $src . '>' . $code . '</script>';
		}
		else
		{
			$src = 'src="' . $js_data['src'] . '"';
			
			if ( ! isset($js_data['code']) OR empty($js_data['code']))
			{
				$code = null;
			}
			else
			{
				$code = $js_data['code'];
			}
			
			$js = '<script ' . $src . '>' . $code . '</script>';
		}
		
		if ( ! empty($js_data['ie_conditional']))
		{
			$js = $this->_buildIeConditional($js_data['ie_conditional'], $js);
		}

        return $js;
	}
	
	/**
	 * Build an HTML anchor tag.
	 *
	 * @param string $text Text for anchor tag display
	 * @param string $path Used to build the href attribute
	 * @param boolean $is_internal If href is local or remote
	 * @param string $target Anchor tag target element
	 * @param string $title Anchor tag title element
	 * @param string $class Anchor tag class
	 * @param string $id Anchor tag id
	 * 
	 * @return string Built HTML anchor tag
	 */
	public function buildAnchorTag(
		$text,
		$path, 
		$is_internal,
		$target		= '_blank',
		$title		= null,
		$class		= null,
		$id			= null
	)
	{
		if ((boolean)$is_internal)
		{
			$href = HTTP_ROOT_PATH . '/' . $path;
		}
		else
		{
			$href = $path;
		}
		
		// Array to loop through in attribute builder method
		$anchor_data['href']	= $href;
		$anchor_data['target']	= $target;
		$anchor_data['title']	= $title;
		$anchor_data['class']	= $class;
		$anchor_data['id']		= $id;
		
		$attribute_list	= $this->_buildAttributeList($anchor_data);		
		$anchor			= '<a ' . $attribute_list . '>' . $text . '</a>';
		
		return $anchor;
	}
	
	/**
	 * Builds the header navigation for the header view.
	 *
	 * @param string $nav The HTML for the navigation item
	 * @param string $list_class CSS class to use with list item 
	 * @param string $separator_string Separating HTML between items
	 * 
	 * @return string Built navigation item or error message
	 */
	public function buildNav($nav, $list_class, $separator_string = null)
	{
		if ( ! empty($separator_string))
		{
			$separator	= '<span class="separator">' . $separator_string . '</span>';
		}
		else
		{
			$separator = null;
		}
		
		$header_nav	= '<li class="' . $list_class . '">' . $nav . $separator . '</li>';
		
		return $header_nav;
	}
	
	/**
	 * Build the HTML for the copyright.
	 *
	 * @param array $copyright_data Data pertaining to copyright information
	 * @param string $separator Optional separator string to append
	 * @param boolean $show_current_date Whether or not we show the current date
	 * 
	 * @return string Built HTML copyright from data
	 */
	public function buildCopyright($copyright_data, $separator = null, $show_current_date = true)
	{
		$copyright	= $copyright_data['symbol'];
		$copyright	.= ' ' . $copyright_data['holder'];
		$copyright	.= ' ' . $copyright_data['start_date'];
		
		if ($show_current_date)
		{
			if ((int)$copyright_data['start_date'] < (int)date('Y'))
			{
				$copyright .= ' - ' . date('Y');
			}
		}
		
		$separator	= '<span class="separator">' . $separator . '</span>';		
		$copyright	= '<li>' . $copyright . $separator . '</li>';
		
		return $copyright;
	}
    
	/**
	 * Builds the brand logo section.
	 *
	 * @param string $src Img tag src attribute
	 * @param string $alt Img tag alt attribute
	 * @param string $id Img tag id
	 * 
	 * @return string Prepared HTML for logo with anchor tag
	 */
	public function buildBrandingLogo($src, $alt, $id = null)
	{
		$src = IMAGES_PATH . '/' . $src;
		
		// Array to loop through in attribute builder method
		$img_data['src']	= $src;
		$img_data['alt']	= $alt;
		$img_data['id']		= $id;
		
		$attribute_list	= $this->_buildAttributeList($img_data);		
		$logo			= '<img ' . $attribute_list . '/>';	
		
		return $logo;
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
<?php if ( ! defined('DENY_ACCESS')) exit('403: No direct file access allowed');

/**
 * A Bright CMS
 *
 * Open source, lightweight, web application framework and content management 
 * system in PHP.
 * 
 * @package A Bright CMS
 * @author Gabriel Liwerant
 */

/**
 * DefaultBlogPageView Class
 * 
 * Use this to provide child classes with shared page view methods.
 * 
 * @subpackage views/_includes
 * @author Gabriel Liwerant
 * 
 * @uses View
 */
class DefaultBlogPageView extends View
{
	/**
	 * Construct the parent class.
	 */
	public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Build content paragraphs HTML.
	 *
	 * @param array $content
	 * 
	 * @return string HTML 
	 */
	public function buildContentParagraph($content)
	{
		$paragraph_list = null;
		
		foreach ($content as $paragraph)
		{
			$paragraph_list .= $this->buildGenericHtmlWrapper('p', $paragraph);
		}
		
		return $paragraph_list;
	}
	
	/**
	 * Build content code HTML.
	 *
	 * @param array $code_list_content
	 * 
	 * @return string HTML
	 */
	public function buildContentCodeList($code_list_content)
	{
		$code_list = null;
		
		foreach ($code_list_content as $code_item)
		{
			$code_list .= '<li><code>' . $code_item . '</code></li>';
		}
		
		return '<pre><ol>' . $code_list . '</ol></pre>';
	}
	
	/**
	 * Build content inner lists HTML.
	 *
	 * @param array $content_list
	 * @param string $type
	 * 
	 * @return string HTML
	 */
	public function buildContentInnerList($content_list, $type)
	{
		$list = null;
		
		foreach ($content_list as $list_item)
		{
			$list .= $this->buildGenericHtmlWrapper('li', $list_item);
		}
		
		switch ($type)
		{
			case 'unordered' :
				$final_list = $this->buildGenericHtmlWrapper('ul', $list);
				break;
			case 'ordered' :
				$final_list = $this->buildGenericHtmlWrapper('ol', $list);
				break;
		}
		
		return $final_list;
	}
}

// End of DefaultBlogPageView Class

/* EOF application/views/_includes/DefaultBlogPageView.php */
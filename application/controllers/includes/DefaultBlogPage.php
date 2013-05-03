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
 * DefaultBlogPage Class
 * 
 * Creates default blog page so that child classes do not need to duplicate 
 * code. Contains no index method because we are not meant to call this class 
 * directly.
 * 
 * This class may be suitable for any page with a submenu if the only 
 * difference between pages in the submenu is the content displayed.
 * 
 * @subpackage controllers/includes
 * @author Gabriel Liwerant
 * 
 * @uses Controller
 */
class DefaultBlogPage extends Controller
{
	/**
	 * Construct the parent class.
	 * 
	 * @param object $model Pass the model we want to store in the controller
	 * @param object $view Pass the view we want to store in the controller
	 */
	public function __construct($model, $view)
	{
		parent::__construct($model, $view);
	}
	
	/**
	 * Build subsections of the content.
	 *
	 * @param array $content_data
	 * 
	 * @return string 
	 */
	protected function _buildContentSubData($content_data)
	{
		$learn_content = null;
		
		foreach ($content_data as $sub_data)
		{
			switch ($sub_data['type'])
			{
				case 'list-unordered':
					$learn_content .= $this->_view->buildContentInnerList($sub_data['content'], 'unordered');
					break;
				case 'list-ordered':
					$learn_content .= $this->_view->buildContentInnerList($sub_data['content'], 'ordered');
					break;
				case 'code':
					$learn_content .= $this->_view->buildContentCodeList($sub_data['content']);
					break;
				default:
					$learn_content .= $this->_view->buildContentParagraph($sub_data['content']);
					break;
			}
		}

		return $learn_content;
	}
	
	/**
	 * Set the current section content into view property.
	 *
	 * @param array $content_data
	 * 
	 * @return object Learn 
	 */
	protected function _setContent($content_data)
	{
		$this->_view->content_section = null;

		if (is_array($content_data))
		{
			foreach ($content_data as $data)
			{
				$title		= isset($data['title']) ? $this->_view->buildGenericHtmlWrapper('h2', $data['title']) : null;				
				$content	= $this->_buildContentSubData($data['content']);

				$this->_view->content_section .= $this->_view->buildGenericHtmlWrapper('div', $title . $content);
			}
		}
		
		return $this;
	}
	
	/**
	 * @kludge needs refactoring, consider requiring index method for defaults 
	 *		and some overwriting in child classes.
	 *
	 * @param type $data
	 * @param type $class
	 * @param type $parameter
	 * @param type $storage_type
	 * 
	 * @return DefaultBlogPage 
	 */
	protected function _setBlogPageData(&$data, $class, $parameter, $storage_type)
	{
		$data['page_name']		= $class;
		$data['submenu_title']	= $parameter !== $data['page_name'] ? $parameter : null;

		$storage_path	= $this->_model->getStorageTypePath($storage_type);		
		$full_path		= $parameter !== $data['page_name'] ? $storage_path . '/' . $data['page_name'] . '/' . $data['submenu_title'] . '.json' : $storage_path . '/' . $data['page_name'] . '.json';
		
		$this->_model->setDataIntoStorage($full_path, $data['submenu_title']);
		
		if ($parameter !== $data['page_name'])
		{
			$data['content_section'] = $this->_model->getDataFromStorage($data['submenu_title']);
		}
		else
		{
			$this->_model->setFilesFromDirectoryIntoStorage($storage_path . '/' . $data['page_name'], $storage_type);
			$dir_files_arr		= $this->_model->getStorageFilesFromDirectory($storage_path . '/' . $data['page_name'], $storage_type);
			$nav_arr_to_build	= $this->_model->getSortedSubNavArray($dir_files_arr, $data['page_name'] . '/index/');
			
			foreach ($dir_files_arr as $arr)
			{
				if ((int)$arr['ordering'] === 1)
				{
					$data['content_section'] = $arr;
				}
			}
		}
		
		return $this;
	}
	
	/**
	 * Call any methods necessary to build out page-specific elements and set
	 * them as view properties for viewing.
	 *
	 * @param array $data From storage to build out page views
	 * @param string|void $cache_buster Allows us to force re-caching
	 * 
	 * @return object Returned from parent method
	 */
	protected function _pageBuilder($data, $cache_buster = null)
	{
		$this 
			->_setHeadIncludesLink($data['template']['head']['head_includes']['links'], $cache_buster)
			->_setNav('header_nav', $data['header']['header']['header_nav'], $data['header']['header']['separator'])
			->_setSubNav('/' . $data['page_name'], STORAGE_TYPE, $data['page_name'] . '/index/', $data['content_section']['nav'])
			->_setLogo('header_logo', $data['header']['header']['branding']['logo'])
			->_setViewProperty('site_name', $data['header']['header']['branding']['logo']['text'])
			->_setViewProperty('tagline', $data['header']['header']['branding']['tagline'])
			->_setFinePrint($data['template']['footer']['fine_print'], $data['template']['footer']['separator'])
			->_setLogo('footer_logo', $data['template']['footer']['branding']['logo'])
			->_setNav('footer_nav', $data['template']['footer']['footer_nav'], $data['template']['footer']['separator']);
		
		if ( ! empty($data['submenu_title']) AND isset($data['template']['head']['title_page'][$data['page_name']]['submenu'][$data['submenu_title']]) )
		{
			$this->_setTitleSubpage($data['template']['head']['title_page'][$data['page_name']]['submenu'][$data['submenu_title']], '|');
		}
		
		return parent::_pageBuilder($data['template'], $cache_buster);
	}
}
// End of DefaultBlogPage Class

/* EOF application/controllers/includes/DefaultBlogPage.php */
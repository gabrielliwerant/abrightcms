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
	 * Get the sub menu title, which will depend upon the page we called.
	 * 
	 * @todo consider placing in model.
	 * @todo maybe we should find the first article name here instead of null
	 *
	 * @param string $sub_menu_page
	 * @param string $child_class_name
	 * 
	 * @return string 
	 */
	protected function _getSubMenuTitle($sub_menu_page, $child_class_name)
	{
		if ($sub_menu_page !== $child_class_name)
		{
			$sub_title = $sub_menu_page;
		}
		else
		{
			$sub_title = key($this->_model->getFirstArticleFromStorage($child_class_name));
		}

		return $sub_title;
	}
	
	/**
	 * After setting blog page data, get the appropriate data as array depending
	 * upon which page we called in the API.
	 * 
	 * @param string $sub_menu_name
	 * @param string $child_class_name
	 * 
	 * @return array 
	 */
	protected function _getBlogContentSection($sub_menu_name, $child_class_name)
	{
		if ($sub_menu_name !== $child_class_name)
		{
			return $this->_model->getDataFromStorage($this->_getSubMenuTitle($sub_menu_name, $child_class_name));
		}
		else
		{
			$article_arr = $this->_model->getFirstArticleFromStorage($child_class_name);
			
			return reset($article_arr);
		}
	}
	
	/**
	 * Set blog articles data into storage.
	 * 
	 * If we know the sub menu page, set only that data. If we don't, we must 
	 * set it all so we can later choose the one we want.
	 *
	 * @param string $sub_menu_name
	 * @param string $child_class_name
	 * 
	 * @return object DefaultBlogPage 
	 */
	protected function _setBlogPageData($sub_menu_name, $child_class_name)
	{
		if ($sub_menu_name !== $child_class_name)
		{
			$sub_title = $this->_getSubMenuTitle($sub_menu_name, $child_class_name);
			$full_path = $this->_model->getFullSubMenuPathToStorageData($sub_menu_name, $child_class_name, $sub_title);
			$this->_model->setDataIntoStorage($full_path, $sub_title);
		}
		else
		{
			$storage_path = $this->_model->getStorageTypePath(STORAGE_TYPE);
			$this->_model->setFilesFromDirectoryIntoStorage($storage_path . '/' . $child_class_name, STORAGE_TYPE);
		}

		return $this;
	}
	
	/**
	 * Call any methods necessary to build out page-specific elements and set
	 * them as view properties for viewing.
	 * 
	 * @param array $data From storage to build out page views
	 * @param string $child_class_name
	 * @param string|void $cache_buster Allows us to force re-caching
	 * 
	 * @return object Controller Returned from parent method
	 */
	protected function _pageBuilder($data, $child_class_name, $cache_buster = null)
	{
		$this
			->_setHeadIncludesLink($data['template']['head']['head_includes']['links'], $cache_buster)
			->_setNav('header_nav', $data['header']['header']['header_nav'], $data['header']['header']['separator'])
			->_setSubNav('/' . $child_class_name, $child_class_name . '/index/', $data['content_section']['nav'])
			->_setLogo('header_logo', $data['header']['header']['branding']['logo'])
			->_setViewProperty('site_name', $data['header']['header']['branding']['logo']['text'])
			->_setViewProperty('tagline', $data['header']['header']['branding']['tagline'])
			->_setFinePrint($data['template']['footer']['fine_print'], $data['template']['footer']['separator'])
			->_setLogo('footer_logo', $data['template']['footer']['branding']['logo'])
			->_setNav('footer_nav', $data['template']['footer']['footer_nav'], $data['template']['footer']['separator'])
			->_setTitleSubPage($data['template']['head']['title_page'][$child_class_name]['submenu'], $data['sub_menu_title'], '|');
		
		return parent::_pageBuilder($data['template'], $child_class_name, $cache_buster);
	}
}
// End of DefaultBlogPage Class

/* EOF application/controllers/includes/DefaultBlogPage.php */
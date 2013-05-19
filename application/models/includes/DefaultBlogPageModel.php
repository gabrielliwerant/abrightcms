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
 * DefaultBlogPageModel Class
 * 
 * Use this to provide child classes with shared page model methods.
 * 
 * @subpackage models/includes
 * @author Gabriel Liwerant
 * 
 * @uses Model
 */
class DefaultBlogPageModel extends Model
{
	/**
	 * Call the parent constructor and pass it objects.
	 * 
     * @param object $storage Data storage object
	 * @param string $storage_type The way data is stored and retrieved
	 * @param object $log Log object for errors, other
	 * @param object|void $db
	 */
	public function __construct($storage_obj, $storage_type, $log, $db = null)
	{
		parent::__construct($storage_obj, $storage_type, $log, $db);
	}

	/**
	 * Get the full path we'll need to hunt for data.
	 *
	 * @param string $sub_menu
	 * @param string $page_name
	 * @param string $sub_directory
	 * 
	 * @return string 
	 */
	public function getFullSubMenuPathToStorageData($sub_menu, $page_name, $sub_directory)
	{
		$storage_path	= $this->getStorageTypePath(STORAGE_TYPE);
		$full_path	= $storage_path . '/' . $page_name;
		
		if ($sub_menu !== $page_name)
		{
			$full_path .= '/' . $sub_directory;
		}
		
		return $full_path . '.' . strtolower(STORAGE_TYPE);
	}
	
	/**
	 * Creates a subnav array for later building a subnav from an array of files
	 *
	 * @param array $file_arr
	 * @param string $api_path
	 * 
	 * @return array Sorted nav data
	 */
	public function	getSortedSubNavArray($file_arr, $api_path)
	{
		foreach ($file_arr as $file_name => $file)
		{
			$partial_href = $api_path . $file_name;

			// Use ordering provided for array keys so we can sort
			$nav_arr_to_build[(int)$file['ordering']] = array(
				'partial_href'	=> $partial_href, 
				'nav'			=> $file['nav']
			);
		}
		
		ksort($nav_arr_to_build);
		
		return $nav_arr_to_build;
	}
	
	/**
	 * Search through articles from storage and return the first according to
	 * ordering.
	 * 
	 * @todo return null on failure?
	 *
	 * @param string $sub_directory
	 * 
	 * @return array Contained in array as key => value
	 */
	public function getFirstArticleFromStorage($sub_directory)
	{
		$storage_path	= $this->getStorageTypePath(STORAGE_TYPE);
		$article_arr	= $this->getStorageFilesFromDirectory($storage_path . '/' . $sub_directory, STORAGE_TYPE);

		foreach ($article_arr as $file_name => $article)
		{
			if ((int)$article['ordering'] === 1)
			{
				return array($file_name => $article);
			}
		}
	}
}
// End of DefaultBlogPageModel Class

/* EOF application/models/_includes/DefaultBlogPageModel.php */
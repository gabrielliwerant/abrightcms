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
 * Controller Class
 * 
 * Base controller for the entire application.
 * 
 * Create a new model and send it the data from json files required to load 
 * default conditions. Then we can render a default page.
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 */
Class Controller
{	
	/**
	 * Holds an instance of the base model
	 *
	 * @var object $_model
	 */
	protected $_model;
	
	/**
	 * Holds an instance of the base view
	 *
	 * @var object $_view
	 */
	protected $_view;
	
	/**
	 * Upon construction we store the model object and the view object.
	 *  
	 * @param object $model Model object we store and use in the controller
	 * @param object $view View object we store and use in the controller
	 */
	public function __construct($model, $view)
	{
		$this->_setModel($model)->_setView($view);
	}
	
	/**
	 * Model setter
	 *
	 * @param object $model 
	 * 
	 * @return object Controller
	 */
	protected function _setModel($model)
	{
		$this->_model = $model;
		
		return $this;
	}
	
	/**
	 * View setter
	 *
	 * @param object $view 
	 * 
	 * @return object Controller
	 */
	protected function _setView($view)
	{
		$this->_view = $view;
		
		return $this;
	}
	
    /**
     * Set the view properties for the rendering of the basic HTML head 
     * information.
     * 
     * @param string array $head_data HTML document data for head section
	 * 
	 * @return object Controller
     */
    private function _setHeadDoc($head_data)
    {
        foreach($head_data as $key => $value)
		{
			$this->_view->$key = $value;
		}
		
		return $this;
    }
	
    /**
     * Set the view property for the rendering of the head meta tags.
     * 
     * @param string array $head_meta Meta types and values for building
	 * 
	 * @return object Controller
     */
    private function _setHeadMeta($head_meta)
    {
        $this->_view->meta = null;
        
        foreach ($head_meta as $type => $value)
        {
            $this->_view->meta .= $this->_view->buildHeadMeta($type, $value);
        }
		
		return $this;
    }
    
	/**
	 * Set the view property for the head CSS link tags.
	 *
	 * @param array $include_data Data with CSS file names and other info
	 * @param string $cache_buster Optional random string to force re-caching
	 * 
	 * @return object Controller
	 */
	private function _setHeadIncludesCss($include_data, $cache_buster)
	{
		$this->_view->css = null;
        
        foreach ($include_data as $name => $css_data)
        {
            $this->_view->css .= $this->_view->buildHeadCss($name, $css_data, $cache_buster);
        }
		
		return $this;
	}
	
	/**
	 * Sets the favicon in the appropriate view property.
	 *
	 * @param array $favicon_data Data used to build favicon
	 * @param string $cache_buster Optional random string to force re-caching
	 * 
	 * @return object Controller
	 */
	private function _setHeadIncludesFavicon($favicon_data, $cache_buster)
	{
		$this->_view->favicon = $this->_view->buildFavicon($favicon_data, $cache_buster);
		
		return $this;
	}
	
	/**
	 * Set the view property for the head JS script tags.
	 *
	 * @param array $include_data Data with JS file names and other info
	 * @param string $cache_buster Optional random string to force re-caching
	 * 
	 * @return object Controller
	 */
	private function _setHeadIncludesJs($include_data, $cache_buster)
	{
		$this->_view->head_js = null;
		
		foreach ($include_data as $name => $js_data)
		{
			$this->_view->head_js .= $this->_view->buildJs($js_data, $cache_buster);
		}
		
		return $this;
	}
	
	/**
     * Sets the view property for the footer JS script tags to be rendered.
     * 
     * @param string array $footer_js_data Names of JS files to load 
     * @param string $cache_buster Optional random string to force re-caching
	 * 
	 * @return object Controller
     */
    private function _setFooterJs($footer_js_data, $cache_buster)
    {
		$this->_view->footer_js = null;
		
		foreach ($footer_js_data as $name => $js_data)
		{
			$this->_view->footer_js .= $this->_view->buildJs($js_data, $cache_buster);
		}
		
		return $this;
    }
    
	/**
	 * Page name view property setter
	 *
	 * @param string $page_name 
	 * 
	 * @return object Controller
	 */
	private function _setPage($page_name)
	{
		$this->_view->page = $page_name;
		
		return $this;
	}

	/**
	 * Setter for the title page view property
	 *
	 * @param array $title_page_arr Map of pages with titles
	 * @param string $key To map to the page controllers
	 * 
	 * @return object Controller 
	 */
	protected function _setHeadTitlePage($title_page_arr, $key)
	{
		$this->_view->title_page = $title_page_arr[$key];
		
		return $this;
	}
	
	/**
	 * Allows us to force re-caching on included files like CSS and JS.
	 *
	 * @param boolean $is_mode_cache_busting Whether or not to add re-cache value
	 * @param string $preexisting_value Any preexisting re-cache value to use
	 * 
	 * @return string The re-cache string to append to files
	 */
	protected function _cacheBuster($is_mode_cache_busting, $preexisting_value = null)
	{
		if ($is_mode_cache_busting)
		{
			if (empty($preexisting_value))
			{
				$cache_buster = $this->_model
					->setKeyGenerator()
					->createStandardKeyFromKeyGenerator('10', array('digital'));
			}
			else
			{
				$cache_buster = $preexisting_value;
			}
		}
		else
		{
			$cache_buster = null;
		}
		
		return '?' . $cache_buster;
	}
	
    /**
     * Set the view property for the rendering of the header navigation.
     * 
     * @param array $header_nav_data Name and other information for header nav
	 * @param string $separator Optional separator in HTML for nav items
	 * 
	 * @return object Controller
     */
    protected function _setHeaderNav($header_nav_data, $separator = null)
    {
        $this->_view->header_nav	= null;
		$i							= 1;        
		
		foreach ($header_nav_data as $nav => $data)
        {
            if ($i === 1)
			{
				$list_class = 'first';
			}			
			elseif ($i === count($header_nav_data))
			{
				$list_class = 'last';
				$separator	= null;
			}
			else
			{
				$list_class= null;
			}
			
			if ((boolean)$data['is_anchor'])
			{			
				$nav = $this->_view->buildAnchorTag(
					$nav,
					$data['path'], 
					$data['is_internal'], 
					$data['target'],
					$data['title']
				);
			}
			
			$this->_view->header_nav .=  $this->_view->buildNav(
				$nav, 
				$list_class, 
				$separator
			);

			$i++;
        }
		
		return $this;
    }
	
	/**
	 * Set the view property for the rendering of the logo in an anchor tag.
	 *
	 * @param string prefix Prefix for view property name
	 * @param array $branding_data Branding values for building HTML
	 * 
	 * @return object Controller
	 */
	protected function _setLogoInAnchorTag($prefix, $branding_data)
	{
		$output_name = $prefix . 'logo';
		
		$logo = $this->_view->buildBrandingLogo(
			$branding_data['logo']['src'],
			$branding_data['logo']['alt'],
			$branding_data['logo']['id']
		);
		
		$this->_view->$output_name = $this->_view->buildAnchorTag(
			$logo, 
			$branding_data['logo']['path'], 
			(boolean)$branding_data['logo']['is_internal'], 
			$branding_data['logo']['target'], 
			$branding_data['logo']['title'],
			$branding_data['logo']['class'],
			$branding_data['logo']['id']
		);
		
		return $this;
	}
    
	/**
	 * Site name view property setter
	 *
	 * @param string $site_name
	 * @return object Controller 
	 */
	protected function _setSiteName($site_name)
	{
		$this->_view->site_name = $site_name;
		
		return $this;
	}
	
	/**
	 * Tagline view property setter
	 *
	 * @param string $tagline
	 * @return object Controller 
	 */
	protected function _setTagline($tagline)
	{
		$this->_view->tagline = $tagline;
		
		return $this;
	}
	
	/**
	 * Set the view property for the rendering of the footer navigation.
	 *
	 * @param array $footer_nav_data Name and other information for footer nav
	 * @param string $separator Optional separator in HTML for nav items
	 * 
	 * @return object Controller
	 */
	protected function _setFooterNav($footer_nav_data, $separator = null)
	{
		$this->_view->footer_nav	= null;		
		$i							= 1;
		
		foreach ($footer_nav_data as $nav => $data)
		{
			if ($nav === 'copyright')
			{
				$this->_view->footer_nav .= $this->
					_view->buildCopyright($data, $separator, true);
			}
			else
			{
				if ((boolean)$data['is_anchor'])
				{
					$nav = $this->_view->buildAnchorTag(
						$nav, 
						$path, 
						$is_internal, 
						$target,
						$title
					);
				}
				
				// If we use a separator, make the last one null
				if ($i === count($footer_nav_data))
				{
					$separator = null;
				}
				
				$this->_view->footer_nav .= $this->_view->buildNav(
					$nav, 
					null, 
					$separator
				);
			}
			
			$i++;
		}
		
		return $this;
	}
	
	/**
	 * Call any methods necessary to build out basic page elements and set them 
	 * as view properties for viewing.
	 * 
	 * @param array $data From storage to build out view properties
	 * @param string $cache_buster Allows us to force re-caching
	 * 
	 * @return object Controller 
	 */
	protected function _pageBuilder($data, $cache_buster)
	{
		$this->_setHeadDoc($data['head']['head_doc'])
			->_setHeadMeta($data['head']['head_meta'])
			->_setHeadIncludesCss($data['head']['head_includes']['head_css'], $cache_buster)
			->_setHeadIncludesFavicon($data['head']['head_includes']['favicon'], $cache_buster)
			->_setHeadIncludesJs($data['head']['head_includes']['head_js'], $cache_buster)
			->_setFooterJs($data['footer']['footer_js'], $cache_buster);

		return $this;
	}
	
	/**
	 * Loads the views for our template from stored JSON data.
	 * 
	 * Call the page builder here to build out basic page elements into view
	 * properties. Then call the view to render the page along with the basic
	 * template pages.
	 *  
	 * @param string $page_name Name of the page we load as the view
	 * @param array $data For building page views from template storage
	 */
	public function render($page_name)
	{
		$this->_setPage($page_name)->_view->renderPage($page_name);
	}
}
// End of Controller Class

/* EOF lib/Controller.php */
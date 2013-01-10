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
	 * Holds an instance of the base view
	 *
	 * @var object $_view
	 */
	protected $_view;
	
	/**
	 * Holds an instance of the base model
	 *
	 * @var object $_model
	 */
	protected $_model;
	
	/**
	 * Upon construction we store the model object and the view object.
	 *  
	 * @param object $view View object we store and use in the controller
	 * @param object $model Model object we store and use in the controller
	 */
	public function __construct($view, $model)
	{
		$this->_view	= $view;		
		$this->_model	= $model;
	}
    
	/**
	 * Factory for key generator objects, allows us to decouple.
	 *
	 * @return object KeyGenerator
	 */
	public function _makeKeyGenerator()
	{
		return new KeyGenerator();
	}
	
	/**
	 * Allows us to force re-caching on included files like CSS and JS.
	 *
	 * @param boolean $is_mode_cache_busting Whether or not to add re-cache value
	 * @param string $preexisting_value Any preexisting re-cache value to use
	 * @return string The re-cache string to append to files
	 */
	protected function _cacheBuster($is_mode_cache_busting, $preexisting_value = null)
	{
		if ($is_mode_cache_busting)
		{
			if (empty($preexisting_value))
			{
				$this->_model->setKeyGenerator($this->_makeKeyGenerator());
			
				$cache_buster = $this->_model->key_gen
					->generateKeyFromStandard(10, array('digital'));
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
     * Set the view properties for the rendering of the basic HTML head 
     * information.
     * 
     * @param string array $head_data HTML document data for head section
     */
    private function _setHeadDoc($head_data)
    {
        foreach($head_data as $key => $value)
		{
			$this->_view->$key = $value;
		}
    }
	
    /**
     * Set the view property for the rendering of the head meta tags.
     * 
     * @param string array $head_meta Meta types and values for building
     */
    private function _setHeadMeta($head_meta)
    {
        $this->_view->meta = null;
        
        foreach ($head_meta as $type => $value)
        {
            $this->_view->meta .= $this->_view->buildHeadMeta($type, $value);
        }
    }
    
	/**
	 * Set the view property for the head CSS link tags.
	 *
	 * @param array $include_data Data with CSS file names and other info
	 * @param string $cache_buster Optional random string to force re-caching
	 */
	private function _setHeadIncludesCss($include_data, $cache_buster)
	{
		$this->_view->css = null;
        
        foreach ($include_data as $name => $css_data)
        {
            $this->_view->css .= $this->_view->buildHeadCss($name, $css_data, $cache_buster);
        }
	}
	
	/**
	 * Sets the favicon in the appropriate view property.
	 *
	 * @param array $favicon_data Data used to build favicon
	 * @param string $cache_buster Optional random string to force re-caching
	 */
	private function _setHeadIncludesFavicon($favicon_data, $cache_buster)
	{
		$this->_view->favicon = $this->_view->buildFavicon($favicon_data, $cache_buster);				
	}
	
	/**
	 * Set the view property for the head JS script tags.
	 *
	 * @param array $include_data Data with JS file names and other info
	 * @param string $cache_buster Optional random string to force re-caching
	 */
	private function _setHeadIncludesJs($include_data, $cache_buster)
	{
		$this->_view->head_js = null;
		
		foreach ($include_data as $name => $js_data)
		{
			$this->_view->head_js .= $this->_view->buildJs($js_data, $cache_buster);
		}
	}
	
    /**
     * Set the view property for the rendering of the header navigation.
     * 
     * @param array $header_nav_data Name and other information for header nav
	 * @param string $separator Optional separator in HTML for nav items
     */
    protected function _setHeaderNav($header_nav_data, $separator = null)
    {
        $this->_view->header_nav	= null;
		$nav_count					= count($header_nav_data);
		$i							= 1;        
		
		foreach ($header_nav_data as $nav => $data)
        {
            if ($i === 1)
			{
				$list_class = 'first';
			}			
			elseif ($i === $nav_count)
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
    }
	
	/**
	 * Set the view property for the rendering of the branding section of the 
	 * header.
	 *
	 * @param string prefix Prefix for view property name
	 * @param array $branding_data Branding values for building HTML
	 */
	protected function _setBranding($prefix, $branding_data)
	{
		$output_name = $prefix . 'logo';
		
		$this->_view->$output_name = $this->_view->buildBrandingLogo(
			$branding_data['logo']['src'],
			$branding_data['logo']['alt'],
			$branding_data['logo']['text'],
			$branding_data['logo']['path'],
			(boolean)$branding_data['logo']['is_internal'],
			$branding_data['logo']['target'],
			$branding_data['logo']['title']
		);
		
		if ( ! empty($branding_data['tagline']))
		{
			$this->_view->tagline = $branding_data['tagline'];
		}
	}
    
	/**
	 * Set the view property for the rendering of the footer navigation.
	 *
	 * @param array $footer_nav_data Name and other information for footer nav
	 * @param string $separator Optional separator in HTML for nav items
	 */
	protected function _setFooterNav($footer_nav_data, $separator = null)
	{
		$this->_view->footer_nav = null;
		
		$nav_count	= count($footer_nav_data);
		$i			= 1;
		
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
				if ($i === $nav_count)
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
	}
	
    /**
     * Sets the view property for the footer JS script tags to be rendered.
     * 
     * @param string array $footer_js_data Names of JS files to load 
     * @param string $cache_buster Optional random string to force re-caching
     */
    private function _setFooterJs($footer_js_data, $cache_buster = null)
    {
		$this->_view->footer_js = null;
		
		foreach ($footer_js_data as $name => $js_data)
		{
			$this->_view->footer_js .= $this->_view->buildJs($js_data, $cache_buster);
		}
    }
    
	/**
	 * Loads the views for our template from stored JSON data.
	 * 
	 * We call all the methods needed to construct our view here. Usually, only
	 * the page will change, but we can optionally use arguments to override the
	 * defaults in the individual methods. Loading a different set of views for
	 * our page should be done by overriding this method in a child controller.
	 *  
	 * @param string $page_name Name of the page we load as the view
	 */
	public function render($page_name)
	{
		$template = $this->_model->getDataFromStorage('template');
		
		$cache_buster = $this->_cacheBuster(IS_MODE_CACHE_BUSTING, CACHE_BUSTING_VALUE);
		
		// Build out the basic view template pages with the JSON data
		$this->_setHeadDoc($template['head']['head_doc']);
		$this->_setHeadMeta($template['head']['head_meta']);
		$this->_setHeadIncludesCss($template['head']['head_includes']['head_css'], $cache_buster);
		$this->_setHeadIncludesFavicon($template['head']['head_includes']['favicon'], $cache_buster);
		$this->_setHeadIncludesJs($template['head']['head_includes']['head_js'], $cache_buster);
		$this->_setFooterJs($template['footer']['footer_js'], $cache_buster);

		$this->_view->renderPage($page_name);
	}
}
// End of Controller Class

/* EOF lib/Controller.php */
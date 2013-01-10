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
 * Controller Class
 * 
 * Base controller for the entire application.
 * 
 * Create a new model and send it the data from json files required to load 
 * default conditions. Then we can render a default page.
 * 
 * @subpackage lib
 * @author Gabriel Liwerant
 * 
 * @param object $_view Holds an instance of the base view
 * @param object $_model Holds an instance of the base model
 */
Class Controller
{	
	protected $_view;
	protected $_model;
	
	/**
	 * Upon construction we store the model object and the view object.
	 *  
	 * @param object $view View object we store and use in the controller
	 * @param object $model Model object we store and use in the controller
	 */
	public function __construct($view, $model)
	{
		$this->_view = $view;		
		$this->_model = $model;
	}
    
    /**
     * Set the view properties for the rendering of the basic HTML head 
     * information.
     * 
     * @param string array $head_data HTML document data for head section
     */
    private function _setHeadDoc($head_data)
    {
        if (is_array($head_data))
        {
            foreach($head_data as $key => $value)
            {
                $this->_view->$key = $value;
            }
        }
        else
        {
            throw new MyException('Expected Array to Generate HTML Head.');
        }
    }
	
    /**
     * Set the view property for the rendering of the head meta tags.
     * 
     * @param string array $head_meta Meta types and values for building
     */
    private function _setHeadMeta($head_meta)
    {
        $this->_view->meta = '';
        
        foreach ($head_meta as $type => $value)
        {
            $this->_view->meta .= $this->_view->buildHeadMeta($type, $value);
        }
    }
    
    /**
     * Set the view property for the rendering of the head css link tags.
     * 
     * @param string array $head_css_data CSS file names for building
     * @param string $cache_buster Optional random string to force re-caching
     */
    private function _setHeadCss($head_css_data, $cache_buster = null)
    {
        $this->_view->css = '';
        
        foreach ($head_css_data as $value)
        {
            $this->_view->css .= $this->_view->buildHeadCss($value, $cache_buster);
        }
    }
    
    /**
     * Set the view property for the rendering of the header navigation.
     * 
     * @param string array $header_nav_data Name and path of header navigation
     */
    private function _setHeaderNav($header_nav_data)
    {
        $this->_view->header_nav = '';
        
        foreach ($header_nav_data as $name => $path)
        {
            $this->_view->header_nav .= $this->_view->buildHeaderNav($name, $path);
        }
    }
    
    /**
     * Sets the view property for the rendering of the footer copyright 
     * information.
     * 
     * @param string array $footer_copyright_data Footer copyright values
     * @param string $start_date Start date for copyright
     * @param boolean $show_current_date Whether or not to append current date
     */
    private function _setFooterCopyright(
		$footer_copyright_data,
		$start_date,
		$show_current_date = true)
    {
        $this->_view->footer_copyright = '';
        
        foreach ($footer_copyright_data as $value)
        {
            $this->_view->footer_copyright .= $this->_view->buildFooterCopyrightStart($value);
        }
        
        if ($show_current_date)
        {
            $this->_view->footer_copyright .= $this->_view->buildFooterCopyrightEnd($start_date);
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
        // Depending on our development mode, get the correct paths js file
		IS_MODE_PRODUCTION ? $paths_file = 'paths_remote' : $paths_file = 'paths_local';
		
		$this->_view->footer_js = $this->_view->buildFooterJs($paths_file, $cache_buster);
        
		foreach ($footer_js_data as $name)
		{
			$this->_view->footer_js .= $this->_view->buildFooterJs($name, $cache_buster);
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
		$template = $this->_model->getTemplateData();

		// If we are in cache busting mode, get our cache buster value
		if (IS_MODE_CACHE_BUSTING)
		{
			$this->_model->setKeyGenerator(new KeyGenerator());
			
			$cache_buster = '?' . $this->_model->key_gen
				->generateKeyFromStandard(10, array('digital'));
		}
		else
		{
			$cache_buster = null;
		}
		
		// Build out the view template pages with the JSON data
		$this->_setHeadDoc($template['head']['head_doc']);
		$this->_setHeadMeta($template['head']['head_meta']);
        $this->_setHeadCss($template['head']['head_css'], $cache_buster);
        $this->_setHeaderNav($template['header']['header_nav']);
		$this->_setFooterCopyright(
			$template['footer']['footer_copyright'], 
            $template['footer']['footer_copyright']['start_date']
		);		
		$this->_setFooterJs($template['footer']['footer_js'], $cache_buster);

		// Renders the view
		$this->_view->renderPage($page_name);
	}
}
// End of Controller Class

/* EOF lib/Controller.php */
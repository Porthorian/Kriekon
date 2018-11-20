<?php

/**
 * The App class sets up the application.
 *
 * @class App
 */
class App
{

    /**
     * This is the property that grabs the first part
     * of the url after the / and tells us what controller to use.
     *
     * @property controller
     * @type String
     */
    protected $controller = 'HomeController';

    /**
     * This is the property that grabs the second part of the url after the "controller"
     * It tells us which function to use inside of the controller.
     *
     * @property method
     * @type String
     */
    protected $method = 'index';

    // These are params you can use within the controller!
    protected $params = [];

    /**
     * @constructor
	 * 
	 *
	 * Linux is Case sensitive, also it adds an empty string too the url array. Can no longer look at position 0 anymore has to be 1 and 2.
	 * Also need to set up the Linux test environment FTP. So we sadly can no longer work on apache, as we will be making the switch to nginx soon.
     */
    public function __construct()
    {
        $url = $this->parseUrl();
        $new_url = $url[0] . 'controller';
		
        // Check if controller exists.
        if(file_exists('../app/controllers/'.$new_url.'.php'))
        {
            $this->controller = $new_url;
            unset($url[0]);

			require_once('../app/controllers/'.$this->controller.'.php');
			$this->controller = new $this->controller;
			
			
			// Check if method exists.
			if(isset($url[1]))
			{
				if(method_exists($this->controller, $url[1]))
				{
					$this->method = $url[1];
					unset($url[1]);
					// If params, set params, else set empty.
					$this->params = $url ? array_values($url) : [];

					call_user_func_array([$this->controller, $this->method], $this->params);
				}
				else {
					Controller::view('home/404');
				}
			}
			else {
				// If params, set params, else set empty.
				$this->params = $url ? array_values($url) : [];

				call_user_func_array([$this->controller, $this->method], $this->params);
			}
		}
		elseif($new_url == "controller") 
		{
            unset($url[0]);
			
			require_once('../app/controllers/'.$this->controller.'.php');
			$this->controller = new $this->controller;
			// Check if method exists.
			if(isset($url[1]))
			{
				if(method_exists($this->controller, $url[1]))
				{
					$this->method = $url[1];
					unset($url[1]);
				}
			}
			
			// If params, set params, else set empty.
			$this->params = $url ? array_values($url) : [];

			call_user_func_array([$this->controller, $this->method], $this->params);
		}
		else {
			Controller::view('home/404');
		}
    }

    // Explode and trim the sanitized url. It allows access to the different parts of the url.
    public function parseUrl()
    {
        if(isset($_GET['url']))
        {
            return $url = explode('/',filter_var(rtrim($_GET['url'], ''), FILTER_SANITIZE_URL));
        }
    }

}

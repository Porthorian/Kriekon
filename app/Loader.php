<?php
require_once('core/Settings.php');
require_once('core/Config.php');
class Loader
{
	
	/**
     * Core Directory Path
     *
     * @var Array
     * @access protected
     */
	protected $_coreDirectoryPath = array();
    /**
     * Controller Directory Path
     *
     * @var Array
     * @access protected
     */
	
    protected $_controllerDirectoryPath = array();
    
    /**
     * Model Directory Path
     *
     * @var Array
     * @access protected
     */
    protected $_modelDirectoryPath = array();
    
    /**
     * Library Directory Path
     *
     * @var Array
     * @access protected
     */
    protected $_libraryDirectoryPath = array();
    
    
    /** 
     * Constructor
     * Constant contain my full path to Model, View, Controllers and Lobrary-
     * Direcories.
     *
     * @Constant MPATH,VPATH,CPATH,LPATH
     */
     
    public function __construct()
    {
		$root = Config::get('site/root');
   		$ds = Config::get('site/DS');
		
		$this->coreDirectoryPath = $root.$ds.'core'.$ds;
        $this->modelDirectoryPath = $root.$ds.'model'.$ds;
        $this->controllerDirectoryPath = $root.$ds.'controllers'.$ds;
		//$this->viewDirectoryPath        = VPATH;
        //$this->libraryDirectoryPath     = LPATH;
        
		spl_autoload_register(array($this,'load_core'));
        spl_autoload_register(array($this,'load_controller'));
        spl_autoload_register(array($this,'load_model'));
        //spl_autoload_register(array($this,'load_library'));
   
    }

    /** 
     *-----------------------------------------------------
     * Load Library
     *-----------------------------------------------------
     * Method for load library.
     * This method return class object.
     *
     * @library String
     * @param String
     * @access public
     */    
    public function load_library($library, $param = null)
    {
        if (is_string($library)) {
            return $this->initialize_class($library);
        }
        if (is_array($library)) {
            foreach ($library as $key) {
                return $this->initialize_class($library);
            }
        }                
    }

    /** 
     *-----------------------------------------------------
     * Initialize Class
     *-----------------------------------------------------
     * Method for initialise class
     * This method return new object. 
     * This method can initialize more class using (array)
     *
     * @library String|Array
     * @param String
     * @access public
     */    
    public function initialize_class($library)
    {
        try {
            if (is_array($library)) {
                foreach($library as $class) {
                    $arrayObject =  new $class;
                }            
                return $this;
            }
            if (is_string($library)) {
                $stringObject = new $library;
            }else {
                throw new ISException('Class name must be string.');
            }
            if (null == $library) {
                throw new ISException('You must enter the name of the class.');
            }
        } catch(Exception $exception) {
            echo $exception->getMessage();
        }
    }    
    
	/**
     * Autoload Core class
     *
     * @param  string $class
     * @return object
     */
	public function load_core($core)
    {
        if ($core) {
            set_include_path($this->coreDirectoryPath);
            spl_autoload_extensions('.php');
            spl_autoload($core);
        }
    }
	
    /**
     * Autoload Controller class
     *
     * @param  string $class
     * @return object
     */
     
    public function load_controller($controller)
    {
        if ($controller) {
            set_include_path($this->controllerDirectoryPath);
            spl_autoload_extensions('.php');
            spl_autoload($controller);
        }
    }    
    

      /**
     * Autoload Model class
     *
     * @param  string $class
     * @return object
     */
     
    public function load_model($model)
    {
        if ($model) {
            set_include_path($this->modelDirectoryPath);
            spl_autoload_extensions('.php');
            spl_autoload($model);
        }
    }    
    
      /**
     * Autoload Library class
     *
     * @param  string $class
     * @return object
     */
     
/*    public function load_library($library)
    {
        if ($library) {
            set_include_path($this->libraryDirectoryPath);
            spl_autoload_extensions('.php');
            spl_autoload($class);
        }
    }*/
    

    
}
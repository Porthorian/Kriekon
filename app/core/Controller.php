<?php
/**
 * This class controls where the user will go depending on the url.
 *
 * @class Controller
 */
class Controller
{
    public function __construct()
    {
        $this->checkSession();
		
        // Check if user is logged in.
            // if not, redirect user to login page.
        // else
            // else continue with controller.
    }

    // Create the model.
    public function model($model)
    {
        require_once('../app/model/' . $model . '.php');
		$new_model = explode("/", $model);

		if(count($new_model) > 1)
			$model = $new_model[1];
		else
			$model = $new_model[0];
		
        return new $model();
    }

    // Create the view!
    public function view($view, $data = [])
    {
		if(isset($_SESSION['user']))
		{
			$user_view = Controller::model('User');
			$user_view = unserialize($_SESSION[Config::get('session/user_session')]);

			array_push($data, array('user_view'=>$user_view->getUserArray()));
		}
        require_once('../app/views/' . $view . '.php');
    }

    public function checkSession()
    {
        if(session_id() == '' || !isset($_SESSION)) {
          session_start();
            if(empty($_SESSION[Config::get('session/token_name')])) {
              $_SESSION[Config::get('session/token_name')] = Model::makeHash();
            }
        }
    }

	public static function checkToken($token) {
		$tokenName = Config::get('session/token_name');
		if(isset($_SESSION[$tokenName]) && $token === $_SESSION[$tokenName]) {
		  return true;
		}
		return false;
	}
	
	public function is_ajax_request()
	{
		return ( ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
	}
}

?>

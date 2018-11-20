<?php

class HomeController extends Controller
{

	public function index()
	{
		if(isset($_SESSION[Config::get('session/user_session')]))
		{
			$user = $this->model('User');
			$user = unserialize($_SESSION[Config::get('session/user_session')]);
			
			if(!empty($user->getTags()))
			{
				if(in_array("Admin", $user->getTags()))
				{
					header("Location: /social/top");
				}
				else
				{
					header("Location: /forum");
				}
			}
			else
			{
				echo 'You do not have any tags!';
				$user->logout();
			}
		}
		else
		{
			$this->view('home/coming_soon');
		}
	}
}


?>

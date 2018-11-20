<?php

class StreamController extends Controller 
{
	public function index() 
	{
		
		if(isset($_SESSION['user']))
		{
			$user = $this->model('User');
			$user = unserialize($_SESSION[Config::get('session/user_session')]);
			
			if(!empty($user->getTags()))
			{
				if(in_array("Admin", $user->getTags()))
				{
					$this->view('stream/index');
				}
				else
				{
					echo 'You are not an admin!';
					$user->logout();
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
<?php

/**
*
*/
class TestController extends Controller
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
					$this->view('test/index');
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

?>
<?php
class CeiXML extends SimpleXMLElement{
public function asHTML(){
$ele=dom_import_simplexml($this);
$dom = new DOMDocument('1.0', 'utf-8');
$element=$dom->importNode($ele,true);
$dom->appendChild($element);
return $dom->saveHTML();
}
} 
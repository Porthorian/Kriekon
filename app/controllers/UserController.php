<?php
class UserController extends Controller {

	private $_steamapi, $_openid;

	public function register()
	{
		if(!isset($_SESSION[Config::get('session/user_session')]))
		{
			if(isset($_GET['action']))
			{
				if(isset($_GET['register']))
				{
					$errors = null;

					try {

						if($this->checkToken(Input::get('register_token')))
						{

							$sanitized_date = preg_replace("([^0-9/] | [^0-9-])","",htmlentities(Input::get('register_dob')));
							$sanitized_firstname = filter_var(Input::get('register_firstname'), FILTER_SANITIZE_STRING);
							$sanitized_email = filter_var(Input::get('register_email'), FILTER_SANITIZE_EMAIL);
							$sanitized_username = filter_var(ucfirst(Input::get('register_username')), FILTER_SANITIZE_STRING);
							$sanitized_password = filter_var(Input::get('register_password_confirmation'), FILTER_SANITIZE_STRING);
							if(Input::get('register_password_confirmation') == Input::get('register_password'))
							{
								if(Config::get('site/httpurl') == "kriekon.test")
								{
									$user = $this->model('User');
									$user->register(//$sanitized_firstname,
												$sanitized_date,
												/*Input::get('register_timezone'),*/
												$sanitized_email,
												$sanitized_username,
												$sanitized_password
											   );

									header("Location: /");
								}
								else
								{
									$response = $_POST['g-recaptcha-response'];
									$url = 'https://www.google.com/recaptcha/api/siteverify';
									$data = array(
										'secret' => 'your-site-key',
										'response' => $_POST['g-recaptcha-response']
									);
									$options = array(
										'http' => array (
											'method' => 'POST',
											'content' => http_build_query($data)
										)
									);
									$context  = stream_context_create($options);
									$verify = file_get_contents($url, false, $context);
									$captcha_success=json_decode($verify);
									if ($captcha_success->success==false) {
										echo "<p>You are a bot! Go away!</p>";
									} else if ($captcha_success->success==true) {
										$user = $this->model('User');
										$user->register(//$sanitized_firstname,
													$sanitized_date,
													//Input::get('register_timezone'),
													$sanitized_email,
													$sanitized_username,
													$sanitized_password
												   );

										header("Location: /");
									}
								}
							}
							else
							{
								$errors = 'Passwords do not match!';
							}
						}
						else
							$errors = 'Invalid Token!';

					} catch (Exception $e) {
						echo $e->getMessage();
					}
				}
			}
			$this->view('user/register');
		}
		else
			header("Location: /");
	}

	public function logout()
	{
		$user = $this->model('User');
		if($user->logout()) {
			$this->view('user/logout');
		} else {
			$this->view('user/logout');
		}
	}

	public function login()
	{
		if(!isset($_SESSION[Config::get('session/user_session')]))
		{
			if(isset($_GET['action']))
			{
				if($_GET['action'] == 'login')
				{
					$this->checkSession();
					$user = $this->model('User');
					if($this->checkToken(Input::get('login_token'))) 
					{	
						if(Config::get('site/httpurl') == "kriekon.test")
						{
							$loggedIn = $user->login(Input::get('login_email'), Input::get('login_password'));

							if ($loggedIn) 
							{
								$_SESSION[Config::get('session/user_session')] = serialize($user);
								header("Location: /");
							} 
							else {
								echo 'Username or Password is Incorrect'; //TODO:  add JS prompt
							}
						}
						else
						{
							$response = $_POST['g-recaptcha-response'];
							$url = 'https://www.google.com/recaptcha/api/siteverify';
							$data = array(
								'secret' => 'your-site-key',
								'response' => $_POST['g-recaptcha-response']
							);
							$options = array(
								'http' => array (
									'method' => 'POST',
									'content' => http_build_query($data)
								)
							);
							$context  = stream_context_create($options);
							$verify = file_get_contents($url, false, $context);
							$captcha_success=json_decode($verify);

							if ($captcha_success->success==false) {
								echo "<p>You are a bot! Go away!</p>";
							} else if ($captcha_success->success==true) 
							{
								$loggedIn = $user->login(Input::get('login_email'), Input::get('login_password'));

								if ($loggedIn) 
								{
									$_SESSION[Config::get('session/user_session')] = serialize($user);
									header("Location: /");
								} 
								else {
									echo 'Username or Password is Incorrect'; //TODO:  add JS prompt
								}
							}
						}
					} 
					else {
						echo "Token Not Valid";
					}
				}
			}
			$this->view('user/login', []);
		}
		else
			header("Location: /");
	}

	public function p($username) 
	{
		
		$user = $this->model('User');
		$user->fetchUserInfo($username);

		$this->view('user/profile',['user'=>$user->getUserArray()]);

	}

	/*public function threads($username = null) {

			$user = $this->model('User');
			$user = $_SESSION[Config::get('session/user_session')];

			$per_page = 5;

			if(!isset($_GET['page'])) {
				$page_number = 1;
			} else {
				$page_number = $_GET['page'];
			}

			$display_set = $page_number * $per_page;
			$display_of = $display_set - 5;

			if($display_of == 0) {
				$display_of = 1;
			}

			if(!$username || empty($username) || is_null($username)) {
				$username = $user->user_getUserName();
			}

			echo $username;

			$threads = $user->getUserThreads($username,$page_number,$per_page);
			$display_total = $threads->total;
			echo "Displaying ${display_of}-${display_set} of ${display_total}";

			$page = new Paginator($threads->total, $per_page, $page_number, '/user/threads/'.$username.'?page=(:num)');

			Functions::dump($threads);

			echo '<p>' . $page . '</p>';
		//   $this->view('user/profile',['user'=>$user,'page'=>$page,'threads'=>$threads]);
	}*/

	// public function steamlink() {
	// 		$user = $this->model('User');
	// 		$newUserId = $_SESSION[Config::get('session/user_session')]->getUserId();
	// 		if(!$user->steam_getId()) {
	// 				$_steamapi = Config::get('steam/apikey');
	// 				try {
	// 					$_openid = new LightOpenID(Config::get('steam/redirecturl'));
	// 					if (!$_openid->mode) {
	// 							$_openid->identity = "http://steamcommunity.com/openid/?l=english";
	// 							header('Location: ' . $_openid->authUrl());
	// 				} elseif ($_openid->mode == 'cancel') {
	// 						echo 'User canceled auth!';
	// 					} else {
	// 						if($_openid->validate()) {
	// 							$id = $_openid->identity;
	// 							$ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
	// 							preg_match($ptn, $id, $matches);

	// 							$url = "http://api.steampowered.com/iSteamUser/GetPlayerSummaries/v0002/?key=$_steamapi&steamids=$matches[1]";
	// 							$json_obj = file_get_contents($url);
	// 							$json = json_decode($json_obj);

	// 							foreach($json->response->players as $player) {
	// 									Functions::dump($user->user_linkSteam($player,$newUserId));
	// 									// $_SESSION[Config::get('session/user_session')] = $dat;
	// 							}
	// 							// if(isset($_SESSION[Config::get('session/user_session')])) {
	// 							//     $this->profile();
	// 							// }
	// 						}
	// 					}
	// 				} catch (ErrorException $e) {
	// 					echo $e->getMessage();
	// 				}
	// 		} else {
	// 				header('Location: /user/profile/');
	// 		}
	// }

	// public function steamlogin() {
	// 		$user = $this->model('User');
	// 	$_steamapi = Config::get('steam/apikey');
	// 	try {
	// 		$_openid = new LightOpenID(Config::get('steam/redirecturl'));
	// 		if (!$_openid->mode) {
	// 				$_openid->identity = "http://steamcommunity.com/openid/?l=english";
	// 				header('Location: ' . $_openid->authUrl());
	// 	} elseif ($_openid->mode == 'cancel') {
	// 			echo 'User canceled auth!';
	// 		} else {
	// 			if($_openid->validate()) {
	// 				$id = $_openid->identity;
	// 				$ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
	// 				preg_match($ptn, $id, $matches);

	// 				$url = "http://api.steampowered.com/iSteamUser/GetPlayerSummaries/v0002/?key=$_steamapi&steamids=$matches[1]";
	// 				$json_obj = file_get_contents($url);
	// 				$json = json_decode($json_obj);

	// 				foreach($json->response->players as $player) {
	// 						$dat = $user->user_matchSteam($player->steamid);
	// 						$_SESSION[Config::get('session/user_session')] = $dat;
	// 				}
	// 				if(isset($_SESSION[Config::get('session/user_session')])) {
	// 						header('Location: /user/profile/');
	// 				}
	// 			}
	// 		}
	// 	} catch (ErrorException $e) {
	// 		echo $e->getMessage();
	// 	}
	// }
}

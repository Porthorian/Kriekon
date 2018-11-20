<?php

class NewsController extends Controller
{
	public function index() //Rss feeds
	{
		//https://stackoverflow.com/questions/250679/best-way-to-parse-rss-atom-feeds-with-php/25813395

		// $i = 0; // counter
		// // $url = "http://feeds.ign.com/ign/all?format=rss"; // url to parse
		
		// $url = "http://www.metacritic.com/rss/games/pc";
		// // $url = "https://www.gamespot.com/feeds/reviews/";
		// $rss = new ceiXML(); // XML parser
		

		// Functions::dump($rss);
		// // RSS items loop

		// print '<h2><img style="vertical-align: middle;" src="'.$rss->channel->image->url.'" /> '.$rss->channel->title.'</h2>'; // channel title + img with src

		// foreach($rss->channel->item as $item) {
		// if ($i < 10) { // parse only 10 items
		//   print '<a href="'.$item->link.'">'.$item->title.'</a><br />';
		//   echo $item->description;
		// }

		// $i++;
		// }
		// 
		
		// $user = $this->model('User');
		// $user->fetchUserInfo('Peter2');
		// $user->addTag(2);
		// $user->addTag(7);
		// echo 'done';
		if(isset($_SESSION['user']))
		{
			$user = $this->model('User');
			$user = unserialize($_SESSION[Config::get('session/user_session')]);
			
			if(!empty($user->getTags()))
			{
				if(in_array("Admin", $user->getTags()))
				{
					$this->view('news/index', []); 
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
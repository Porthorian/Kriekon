<?php

class AjaxController extends Controller
{
	
	/* Checks the User Username to see if it Exists
	 * Login Page
	 * Returns JSON($response)
	 */
	public function check_username()
	{
		$user = $this->model('User');
		
		if($this->is_ajax_request())
		{
			$username = Input::get('register_username');
			
			$response = array(
			  'valid' => false,
			  'message' => 'Post argument "user" is missing.'
			);
			
			if($user->checkUsername($username) == true)
			{	
				//Username is Taken
				$response = array('valid' => false, 'message' => 'This user name is already registered.');
			}
			else
			{
				//Username is Avaliable
				$response = array('valid' => true);
			}
			echo json_encode($response);
		}
		else
			header("Location: /");
	}
	
	/* Checks the User Email to see if it exists 
	 * Register Page
	 * Returns JSON($response)
	 */
	public function check_email() 
	{
		$user = $this->model('User');
		
		if($this->is_ajax_request())
		{
			$email = Input::get('register_email');
			
			$response = array(
			  'valid' => false,
			  'message' => 'Post argument "email" is missing.'
			);
			
			if($user->checkEmail($email) == true)
			{	
				//Email is Taken
				$response = array('valid' => false, 'message' => 'This Email is already taken.');
			}
			else
			{
				//Email is Avaliable
				$response = array('valid' => true);
			}
			echo json_encode($response);
		}
		else
			header("Location: /");
	}
	
	/* Upvotes Or Downvotes based on $_POST Request for ldButton
	 * Returns JSON($result)
	 * @PARAM $post_id = Either Forum.thread_id, or Article.article_id
	 * Ajax Handles the JSON From there.
	 */
	public function upvote_downvote($post_id)
	{		
		$trending = $this->model('TrendingSystem');
		
		if($this->is_ajax_request())
		{
			if(isset($_POST['post_type']))
			{
				switch($_POST['post_type'])
				{
					case 'thread':
						$thread = $this->model('Forum/ForumThread');
						$thread->fetchThreadInfo($post_id);

						if($_POST['upvote_downvote'] == 'upvote')
						{
							// Create the array we are returning.
							$result = [];

							// Check to see if the user has liked/disliked before, this will be a bool.
							$result[0] = $trending->checkUpvotes(Input::get('user_id'), $thread->getThreadID());
							// Return the button type, this will help chose class changes.
							$result[1] = $_POST['button_type'];
							// For some reason when we pass between it requires the data to be turned into a string. 
							// We are simply changing it back here.

							$trending->increaseUpvotes(Input::get('user_id'), Input::get('post_id'));
							$result[2] = (int)$thread->getThreadUpvotes();
							//Has been upvoted by user
							if($result[0] == 'true'){
								$result[0] = true;
							}
							//Has not been upvoted by user
							else 
							{
								$result[0] = false;
							}
							// Encode it into something Javascript can read.
							$result[3] = (int)$trending->getScore($thread->getThreadID());
							echo json_encode($result);
							return;
						} 
						elseif ($_POST['upvote_downvote'] == 'downvote') 
						{					
							// Create the array we are returning.
							$result = [];
							// Check to see if the user has liked/disliked before, this will be a bool.
							$result[0] = $trending->checkDownvotes(Input::get('user_id'), $thread->getThreadID());
							// Return the button type, this will help chose class changes.
							$result[1] = $_POST['button_type'];
							// For some reason when we pass between it requires the data to be turned into a string. 
							// We are simply changing it back here.

							$trending->increaseDownvotes(Input::get('user_id'), Input::get('post_id'));
							// Return the number of dislikes.
							$result[2] = (int)$thread->getThreadDownvotes();
							if($result[0] == 'true'){
								$result[0] = true;
							} 
							else 
							{
								$result[0] = false;
							}
							// Encode it into something Javascript can read.
							$result[3] = (int)$trending->getScore($thread->getThreadID());
							echo json_encode($result);
							return;
						}
						else
						{
							echo json_encode("I never made it");
						}
					break;
						
					case 'article':
						$article = $this->model('Article/Article');
						$article->fetchArticleInfo($post_id);
					break;
					
					case 'thread_reply':
					break;
				}
			}
		}
		//If its not an Ajax Request we redirect back too the homepage.
		else
		{
			echo json_encode("I never made it as an ajax request");
			header("Location: /");
		}
	}
	
	public function get_hot_post_data()
	{
		//if($this->is_ajax_request())
		//{
			$trending = $this->model('TrendingSystem');
			//$trending->fetchHotThreads($limit = 10, $limit_offset = 100);
		$trending->fetchHotThreads();
			Functions::dump($trending->getHotPosts());
		//}
	}
}
<?php

class ForumController extends Controller 
{
	
	public function index()
	{
		if(isset($_SESSION[Config::get('session/user_session')]))
		{
			header("Location: /forum/hot");
		}
		else
			header("Location: /");
	}
	
	/*
	* This function will display trending forums on home page of forum
	* Hot Page
	*/
	public function hot()
	{
		if(isset($_SESSION[Config::get('session/user_session')]))
		{
			$categories = array();
			$threads = array();
			
			$forum = $this->model('Forum/Forum');
			$forum->fetchForumInfo("Kriekon");
			$forum->fetchForumCategories();
			
			$trending = $this->model('TrendingSystem');
			$trending->fetchHotThreads();
			
			foreach($forum->getForumCategories() as $category_id)
			{
				$category = $this->model('Forum/ForumCategory');
				$category->fetchCategoryInfo($category_id);
				$number_of_threads = $category->count();

				$categories[] = array('category_id'=>$category->getCategoryID(), 'category_name'=>$category->getCategoryName(), 'category_description'=>$category->getCategoryDescription(), 'number_of_threads'=>$number_of_threads, 'category_url_title'=>$category->getCategoryUrlTitle());
			}
			
			foreach($trending->getHotPosts() as $thread_id)
			{
				$thread = $this->model('Forum/ForumThread');
				$thread->fetchThreadInfo($thread_id);
				
				$threads[] = $thread->getThreadArray();
			}

			$this->view('forums/hot', ['forum_name'=>$forum->getForumName(), 'categories'=>$categories, 'threads'=>$threads]);
		}
		else
			echo("You are not logged in!");
	}
	/*
	* This function will display trending forums on home page of forum
	* Popular Page
	*/
	public function popular()
	{
		if(isset($_SESSION[Config::get('session/user_session')]))
		{
			$categories = array();
			$threads = array();
			
			$user = $this->model('User');
			$user = unserialize($_SESSION[Config::get('session/user_session')]);
			
			$forum = $this->model('Forum/Forum');
			$forum->fetchForumInfo("Kriekon");
			$forum->fetchForumCategories();
			$trending = $this->model('TrendingSystem');
			$trending->fetchConfidentThreads();
			
			foreach($forum->getForumCategories() as $category_id)
			{
				$category = $this->model('Forum/ForumCategory');
				$category->fetchCategoryInfo($category_id);
				$number_of_threads = $category->count();

				$categories[] = array('category_id'=>$category->getCategoryID(), 'category_name'=>$category->getCategoryName(), 'category_description'=>$category->getCategoryDescription(), 'number_of_threads'=>$number_of_threads, 'category_url_title'=>$category->getCategoryUrlTitle());
			}
			
			foreach($trending->getConfidentPosts() as $thread_id)
			{
				$thread = $this->model('Forum/ForumThread');
				$thread->fetchThreadInfo($thread_id);
				
				$threads[] = $thread->getThreadArray();
			}
			//Functions::dump($threads);
			$this->view('forums/popular', ['forum_name'=>$forum->getForumName(), 'categories'=>$categories, 'threads'=>$threads]);
		}
		else
			echo("You are not logged in!");
	}
	
	/* Category Page
	 * Returns the View of forums/category.php
	*/
	public function c($id, $name) 
	{
		if(isset($_SESSION[Config::get('session/user_session')]))
		{
			$forum = $this->model('Forum/Forum');
			$forum->fetchForumInfo("Kriekon");
			$forum->fetchForumCategories();
			
			foreach($forum->getForumCategories() as $category_id)
			{
				$category = $this->model('Forum/ForumCategory');
				$category->fetchCategoryInfo($category_id);
				$number_of_threads = $category->count();

				$categories[] = array('category_id'=>$category->getCategoryID(), 'category_name'=>$category->getCategoryName(), 'category_description'=>$category->getCategoryDescription(), 'number_of_threads'=>$number_of_threads, 'category_url_title'=>$category->getCategoryUrlTitle());
			}
			
			$thread_array = array();
			$category = $this->model('Forum/ForumCategory');
			$category->fetchCategoryInfo($id);
			$category->fetchCategoryThreads(50);
			
			foreach($category->getCategoryThreads() as $thread_id)
			{
				$thread = $this->model('Forum/ForumThread');
				$thread->fetchThreadInfo($thread_id);
				
				$thread_array[] = $thread->getThreadArray();
			}
			
			$this->view('forums/category', ['forum_name'=>$forum->getForumName(), 'categories'=>$categories, 'thread_array'=>$thread_array, 'category_id'=>$category->getCategoryID(), 'category_name'=>$category->getCategoryName(), 'category_description'=>$category->getCategoryDescription()]);
		}
	}
	public function thread($id, $name)
	{
		if(isset($_SESSION[Config::get('session/user_session')]))
		{
			$replies_array = array();
			
			$forum = $this->model('Forum/Forum');
			$thread = $this->model('Forum/ForumThread');
			$user = $this->model('User');
			$user = unserialize($_SESSION[Config::get('session/user_session')]);
			
			$forum->fetchForumInfo("Kriekon");
			$thread->fetchThreadInfo($id);
			$thread->fetchThreadReplies();
			
			foreach($thread->getThreadReplies() as $reply_id)
			{
				$reply = $this->model('Forum/ForumReply');
				$reply->fetchReplyInfo($reply_id);
				$reply_user = $this->model('User');
				$reply_user->fetchUserInfo($reply->getReplyUserID());
				
				$reply_children = array();
				$reply->fetchReplyChildren($reply_id);
				
				foreach($reply->getReplyChildren() as $child_reply_id)
				{
					$child = $this->model('Forum/ForumReply');
					$child->fetchReplyInfo($child_reply_id);
					
					$child_user = $this->model('User');
					$child_user->fetchUserInfo($child->getReplyUserID());
					
					$reply_children[] = array('reply_id'=>$child->getReplyID(), 'reply_date'=>Functions::getDateArray($child->getReplyDate()), 'adjusted_time'=>Functions::getTimeAdjustment($child->getReplyDate()), 'reply_author'=>$child_user->getUserArray(), 'reply_content'=>$child->getReplyContent());
				}
				
				$replies_array[] = array('reply_id'=>$reply->getReplyID(), 'reply_date'=>Functions::getDateArray($reply->getReplyDate()), 'adjusted_time'=>Functions::getTimeAdjustment($reply->getReplyDate()), 'reply_author'=>$reply_user->getUserArray(), 'reply_content'=>$reply->getReplyContent(), 'children'=>$reply_children);
			}
			
			if(isset($_GET['action']))
			{
				if($_GET['action'] == 'create_reply')
				{
					if($this->checkToken(Input::get('reply_token')))
					{
						if($user->fetchUserInfo() == true) //Checks to see if user actually exists
						{
							$reply = $this->model('Forum/ForumReply');
							$reply->setReplyThreadID($thread->getThreadID());
							$reply->setReplyUserID($user->getUserID());
							$reply->setReplyParentID(0);
							$reply->setReplyAuthor($user->getUserUsername());
							$reply->setReplyContent(Input::get('reply_content'));
							$reply->create();
							
							header('Location: /forum/thread/' . $id . '/' . $name); //TODO Ajax Post Request
						}
					}
				}
				elseif($_GET['action'] == 'create_child')
				{
					if($this->checkToken(Input::get('reply_token')))
					{
						if($user->fetchUserInfo() == true) //Checks to see if user actually exists
						{
							$reply = $this->model('Forum/ForumReply');
							$reply->setReplyThreadID($thread->getThreadID());
							$reply->setReplyUserID($user->getUserID());
							$reply->setReplyParentID(Input::get('reply_parent_id'));
							$reply->setReplyAuthor($user->getUserUsername());
							$reply->setReplyContent(Input::get('reply_content'));
							$reply->create();
							
							header('Location: /forum/thread/' . $id . '/' . $name); //TODO Ajax Post Request
						}
					}
				}
			}
			
			$this->view('forums/thread', ['forum_name'=>$forum->getForumName(), 'thread'=>$thread->getThreadArray(), 'replies'=>$replies_array]);
			
		}
	}
	
	public function create_thread()
	{
		if(isset($_SESSION[Config::get('session/user_session')]))
		{	
			$forum = $this->model('Forum/Forum');
			$forum->fetchForumInfo("Kriekon");
			$forum->fetchForumCategories();
			
			foreach($forum->getForumCategories() as $category_id)
			{
				$category = $this->model('Forum/ForumCategory');
				$category->fetchCategoryInfo($category_id);
				$number_of_threads = $category->count();

				$categories[] = array('category_id'=>$category->getCategoryID(), 'category_name'=>$category->getCategoryName(), 'category_description'=>$category->getCategoryDescription(), 'number_of_threads'=>$number_of_threads, 'category_url_title'=>$category->getCategoryUrlTitle());
			}
			
			if(isset($_GET['action']))
			{
				if($_GET['action'] == 'create')
				{
					if($this->checkToken(Input::get('thread_token')))
					{
						$thread_subject = filter_var(Input::get('thread_subject'), FILTER_SANITIZE_STRING);
						$thread_description = filter_var(Input::get('thread_description'), FILTER_SANITIZE_STRING);
						$thread_category_id = filter_var(Input::get('thread_category'), FILTER_SANITIZE_NUMBER_INT);
						$thread_content = Input::get('thread_content');
						
						$thread = $this->model('Forum/ForumThread');
						$user = $this->model('User');
						$user = unserialize($_SESSION[Config::get('session/user_session')]);

						if($user->fetchUserInfo() == true) //Checks to see if user actually exists
						{
							$thread->setThreadUserID($user->getUserID());
							$thread->setThreadAuthor(ucfirst($user->getUserUsername()));
							$thread->setThreadSubject($thread_subject);
							$thread->setThreadDescription($thread_description);
							$thread->setThreadCategoryID($thread_category_id);
							$thread->setThreadContent($thread_content);
							$thread->create();
							
							$new_thread_id = $thread->getLastInsert();
							$url_title = Functions::adjustStringSEO($thread->getThreadSubject());
							
							header('Location: /forum/thread/' . $new_thread_id . '/' . $url_title);
						}
					}
				}
			}
			else
			{
				$this->view('forums/create_thread', ['categories'=>$categories]);
			}
		}
		else
			header("Location: /home/login");
	}
}
<?php

/**
* 
*/
class DashboardController extends Controller
{
    
    public function index()
    {
		$this->view('ap/index', []);
    }

    public function users()
    {

        $dashboard = $this->model('Dashboard');

        $per_page = 25;

        // Set the page number.
        if(!isset($_GET['page'])) {
            $page_number = 1;
        } else {
            $page_number = (int)$_GET['page'];
        }

        $users = $dashboard->getAllUsers($page_number, $per_page);
        $userCount = $dashboard->countUsers();

        $paginator = new Paginator($userCount, $per_page, $page_number, '/dashboard/users?page=(:num)', 'pagination');

        $this->view('ap/users', ['users'=>$users,'paginator'=>$paginator]);
    }
	
	public function articles()
	{
		$dashboard = $this->model('Dashboard');
		
		$per_page = 25;
		
		if(!isset($_GET['page']))
			$page_number = 1;
		else
			$page_number = (int)$_GET['page'];
		
		$articles = $dashboard->getAllArticles($page_number, $per_page);
		$articleCount = $dashboard->countArticles(); //Counts articles before passed to the paginator.
		
		$paginator = new Paginator($articleCount, $per_page, $page_number, '/dashboard/articles?page=(:num)', 'pagination');
		
		//Functions::dump($articles);
		
		$this->view('ap/articles', ['articles'=>$articles, 'paginator'=>$paginator]);
	}
	
	public function create_article()//To do sanitize entrys
	{
		$categories = array();
		
		$article_system = $this->model('ArticleSystem'); //Sets up the Article System object
		$article_system->fetchArticleSysInfo('Kriekon'); //Fetchs Kriekon Article System 
		$article_system->fetchArticleSuperCategories(); //Fetchs SuperCategories and adds them to array by article_superCat_id
		
		foreach($article_system->getArticleSuperCategories() as $superCat) //Gets the article_superCat_id
		{
			$superCategory = $this->model('ArticleSuperCategory');//Sets up the object
			$superCategory->fetchArticleSuperCatInfo($superCat);//Grabs the super category information and passes it too the superCat variable
			
			$categories[] = array('category_id'=>$superCategory->getArticleSuperCategoryID(), 'category_name'=>$superCategory->getArticleSuperCategoryName());//transfers information into the article_systems array.
		}
		
		if(isset($_GET['action']))
		{
			$user = $this->model('User'); //Creates the user object
			$user = unserialize($_SESSION[Config::get('session/user_session')]); //Grabs the Session and Unserializes the session and places it into the User object
			//Functions::dump($user);
			$action = $_GET['action']; //Sets up the action

			// If the action is create, set up thread object and create the object.
			if($action == 'create'){
				$article = $this->model('Article'); //Creates Article object
				$article->setArticleSuperCategoryID($_POST['category']);
				$article->setUserID($user->getUserId());
				$article->setArticleAuthor($user->getUserUsername());
				$article->setArticleTitle($_POST['subject']);
				$article->setArticleContent($_POST['content_box']);
				$article->create();

				$new_article_id = $article->getLastInsert();//Grabs the last inserted id. This might cause issues in the end if we have too much traffic. Lets say someone submits at the same time as another person. Possibility shit could be switched.
				
				$article_tags = $this->model('ArticleTags'); //Sets up the object
				$tags = explode(',', $_POST['tag']); //Separates the tags from the hidden input puts them into tags array.
				
				foreach($tags as $tag)
				{
					$article_tags->setTagName($tag);
					$exists = $article_tags->getTagName();

					$result = $article_tags->tagNameExists($exists); //If tag name exists will return true, if not returns false.

					if($result == true) //If Tag_Name exists will create an article_tag_link between the tag and the article
					{
						$tag_name = $article_tags->getTagName();
						$article_tags->selectTagID($tag_name);

						$article_tags->setTagID($article_tags->getTagID());
						$article_tags->setArticleID($new_article_id);
						$article_tags->createArticleTagLink(); //Creates the link between the tag and the article.
					}
					elseif($result == false) //If tag_name does not exists will create the tag and the article_tag_link between the tag and the article.
					{
						$article_tags->createArticleTag(); //Creates the article tag if the tag_name does not exist.

						$new_tag_id = $article_tags->getLastInsertTagID();

						$article_tags->setTagID($new_tag_id);
						$article_tags->setArticleID($new_article_id);
						$article_tags->createArticleTagLink(); //Creates the link between the tag and the article.
					}
				}

				// Send user back to the newly created thread.
				header('Location: /article/post/'.$new_article_id);
			}

			/*// If preview is passed through it will send this information back to the page
			// to display it in html to show the preview.
			if($action == 'preview'){

				// Parses the BBCode.
				$parser = new JBBCode\Parser();
				$parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());

				
				$article = $this->model('Article');

				// Declare the array to pass back.
				$result = [];
				
				// Build the array.
				$result[0] = $user->getUserUsername();
				$result[1] = $_POST['content_box'];
				$result[2] = $_POST['subject'];

				$newDateFormat = new DateTime(date('Y-m-d H:i:s', time()));
				$date = $newDateFormat->format('Y-m-d');

				$result[3] = $date;
				$result[4] = 0;

				// Parse the content the user passed through.
				$parser->parse($result[1]);
				$result[1] = $parser->getAsHtml();

				// Send back the users post to javascript to have it displayed.
				echo json_encode($result, JSON_UNESCAPED_SLASHES);
				return;
			}*/
		}
		
		$this->view('ap/create_article', ['categories'=>$categories]);
	}

}

?>
<?php

class ArticleController extends Controller
{
	public function index()
	{
		
		/*$article_systems = array();

		$article_system = $this->model('ArticleSystem');
		$article_system->fetchArticleSysInfo('Kriekon');
		$article_system->fetchArticleSuperCategories();

		$_SESSION['article_system_name'] = $article_system->getArticleSystemName();

		//Flex Slider Code

		$article_system->fetchFeaturedArticles();
		$featured_articles = array();

		foreach($article_system->getFeaturedArticles() as $article_id) //Grabs 6 Featured article_ids. Sorted by article_date DESC.
		{
			$article = $this->model('Article');
			$article->fetchArticleInfo($article_id);
			$article->fetchArticleTag($article_id);

			$url_title = $this->adjustStringSEO($article->getArticleTitle());

			$featured_articles[] = array('url_title'=>$url_title, 'article_tag_id'=>$article->getArticleTagID(),'article_tag_name'=>$article->getArticleTagName(), 'article_id'=>$article->getArticleID(), 'article_title'=>$article->getArticleTitle(), 'article_date'=>$article->getArticleDate(), 'article_author'=>$article->getArticleAuthor());
		}

		//End of Flex Slider Code

		//Just Posted and "Recent" Tab on Sidebar Code
		$article_system->fetchRecentArticles();
		$recent_articles = array();

		foreach($article_system->getRecentArticles() as $recent_article) //Grabs 14 Recent article_ids. Sorted by article_date DESC
		{
			$article = $this->model('Article');
			$article->fetchArticleInfo($recent_article);
			$url_title = $this->adjustStringSEO($article->getArticleTitle());

			$recent_articles[] = array('url_title'=>$url_title, 'article_id'=>$article->getArticleID(), 'article_title'=>$article->getArticleTitle(),'article_author'=>$article->getArticleAuthor(),'article_date'=>$article->getArticleDate());
		}

		//End of Just Posted and "Recent" Tab on Sidebar Code

		foreach($article_system->getArticleSuperCategories() as $superCat)
		{

			$superCatFeaturedArticle = array(); //Creates array for Featured SuperCat Article

			$superCategory = $this->model('ArticleSuperCategory');//Finds the php file
			$superCategory->fetchArticleSuperCatInfo($superCat);//Grabs the super category information and passes it too the superCat variable
			$superCategory->fetchFeaturedArticle();

			$url_title = $this->adjustStringSEO($superCategory->getArticleSuperCategoryName());//Adjust the Category Name and replaces spaces with dashes.

			foreach($superCategory->getFeaturedArticle() as $featured_article)//Grabs the featured Article in its respective superCategory.
			{
				$article = $this->model('Article');
				$article->fetchArticleInfo($featured_article);
				$article->fetchArticleTag($featured_article);

				$superCatFeaturedArticle[] = array('article_tag_id'=>$article->getArticleTagID(), 'article_tag_name'=>$article->getArticleTagName(),'article_id'=>$article->getArticleID(),'article_title'=>$article->getArticleTitle(), 'article_author'=>$article->getArticleAuthor(), 'article_date'=>$article->getArticleDate(), 'article_summary'=>$article->getArticleSummary());
			}

			$articles = array();
			$superCategory->fetchSuperCatArticles(6); //Fetchs Supercategory Articles no matter the Tag, with a parameter as the limiter to the sql select statement.

			foreach($superCategory->getSuperCatArticles() as $article_id) //To grab all articles in supercategory_articles Array.
			{
				$article = $this->model('Article');
				$article->fetchArticleInfo($article_id);
				$article->fetchArticleTag($article_id);

				$articles[] = array('article_tag_id'=>$article->getArticleTagID(), 'article_tag_name'=>$article->getArticleTagName(), 'article_id'=>$article->getArticleID(), 'article_title'=>$article->getArticleTitle(), 'article_date'=>$article->getArticleDate(), 'article_author'=>$article->getArticleAuthor(), 'article_summary'=>$article->getArticleSummary());
			}


			$article_systems[] = array('id'=>$superCategory->getArticleSuperCategoryID(), 'name'=>$superCategory->getArticleSuperCategoryName(), 'url_title'=>$url_title, 'featured_article'=>$superCatFeaturedArticle, 'superCat_articles'=>$articles);//transfers information into the article_systems array.

		}*/
		//Functions::dump($article_systems);
		/*$breadcrumb = new Breadcrumb();
		$hierarchy = $breadcrumb->fetchHierarchy('article_system',)*/

		//$this->view('home/index', ['user'=>$user->getUserArray(), 'article_system_name'=>$article_system->getArticleSystemName(),'articles'=>$article_systems, 'recent_articles'=>$recent_articles, 'featured_articles'=>$featured_articles]);
		if(isset($_SESSION['user']))
		{
			$user = $this->model('User');
			$user = unserialize($_SESSION[Config::get('session/user_session')]);
			
			if(!empty($user->getTags()))
			{
				if(in_array("Admin", $user->getTags()))
				{
					$this->view('blog/index', []);
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
	
	public function category($id, $name = null)
	{
		$categories = array();
		
		$category = $this->model('ArticleSuperCategory');
		$category->fetchArticleSuperCatInfo($id);
		$category->fetchSuperCatArticles();
				
		$_SESSION['article_Category_name'] = $category->getArticleSuperCategoryName();
		$_SESSION['article_Category_id'] = $category->getArticleSuperCategoryID();
		
		$featured_article = array();
		$category->fetchFeaturedArticle();
			
		foreach($category->getFeaturedArticle() as $article_id)//Grabs the featured Article in its respective superCategory.
		{
			$article = $this->model('Article');
			$article->fetchArticleInfo($article_id);
			$article->fetchArticleTag($article_id);
			$url_title = $this->adjustStringSEO($article->getArticleTitle());

			$featured_article[] = array('tag_id'=>$article->getArticleTagID(), 'tag_name'=>$article->getArticleTagName(),'url_title'=>$url_title, 'article_id'=>$article->getArticleID(), 'article_title'=>$article->getArticleTitle(), 'article_author'=>$article->getArticleAuthor(), 'article_date'=>$article->getArticleDate(), 'article_summary'=>$article->getArticleSummary());
		}
		
		foreach ($category->getSuperCatArticles() as $catArticles)
		{
			$articles = $this->model('Article');
			$articles->fetchArticleInfo($catArticles);
			$articles->fetchArticleTag($catArticles);
			$url_title = $this->adjustStringSEO($article->getArticleTitle());
			
			$categories[] = array('article_id'=>$articles->getArticleID(),'tag_id'=>$articles->getArticleTagID(),'tag_name'=>$articles->getArticleTagName(),'article_author'=>$articles->getArticleAuthor(),'url_title'=>$url_title, 'article_title'=>$articles->getArticleTitle(),'article_summary'=>$articles->getArticleSummary(),'article_date'=>$articles->getArticleDate());
			
		}
		
		//Just Posted and "Recent" Tab on Sidebar Code
		$article_system = $this->model('ArticleSystem');
		$article_system->fetchArticleSysInfo('Kriekon');
		
		$article_system->fetchRecentArticles();
		$recent_articles = array();
		
		foreach($article_system->getRecentArticles() as $recent_article)
		{
			$article = $this->model('Article');
			$article->fetchArticleInfo($recent_article);
			$url_title = $this->adjustStringSEO($article->getArticleTitle());
			
			$recent_articles[] = array('url_title'=>$url_title, 'article_id'=>$article->getArticleID(), 'article_title'=>$article->getArticleTitle(),'article_author'=>$article->getArticleAuthor(),'article_date'=>$article->getArticleDate());
		}
		
		//End of Just Posted and "Recent" Tab on Sidebar Code
		
		//Functions::dump($categories);
		$this->view('article/category',['url_title'=>$url_title,'category_id'=>$category->getArticleSuperCategoryID(), 'category_name'=>$category->getArticleSuperCategoryName(), 'featured_article'=>$featured_article, 'articles'=>$categories, 'recent_articles'=>$recent_articles]);
		
		
	}
	
	public function tag(int $id)
	{
		$article_tags = array();
		
		$tags = $this->model('ArticleTags');
		
		$tags->fetchTagInfo($id);	
		$tags->fetchTagArticles();
		
		$_SESSION['article_tag_id'] = $tags->getTagID();
		$_SESSION['article_tag_name'] = $tags->getTagName();
		foreach($tags->getTagArticles() as $article_id)
		{
			$articles = $this->model('Article');
			$articles->fetchArticleInfo($article_id);
			$url_title = $this->adjustStringSEO($articles->getArticleTitle());
			$category_url_title = $this->adjustStringSEO($articles->getArticleSuperCategoryName());
			
			$article_tags[] = array('category_id'=>$articles->getArticleSuperCategoryID(), 'category_name'=>$articles->getArticleSuperCategoryName(),'article_id'=>$articles->getArticleID(),'article_author'=>$articles->getArticleAuthor(),'article_title'=>$articles->getArticleTitle(), 'article_content'=>$articles->getArticleContent(), 'article_date'=>$articles->getArticleDate(), 'article_summary'=>$articles->getArticleSummary(), 'url_title'=>$url_title, 'category_url_title'=>$category_url_title);
		}
		
		//Side Bar code
		
		$article_system = $this->model('ArticleSystem');
		$article_system->fetchArticleSysInfo('Kriekon');
		
		$article_system->fetchRecentArticles();
		$recent_articles = array();
		
		foreach($article_system->getRecentArticles() as $recent_article)
		{
			$article = $this->model('Article');
			$article->fetchArticleInfo($recent_article);
			$url_title = $this->adjustStringSEO($article->getArticleTitle());
			
			$recent_articles[] = array('url_title'=>$url_title, 'article_id'=>$article->getArticleID(), 'article_title'=>$article->getArticleTitle(),'article_author'=>$article->getArticleAuthor(),'article_date'=>$article->getArticleDate());
		}
		
		//End of Side Bar Code
		
		//Functions::dump($article_tags);
		
		$this->view('article/tag', ['tag_id'=>$tags->getTagID(), 'tag_name'=>$tags->getTagName(), 'articles'=>$article_tags, 'recent_articles'=>$recent_articles]);
	}
	
	public function post($id, $name = null)
	{
		$comments = array();
		
		$article = $this->model('Article');
		$article->fetchArticleInfo($id);
		
		$parser = new JBBCode\Parser();
		$parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());
		
		$tags = array();
		$article->fetchArticleTags($id);
		
		foreach($article->getArticleTags() as $tag_id)
		{
			$article_tag = $this->model('ArticleTags');
			$article_tag->fetchTagInfo((int)$tag_id);
			
			$tags[] = array('tag_id'=>$article_tag->getTagID(), 'tag_name'=>$article_tag->getTagName());
		}
		
		$user = $this->model('User');
		
		if(isset($_SESSION['user']))
		{
			$user = $this->model('User');
			$user = unserialize($_SESSION[Config::get('session/user_session')]);
		}
		
		if(isset($_GET['action']))
		{
			if($_GET['action'] == 'add_comment')
			{
				$new_comment = $this->model('ArticleComment');
				$new_comment->setArticleCommentID($user->getUserId());
				$new_comment->setArticleID($_post['article_id']);
				$new_comment->setCommentAuthor($user->getArticleCommentAuthor());
				$new_comment->setCommentContent($_POST['content_box']);
				$new_comment->create();
				
				header('Location: /article/post/'.$new_reply->getArticleID());
			}
		}
		
		$per_page = 10;
		
		if(!isset($_GET['page']))
			$page_number = 1;
		else
			$page_number = (int)$_GET['page'];
		
		$article->fetchArticleComments((int)$id, $page_number, $per_page);
		
		$countComments = $this->model('ArticleComment');
		$countComments->setArticleID($article->getArticleID());
		$numberOfComments = $countComments->count();
		
		foreach($article->getArticleComments() as $commentID)
		{
			$comment = $this->model('ArticleComment');
			$comment->fetchCommentInfo($commentID);
			
			$parser->parse($comment->getArticleCommentContent());
			$comment->setArticleCommentContent($parser->getAsHTML());
			
			$commentArray = $comment->getComments();
			
			$comments[] = $commentArray;
		}
		
		$articleArray = $article->getArticleArray();
		
		
		//Side Bar code
		
		$article_system = $this->model('ArticleSystem');
		$article_system->fetchArticleSysInfo('Kriekon');
		
		$article_system->fetchRecentArticles();
		$recent_articles = array();
		
		foreach($article_system->getRecentArticles() as $recent_article)
		{
			$article = $this->model('Article');
			$article->fetchArticleInfo($recent_article);
			$url_title = $this->adjustStringSEO($article->getArticleTitle());
			
			$recent_articles[] = array('url_title'=>$url_title, 'article_id'=>$article->getArticleID(), 'article_title'=>$article->getArticleTitle(),'article_author'=>$article->getArticleAuthor(),'article_date'=>$article->getArticleDate());
		}
		
		//End of Side Bar Code
		
		//Functions::dump($articleArray);
		//Functions::dump($comments);
		$this->view('article/post', ['article'=>$articleArray,
									'tags'=>$tags,
									'comments'=>$comments,
									'user'=>$user,
									'recent_articles'=>$recent_articles,
									'numberOfComments'=>$numberOfComments]);
	}
	
	public function edit_article($id)
	{
		if(isset($_SESSION[Config::get('session/user_session')]))
		{
			$parser = new JBBCode\Parser();
			$prser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());
			
			$user = $this->moel('User');
			$user = unserialize($_SESSION[Config::get('session/user_session')]);
			
			$article = $this->mode('Article');
			$article->fetchArticleInfo($id);
			$parser->parse($article->getArticleContent());
			$article-setArticleContent($parser->getAsBBCode());
		
			if(isset($_GET['action']))
			{
				switch ($_GET['action'])
				{
					case 'preview':
						$result = [];
						$result[0] = $user->getUserUsername();
						$result[1] = $_POST['content_box'];
						$result[2] = $_POST['title'];
						$result[3] = $article->getArticleDate();
						
						$parser->parse($result[1]);
						$result[1] = $parser->getAsHtml();
						
						echo json_encode($result, JSON_UNESCAPED_SLASHES);
						return;
						break;
					
					case 'update':
						
						$updating_user = $this->model('User');
						$updating_user = unserialize($_SESSION[Config::get('session/user_session')]);
						
						
				}
			}
		}
	}
		
}
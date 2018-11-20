<?php

/**
* 
*/
class Breadcrumb
{
	
	private $loaf,
			$controller,
			$function,
			$sub_ingredient,
			$main_ingredient,
			$ingredient_name,
			$active;
	private	$crumb = 'Index';
	private	$mix = [];
		
	public function getMix() { return $this->mix; }
	public function getLoaf() { return $this->loaf; }
	public function getController() { return $this->controller; }
	public function getFunction() { return $this->function; }
	public function getCrumb() { return $this->crumb; }
	public function getMainIngredient() { return $this->main_ingredient; }
	public function getSubIngredient() { return $this->sub_ingredient; }
	public function getIngredientName() { return $this->ingredient_name; }

	public function setLoaf($temp_loaf) { $this->loaf = $temp_loaf; }
	public function setController($temp_controller) { $this->controller = $temp_controller; }
	public function setFunction($temp_function) { $this->function = $temp_function; }
	public function setCrumb($temp_crumb) { $this->crumb = $temp_crumb; }
	public function setIngredient($temp_ingredient) { $this->ingredient = $temp_ingredient; }
	public function setActive($temp_active) { $this->active = $temp_active; }
	public function setMainIngredient($temp_ingredient) { $this->main_ingredient = $temp_ingredient; }
	public function setName($temp_name) { $this->ingredient_name = $temp_name; }

	// Leave this alone as this will set up the link to the proper location!!!
	public function setSubIngredient()
	{

		if($this->getCrumb() != 'Index'){
			$this->sub_ingredient = $this->getMainIngredient().'/'.$this->getController().'/'.$this->getFunction().'/'.$this->getCrumb();
		} else {
			$this->sub_ingredient = $this->getMainIngredient().'/'.$this->getController().'/'.$this->getFunction();
		}
		
	}
	
	// This is adding a bread crumb to the actual bread crumb!
	public function addIngredient($active = false, $controller, $function, $crumb = null, $name = null)
	{

		$this->setController($controller);
		$this->setFunction($function);
		if($crumb != null){
			$this->setCrumb($crumb);
		}
		if($name != null)
		{
			$this->setName($name);
		}
		$this->setSubIngredient();
		if($active == true)
		{
			$this->addCrumb($active);
		} else {
			$this->addCrumb();
		}
		

	}

	// This function adds the html bread crumb!
	public function addCrumb($active = null) 
	{
		if($active == true)
		{
			$this->mix[] = '<li class="breadcrumb-item active">'.$this->getIngredientName().'</li>';
		} else {
			$this->mix[] = '<li class="breadcrumb-item"><a href="'.$this->getSubIngredient().'">'.$this->getIngredientName().'</a></li>  ';
		}
		
	}
	
	// Set up the entire bread crumb!
	public function bake()
	{
		$this->loaf .= '<ol class="breadcrumb">';
		
		foreach ($this->mix as $crumb) {
			$this->loaf .= $crumb;
		}

		$this->loaf .= '</ol>';
	}

	// Get the hierarchy of the page you are on.. This is tough, ask Peter. I will comment this in more detail later.
	public function fetchHierarchy($system, $stage, $current_id)
	{
		$db = Database::getDBI();

		switch ($system) {
			case 'forum':
				switch ($stage) {
					case 'thread':

						$sending_array = array();
						$sending_array = $this->getThreadDetails($current_id, $sending_array);
						$sending_array = $this->getSubCatDetails($sending_array['subcategory']['id'], $sending_array);
						$sending_array = $this->getCatDetails($sending_array['category']['id'], $sending_array);
						$sending_array = $this->getSuperCatDetails($sending_array['supercategory']['id'], $sending_array);
						$sending_array = $this->getForumDetails($sending_array['forum']['id'], $sending_array);

						break;

					case 'subcategory':

						$sending_array = array();
						$sending_array = $this->getSubCatDetails($current_id, $sending_array);
						$sending_array = $this->getCatDetails($sending_array['category']['id'], $sending_array);
						$sending_array = $this->getSuperCatDetails($sending_array['supercategory']['id'], $sending_array);
						$sending_array = $this->getForumDetails($sending_array['forum']['id'], $sending_array);

						break;

					case 'category':

						$sending_array = array();
						$sending_array = $this->getCatDetails($current_id, $sending_array);
						$sending_array = $this->getSuperCatDetails($sending_array['supercategory']['id'], $sending_array);
						$sending_array = $this->getForumDetails($sending_array['forum']['id'], $sending_array);

						break;

					case 'forum':

						$sending_array = array();
						$sending_array = $this->getForumDetails($current_id, $sending_array);

						break;

					default:
						# code...
						break;
				}
				
				break;
			case 'article':
				switch($stage)
				{
						
				}
			default:
				# code...
				break;
		}

		return $sending_array;
	}

	// --------------------------  These are sub functions to the above function!!! AGAIN ASK PETER!!!!

	private function getThreadDetails($id, $full_array)
	{
		$db = Database::getDBI();
		// get thread information
		$sql = 'SELECT thread_subject, subCategory_id FROM forum_thread WHERE thread_id = ?';
		$db->query($sql, ['thread_id'=>$id]);
		$result = $db->single('arr');

		$full_array['thread']['id'] = $id;
		$full_array['thread']['subject'] = $result['thread_subject'];
		$full_array['subcategory']['id'] = $result['subCategory_id'];

		return $full_array;

	}

	private function getSubCatDetails($id, $full_array)
	{
		$db = Database::getDBI();
		// get thread information
		$sql = 'SELECT category_id, subCat_name FROM forum_subcategory WHERE subCategory_id = ?';
		$db->query($sql, ['subCategory_id'=>$id]);
		$result = $db->single('arr');

		$full_array['subcategory']['id'] = $id;
		$full_array['subcategory']['name'] = $result['subCat_name'];
		$full_array['category']['id'] = $result['category_id'];

		return $full_array;

	}

	private function getCatDetails($id, $full_array)
	{
		$db = Database::getDBI();
		// get thread information
		$sql = 'SELECT superCat_id, cat_name FROM forum_category WHERE category_id = ?';
		$db->query($sql, ['category_id'=>$id]);
		$result = $db->single('arr');

		$full_array['category']['id'] = $id;
		$full_array['category']['name'] = $result['cat_name'];
		$full_array['supercategory']['id'] = $result['superCat_id'];

		return $full_array;
	}

	private function getSuperCatDetails($id, $full_array)
	{
		$db = Database::getDBI();
		// get thread information
		$sql = 'SELECT forum_id, superCat_name FROM forum_supercategory WHERE superCat_id = ?';
		$db->query($sql, ['superCat_id'=>$id]);
		$result = $db->single('arr');

		$full_array['supercategory']['id'] = $id;
		$full_array['supercategory']['name'] = $result['superCat_name'];
		$full_array['forum']['id'] = $result['forum_id'];

		return $full_array;
	}

	private function getForumDetails($id, $full_array)
	{
		$db = Database::getDBI();
		// get thread information
		$sql = 'SELECT forum_name FROM forum WHERE forum_id = ?';
		$db->query($sql, ['forum_id'=>$id]);
		$result = $db->single('arr');

		$full_array['forum']['id'] = $id;
		$full_array['forum']['name'] = $result['forum_name'];

		return $full_array;
	}
	
	
}


?>
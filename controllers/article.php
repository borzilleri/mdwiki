<?php

class article_Controller extends MDController {

	public function index($title) {
		$article = new Article($title);
		if( !$article->exists() ) {
			// We want to add a new page.
			$this->add();
			return;
		}
		
		$view = new View('article_content');
		$view->article = $article;
		$view->render(true);
	}
	
	public function add() {
		echo "adding new page";
	}
}

?>

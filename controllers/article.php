<?php

class article_Controller extends Controller_Core {

	public function index($title) {
		$article = new Article($title);
		if( !$article->exists() ) {
			// We want to add a new page.
			$this->add();
			return;
		}
		
		$view = new View('page');
		$view->pageTitle = $article->title;
		$view->innerPage = new View('article_content');
		$view->innerPage->article = $article;
		
		$view->render(true);
	}
	
	public function add() {
		echo "adding new page";
	}
}

?>

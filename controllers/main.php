<?php defined('SYS_ROOT') OR die('Direct script access prohibited');

class main_Controller extends Controller_Core {
	function index() {
		$articles = Article::getAllArticles(true);
	
		$view = new View('page');
		$view->innerPage = new View('article_list');
		
		$view->pageTitle = sliMVC::config('core.app_name');
		$view->innerPage->pageList = $articles;
		
		$view->render(true);
	}
}

?>

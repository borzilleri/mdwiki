<?php defined('SYS_ROOT') OR die('Direct script access prohibited');

class main_Controller extends Controller_Core {
	function index() {
		$view = new View('article_list');
		$view->pageTitle = sliMVC::config('core.app_name');
		$view->articleList = Article::getAllArticles(true);
				
		$view->render(true);
	}
}

?>

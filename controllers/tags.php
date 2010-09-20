<?php

class tags_Controller extends Controller_Core {
	public function index($tag = null) {
		$view = new View('page');

		if( empty($tag) ) {
			$view = new View('tag_list');
			$view->tagList = Tag::getTagList();
			$view->pageTitle = sliMVC::config('core.app_name').' - All Tags';
		}
		else {
			$view = new View('article_list');
			$view->articleList = Tag::getArticlesByTag($tag);
			$view->pageTitle = "Articles Tagged with '{$tag}'";
		}
				
		$view->render(true);
	}
	
	public function route() {
		if( 0 == func_num_args() ) {
			$this->index();
			return;
		}
		$args = func_get_args();
		if( method_exists($this, $args[0]) ) {
			call_user_func_array(array($this, $args[0]), array_slice($args, 1));
		}
		else {
			$this->index(implode('/',$args));
		}
	}
	
}
?>
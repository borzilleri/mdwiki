<?php

class Article {
	protected static $parser = null;
	const T_DIRTY = -1;
	const CLEAN = 0;
	const DIRTY = 1;
	
	protected $title_loaded;
	protected $title;
	protected $text;
	protected $tags;
	
	private $status = self::T_DIRTY;
	
	public function __construct($title = null) {
		if( empty(self::$parser) ) {
			self::$parser = new Markdown_Parser;
		}
		if( !empty($title) ) {
			$this->load($title);
			$this->loadTags();
		}
	}
	
	public function load($title) {
		$file_path = $this->getFilePath($title);
		if( is_readable($file_path) && is_file($file_path) ) {
			$this->title_loaded = $title;
			$this->title = $title;
			$this->text = file_get_contents($file_path);
			$this->clean();
		}
	}
	
	public function loadTags() {
		$tags = array();
		$list = Tag::getTagList($this->title, false);
		foreach($list as $tag) {
			$tags[] = $tag['name'];
		}
		$this->tags = $tags;
	}
	
	public function update() {
		// Set article title.
		$title_tmp = trim(@$_REQUEST['articleTitle']);
		if( self::isValidTitle($title_tmp) ) {
			if( $title_tmp != $this->title ) {
				$this->title = $title_tmp;
				$this->dirty();
			}
		}
		else {
			/**
			 * @todo Need an exception/smarter error here.
			 */
			return false;
		}
		
		// Set Article Text
		$text_tmp = trim(@$_REQUEST['text']);
		if( $text_tmp != $this->text ) {
				$this->text = $text_tmp;
				$this->dirty();
		}
		
		// Set Article Tags
		$tagArray = explode(',',rtrim(ltrim(@$_REQUEST['tags'],','),','));
		foreach($this->tags as $k => $tag) {
			$ta_k = array_search($tag, $tagArray);
			if( false === $ta_k ) {
				unset($this->tags[$k]);
				$this->dirty();
			}
			else {
				unset($tagArray[$ta_k]);
			}
		}
		foreach($tagArray as $tag) {
			$this->tags[] = $tag;
 			$this->dirty();
		}
		
		return true;
	}
	
	public function save() {
		if( $this->isClean() ) return;
				
		if( $this->exists() && $this->title_loaded != $this->title ) {
			/**
			 * @todo Probably want to check this for errors.
			 */
			$this->delete();
		}
		
		file_put_contents($this->getFilePath(), $this->text);
				
		// Update Tags.
		Tag::updateArticleTags($this->title_loaded, $this->title, $this->tags);
	}
	
	public function delete() {
		return unlink($this->getFilePath($this->title_loaded));
	}

	public function getLink($rel = false) {
		return (bool)$rel ? 
			$this->getRelativeURI($this->title) : $this->getURI($this->title);
	}
	
	public function getFilePath($title = null) {
		return sliMVC::config('store.path')
			.(empty($title)?"/{$this->title}.text":"/{$title}.text");
	}
	
	public function render() {
		$text = $this->fixRelativeLinks(self::$parser->transform($this->text));
		return $text;
	}
	
	protected function fixRelativeLinks($text) {
		return preg_replace('/<a href="\/(\w+)"/', 
			'<a href="'.sliMVC::config('core.site_uri').'/'.sliMVC::config('core.page_prefix').'/$1"', $text);
	}
		
	protected function dirty() {
		$this->status = ($this->status==self::T_DIRTY) ? self::T_DIRTY:self::DIRTY;
	}
	protected function clean() {
		$this->status = self::CLEAN;
	}
	protected function isClean() {
		return $this->status == self::CLEAN;
	}
	public function exists() {
		return $this->status >= self::CLEAN;
	}

	public function setTitle($title) {
		$title = trim($title);
		if( self::isValidTitle($title) ) {
			if( $title != $this->title ) {
				$this->title = $title;
				$this->dirty();
			}
		}
	}
	
	public function __get($var) {
		switch($var) {
			case 'title':
			case 'text';
			case 'tags';
				return $this->$var;
			default:
				return null;
		}
	}
	
	public function __isset($var) {
		switch($var) {
			case 'title':
			case 'text':
				return isset($this->$var);
			case 'tags':
				return !empty($this->tags);
			default:
				return false;
		}
	}
	
	/**
	 * Validates an Article title
	 *
	 * An Article Title must contain only valid "word" characters.
	 * eg: 0-9, a-z, A-Z, _
	 *
	 * @param string $title
	 * @return bool
	 */
	public static function isValidTitle($title = "") {
		if( preg_match('/^\w+$/', $title) ) return true;
		return false;
	}

	public static function getRelativeURI($title) {
		return '/'.sliMVC::config('core.page_prefix').'/'.$title;
	}
	
	public static function getURI($title) {
		return sliMVC::config('core.site_uri').Article::getRelativeURI($title);
	}
	
	public static function getAllArticles($titlesOnly = false) {
		$articles = array();
		$dir = scandir(sliMVC::config('store.path'));
		foreach($dir as $file) {
			if( '.' != substr($file,0,1) && '.text' == substr($file,-5) ) {
				$title = substr($file,0,-5);
				$articles[] = $titlesOnly ? $title : new Article($title);
			}
		}
		return $articles;
	}
}

?>

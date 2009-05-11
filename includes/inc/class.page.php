<?php
/**
 * $Id$
 * Page class
 *
 */

class Page {  
  const T_DIRTY = -1;
  const CLEAN = 0;
  const DIRTY = 1;
  
  protected $title_loaded;
  protected $title;
  protected $text;
  
  private $status = self::T_DIRTY;
  
  public function __construct($pageTitle = null) {
    if( !empty($pageTitle) ) {
      $this->load($pageTitle);
    }
  }
  
  
  public function load($pageTitle) {
    $file_path = $this->getFilePath($pageTitle);
    if( is_readable($file_path) && is_file($file_path) ) {
      $this->title_loaded = $pageTitle;
      $this->title = $pageTitle;
      $this->text = file_get_contents($file_path);
      $this->clean();
    }
  }
  
  public function update() {
    $pageTitle_tmp = trim(@$_REQUEST['pageTitle']);
    if( self::isValidTitle($pageTitle_tmp) ) {
      if( $pageTitle_tmp != $this->title ) {
        $this->title = $pageTitle_tmp;
        $this->dirty();
      }
    }
    else {
      /**
       * @todo Need an exception/smarter error here.
       */
      return false;
    }
    
    $pageText_tmp = trim(@$_REQUEST['pageText']);
    if( $pageText_tmp != $this->text ) {
        $this->text = $pageText_tmp;
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
  }
  
  public function delete() {
    return unlink($this->getFilePath($this->title_loaded));
  }

	public function getLink($rel = false) {
		return (bool)$rel ? $this->getRelLink($this->title) : $this->getURI($this->title);
	}
  
  public function getFilePath($pageTitle = null) {
    global $config;
    if( !empty($pageTitle) ) {
      return $config['pages_path']."/{$pageTitle}.text";
    }
    else {
      return $config['pages_path']."/{$this->title}.text";
    }
  }
  
  public function render() {
    return $this->fixRelativeLinks(Markdown($this->text));
  }
  
  protected function fixRelativeLinks($text) {
    return preg_replace('/<a href="\/(\w+)"/', '<a href="'.BASE_PATH.'/page/$1"', $text);
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

	public function setTitle($pageTitle) {
    $pageTitle = trim($pageTitle);
    if( self::isValidTitle($pageTitle) ) {
      if( $pageTitle != $this->title ) {
        $this->title = $pageTitle;
        $this->dirty();
      }
    }
	}
  
  public function __get($var) {
    switch($var) {
      case 'title':
        return $this->title;
      case 'text':
        return $this->text;
      default:
        return null;
    }
  }
  
  /**
   * Validates a page title
   *
   * A Page Title must contain only valid "word" characters.
   * eg: 0-9, a-z, A-Z, _
   *
   * @param string $pageTitle
   * @return bool
   */
  public static function isValidTitle($pageTitle = "") {
    if( preg_match('/^\w+$/', $pageTitle) ) return true;
    return false;
  }

	public static function getRelLink($pageTitle) {
		global $config;
		return '/'.$config['pages_prefix'].'/'.$pageTitle;
	}
  
  public  static function getURI($pageTitle) {
		return 'http://'.SITE_ROOT.Page::getRelLink($pageTitle);
  }
  
  public static function getAllPages($titlesOnly = false) {
    global $config;
    $pages = array();
    $dir = scandir($config['pages_path']);
    foreach($dir as $file) {
      if( '.' != substr($file,0,1) && '.text' == substr($file,-5) ) {
        $title = substr($file,0,-5);
        $pages[] = $titlesOnly ? $title : new Page($title);
      }
    }
    return $pages;
  }
}

?>

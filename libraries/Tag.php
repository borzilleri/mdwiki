<?php
/**
 * Tag class
 *
 */

class Tag {	
	protected static $tags_CREATE = 'CREATE TABLE IF NOT EXISTS tags (name TEXT PRIMARY KEY ASC, parent TEXT REFERENCES tags(name))';
	protected static $pageTags_CREATE = 'CREATE TABLE IF NOT EXISTS pageTags (page TEXT NOT NULL, tag TEXT REFERENCES tags(name))';
		
	protected static $db;
	
	protected static function initializeConnection() {		
		self::$db = new SQLite3(sliMVC::config('store.db_file'));
		
		if( self::$db ) {
			self::buildTables();
		}
		else {
			/**
			 * error opening db connection!
			 */
			die(sprintf("Error opening DB connection."));
		}
	}
	
	public static function buildTables() {
		if( !self::$db->exec(self::$tags_CREATE) ) {
			die(sprintf("Error building Tags table: %s", $db->lastErrorMsg()));
		}
		if( !self::$db->exec(self::$pageTags_CREATE) ) {
			die(sprintf("Error building pageTags table: %s", $db->lastErrorMsg()));
		}
	}
	
	public static function getArticlesByTag($tag) {
		self::initializeConnection();
		$andTags = explode('/',$tag);
		$firstTag = explode('+',rtrim(ltrim(array_shift($andTags))));
		$i = 1;
		
		$baseSql = "SELECT p.page FROM pageTags as p ";
		$joins = array();
		$wheres = array();
		
		$wheres[] = sprintf("p.tag IN ('%s') ",implode("','",$firstTag));
		
		foreach($andTags as $atag) {
			$orTags = explode('+',rtrim(ltrim($atag)));
			$p_table = "p$i";
			$i+=1;
			
			$joins[] = sprintf("LEFT JOIN pageTags as %s ON (p.page=%s.page)",$p_table,$p_table);
			$wheres[] = sprintf("%s.tag IN ('%s')",$p_table,implode("','",$orTags));
		}
		
		$baseSql = $baseSql . implode(' ',$joins) .
			' WHERE ' . implode(' AND ',$wheres) .
			' GROUP BY p.page ORDER BY p.page ASC';
		
		$resultSet = self::$db->query($baseSql);
		$resultArray = array();
		while($row = $resultSet->fetchArray()) {
			$resultArray[] = $row['page'];
		}
		
		return $resultArray;
	}
	
	public static function getTagList($article = null, $allTags = true, $fetchMode = SQLITE3_ASSOC) {
		self::initializeConnection();
		$tags = array();
		
		if( !is_null($article) ) {
			if( $allTags ) {
				$query = self::$db->prepare(
					'SELECT t.name,t.parent,(p.page=:page) as hasTag 
					FROM tags as t
					LEFT JOIN pageTags as p ON (p.tag=t.name)
					ORDER BY t.name ASC'
				);
			}
			else {
				$query = self::$db->prepare(
					'SELECT t.name,t.parent,p.page as hasTag
					FROM tags as t
					INNER JOIN pageTags as p ON (p.tag=t.name)
					WHERE page=:page'
				);
			}
			$query->bindValue(':page', $article);
			$result = $query->execute();
		}
		else {
			$result = self::$db->query('SELECT t.name,t.parent,0 as hasTag FROM tags as t');
		}
		
		while($row = $result->fetchArray($fetchMode)) {
			$tags[] = $row;
		}
		return $tags;
	}
	
	public static function updateArticleTags($oldArticle, $newArticle, $tags) {
		self::initializeConnection();
		
		$query = self::$db->prepare('DELETE FROM pageTags WHERE page=:page');
		$query->bindValue(':page',$oldArticle);
		$query->execute();
		
		$query = self::$db->prepare(
			'REPLACE INTO pageTags (page,tag) VALUES (:page,:tag)');
		$query->bindValue(':page',$newArticle);
		foreach($tags as $t) {
			$query->reset();
			$query->bindValue(':tag', $t);			
			$query->execute();
		}
	}
}

?>

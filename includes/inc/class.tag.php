<?php
/**
 * Tag class
 *
 */

class Tag {
	const DB_FILE_NAME = 'tags.db';
	
	protected static $tags_CREATE = 'CREATE TABLE IF NOT EXISTS tags (name TEXT PRIMARY KEY ASC, parent TEXT REFERENCES tags(name))';
	protected static $pageTags_CREATE = 'CREATE TABLE IF NOT EXISTS pageTags (page TEXT NOT NULL, tag TEXT REFERENCES tags(name))';
		
	protected static $db;
	
	protected static function initializeConnection() {
		global $config;
		
		self::$db = new SQLite3($config['pages_path'].'/'.self::DB_FILE_NAME);
			
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
	
	public static function getPagesByTag($tag) {
		self::initializeConnection();
		$andTags = explode('/',$tag);
		$firstTag = explode(' ',rtrim(ltrim(array_shift($andTags))));
		$i = 1;
		
		$baseSql = "SELECT p.page FROM pageTags as p ";
		$joins = array();
		$wheres = array();
		
		$wheres[] = sprintf("p.tag IN ('%s') ",implode("','",$firstTag));
		
		foreach($andTags as $atag) {
			$orTags = explode(' ',rtrim(ltrim($atag)));
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
	
	public static function getTagList($page = null, $allTags = true, $fetchMode = SQLITE3_ASSOC) {
		self::initializeConnection();
		$tags = array();
		
		if( !is_null($page) ) {
			if( $allTags ) {
				$query = self::$db->prepare('SELECT t.name,t.parent,p.page as hasTag 
					FROM tags as t
					LEFT JOIN pageTags as p ON (p.tag=t.name)
					WHERE p.page IS NULL OR p.page=:page
					ORDER BY t.name ASC');
			}
			else {
				$query = self::$db->prepare('SELECT t.name,t.parent,p.page as hasTag
					FROM tags as t
					INNER JOIN pageTags as p ON (p.tag=t.name)
					WHERE page=:page');
			}
			$query->bindValue(':page', $page);
			$result = $query->execute();
		}
		else {
			$result = self::$db->query('SELECT t.name,t.parent FROM tags as t');
		}
		
		while($row = $result->fetchArray($fetchMode)) {
			$tags[] = $row;
		}
		return $tags;
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=$pageTitle;?></title>

  <link rel="stylesheet" media="screen" href="/css/default.css">
<? foreach($this->css_includes as $css):?>
	<link rel="stylesheet" media="scren" href="/css/<?=$css;?>">
<? endforeach;?>

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<? foreach($this->js_includes as $js): ?>
	<script type="text/javascript" src="/js/<?=$js;?>"></script>
<? endforeach;?>

	<script type="text/javascript">
function getParameterByName( name )
	{
	  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	  var regexS = "[\\?&]"+name+"=([^&#]*)";
	  var regex = new RegExp( regexS );
	  var results = regex.exec( window.location.href );
	  if( results == null )
	    return "";
	  else
	    return decodeURIComponent(results[1].replace(/\+/g, " "));
}
	</script>
</head>
<body>
	<header>
		<div id="authentication">
		<? if( false && !@$_REQUEST['manual'] ): //AUTHENTICATED USER ?>
			<ul>
				<li><a href="javascript:;">Username!</a></li>
				<li><a href="/logout">Logout</a></li>
			</ul>
		<? elseif( @$_REQUEST['manual'] ): //FORCE MANUAL LOGIN FORM ?>
			<form method="post" action="http://<?=$_SERVER['HTTP_HOST'];?>/auth/login">
				<div>
					<input name="source_page" type="hidden" value="<?=$_SERVER['REQUEST_URI'];?>">
					<label for="username">u:</label><input name="username" id="username"
						type="text" maxlength="255" accesskey="u" />
					<label for="password">p:</label><input name="password" id="password" 
						type="password" maxlength="255" accesskey="p" />
					<input type="submit" value="Login" />
				</div>
			</form>
		<? else: // GUEST USER, SHOW OPENID LOGIN?>
			<form method="post" action="http://<?=$_SERVER['HTTP_HOST'];?>/auth/openid">
				<div>
					<input name="source_page" type="hidden" value="<?=$_SERVER['REQUEST_URI'];?>">
					<label for="openid_module">Sign In With:</label>
					<select name="openid_module" id="openid_module">
						<option value="google">Google</option>
					</select>
					<input type="submit" value="Login"/>
				</div>
			</form>		
		<? endif; ?>
		</div>
		<h1><?=$pageTitle;?></h1>
		<nav>
			<ul>
				<li><a href="<?=sliMVC::config('core.site_uri');?>" accesskey="l">list</a></li
				><li><a href="<?=sliMVC::config('core.site_uri');?>/tags" accesskey="t">tags</a></li
				><? if( false ): // AUTH'D USERS ONLY ?><li
				><a href="<?=sliMVC::config('core.site_uri');?>/add#form" accesskey="n">new</a></li
				><? if( false ): // AUTH'D USERS ONLY, W/VALID PAGE ?><li
				><a href="<?=Article::getURI($_REQUEST['page']);?>/edit#form" accesskey="e">edit</a></li>
				<? endif; ?>
			<? endif; ?>
			</ul>
		</nav>
	</header>
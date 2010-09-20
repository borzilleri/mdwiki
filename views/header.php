<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" media="screen" href="/css/default.css" />
  <title><?=$pageTitle;?></title>
</head>
<body>
	<header>
		<div id="login">
		<? if( false ): ?>
			<a href="/logout">logout</a>
		<? else: ?>
		<form method="post" action="http://<?=$_SERVER['HTTP_HOST'];?><?=$_SERVER['REQUEST_URI'];?>">
			<div>
				<input name="action" type="hidden" value="login" />
				<label for="username">u:</label><input name="username" id="username"
					type="text" size="10" maxlength="255" accesskey="u" />
				<label for="password">p:</label>
				<input name="password" type="password" id="password"
					size="10" maxlength="255" accesskey="p" />
				<input type="submit" value="login" />
			</div>
		</form>
		<? endif; ?>
		</div>
		<div id="pageLinks">
			[ <a href="<?=sliMVC::config('core.site_uri');?>" accesskey="l">list</a>
			| <a href="<?=sliMVC::config('core.site_uri');?>/tags" accesskey="t">tags</a>
			<? if( false ): ?>
			| <a href="<?=sliMVC::config('core.site_uri');?>/add#form" accesskey="n">new</a>
			<? if( false ): ?>
			| <a href="<?=Article::getURI($_REQUEST['page']);?>/edit#form" accesskey="e">edit</a>
			<? endif; ?>
		<? endif; ?> ]
		</div>
		<div class="clear"></div>
	</header>
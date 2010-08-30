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
	<section id="mainContent">
	<?=$innerPage->render(); ?>
	</section>
	<footer>
  	<div id="validation">
			<!-- TODO: re-add this when html5 validation works on w3.org 
  	  <a href="http://validator.w3.org/check?uri=referer">html5</a>
  	  &bull; -->
  	  <a href="http://jigsaw.w3.org/css-validator/check/referer">css</a>
  	</div>
  	<div id="copyright">Powered By MDWiki &copy;Asylum Software 2009</div>
	</footer>
</body>
</html>

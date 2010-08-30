<ul>
  <? foreach($tagList as $tag): ?>
  <li>
    <a href="<?=sliMVC::config('core.site_uri');?>/tags/<?=$tag['name'];?>"><?=$tag['name'];?></a>
  </li>
<? endforeach; ?>
</ul>

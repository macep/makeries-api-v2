<div class="row">
    <?php foreach ($images as $image) :?>
    <div class="col-lg-3 col-xs-6">
      <br><?=$image->name?>
      <br><img width="100px" src="/image/view?maker_id=<?=$maker_id?>&id=<?=$image->id?>"></img>
      <br><a href="/image/delete?maker_id=<?=$maker_id?>&id=<?=$image->id?>" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-remove"></i></a>
    </div>
    <?php endforeach;?>
</div>
<div id="projectImages"></div>
<?php if (isset($pagination) && $pagination['pages']>1) :?>
<ul class="pagination">
<?php
$link = '/maker/index/?';
?>
   <?php for ($i=$pagination['start']; $i<=$pagination['end']; $i++) :?>
   <li<?=$i==$pagination['current'] ? ' class="current"':''?>><a onclick="reloadMakerMedia(<?=$i?>);return false;" href='<?=$link.'&pageNr='.$i.$linkMore?>'><?=$i?></a></li>
   <?php endfor;?>
</ul>
<?php endif;?>

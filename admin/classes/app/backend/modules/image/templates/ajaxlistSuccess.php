<div class="row">
  <div class="col-sm-offset-2 col-sm-10">
    <hr>
    <div class="row">
        <?php foreach ($images as $image) :?>
        <div class="col-lg-3 col-xs-6">
          <h6 class="text-ellipsis"><?=$image->name?></h6>
          <div class="image-container" style="background-image: url(/image/view?maker_id=<?=$maker_id?>&id=<?=$image->id?>)">
            <a href="/image/delete?maker_id=<?=$maker_id?>&id=<?=$image->id?>" onclick="deleteMakerImage(<?=$image->id?>);return false;">
              <i class="fa fa-trash"></i>
            </a>
          </div>
        </div>
        <?php endforeach;?>
    </div>
  </div>
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

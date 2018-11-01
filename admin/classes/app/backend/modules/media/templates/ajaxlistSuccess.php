<?php $pos =1 ;?>
<table class="table table-hover" width="100%">
    <tr><thead><th style="width:20px;">#</th><th>NAME</th><th>WEB</th><th style="width:20px;"></th></thead></tr>
    <?php foreach ($medias as $media) :?>
    <tr>
        <td><?=(($pagination['current']-1)*$pagination['per']+$pos++)?></td>
        <th><a href="/media/edit?id=<?=$media->id?>"><?=$media->name?></a></th>
        <td><?=$media->url?></td>
        <td><a href="/media/delete?id=<?=$media->id?>" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-remove"></i></a></td>
    </tr>
    <?php endforeach;?>
</table>
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

<div class="row">
    <?php foreach ($images as $image) :?>
    <div class="col-lg-3 col-xs-6">
      <br><?=$image->name?>
      <br><img width="100px" src="/projectimage/view?project_id=<?=$project_id?>&id=<?=$image->id?>"></img>
      <br><a href="/image/delete?project_id=<?=$project_id?>&id=<?=$image->id?>" onclick="deleteProjectImage(<?=$project_id?>, <?=$image->id?>);return false;" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-remove"></i></a>
    </div>
    <?php endforeach;?>
</div>

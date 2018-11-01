<?php $pos =1 ;?>
<table class="table table-hover" width="100%">
    <tr><thead><th style="width:20px;">#</th><th>NAME</th><th>IMAGES</th><th style="width:20px;"></th></thead></tr>
    <?php foreach ($projects as $project) :?>
    <tr>
        <td><?=(($pagination['current']-1)*$pagination['per']+$pos++)?></td>
        <th><a href="/project/edit?id=<?=$project->id?>"><?=$project->name?></a></th>
        <th><a href="/project/edit?id=<?=$project->id?>" onclick="loadImages(<?=$project->id?>);return false;">IMAGES</a></th>
        <td><a href="/project/delete?id=<?=$project->id?>" onclick="return confirm('Are you sure?');" class="btn btn-danger btn-xs"><i class="fa fa-fw fa-remove"></i></a></td>
    </tr>
    <?php endforeach;?>
</table>

<?php if (isset($pagination) && $pagination['pages']>1) :?>
<ul class="pagination">
<?php
$link = '/maker/index/?';
?>
   <?php for ($i=$pagination['start']; $i<=$pagination['end']; $i++) :?>
   <li<?=$i==$pagination['current'] ? ' class="current"':''?>><a onclick="reloadMakerProject(<?=$i?>);return false;" href='<?=$link.'&pageNr='.$i.$linkMore?>'><?=$i?></a></li>
   <?php endfor;?>
</ul>
<?php endif;?>

<script>
   function loadProjectImagePage(projectId) {
       $.get( "/projectimage/page?project_id="+projectId, function( data ) {
           //$( "#makerImage" ).html( data );
           console.log('project image page');
           $("#modal-default div.modal-body p").html(data);
           reloadProjectImage(projectId);
       });
   }
   function reloadProjectImage(projectId, pageNr=1) {
       $.get( "/projectimage/ajaxlist?project_id="+projectId+"&page_nr="+pageNr, function( data ) {
           console.log('project image list');
           $("#projectImagesAjaxList").html(data);
       });
   }
   function loadImages(projectId) {
      console.log('ProjectID:' + projectId);
      $("#openModalDefault").click();
      $("#modal-default h4").text('Project Images');
      $("#modal-default div.modal-body p").html('');
      loadProjectImagePage(projectId);
   }
   function deleteProjectImage(projectId, imageId) {
        var r = confirm("Are you sure!");
        if (r == true) {
            $.get( "/projectimage/delete?maker_id=<?=$project->maker_id?>&project_id="+projectId+"&id="+imageId, function( data ) {
                //$( "#makerImage" ).html( data );
                reloadProjectImage(projectId);
            });
        }
        return false;
   }
</script>
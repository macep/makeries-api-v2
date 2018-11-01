<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Update media</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
         <?php if ($media) :?>
         <form method="post" action="/media/save/" id="mediaSave" class="form-horizontal">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Maker : <?=$maker->name?></label>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="newSuplier" value="<?=$media->name?>" placeholder="media name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">URL</label>
                    <div class="col-sm-10">
                        <input type="text" name="url" class="form-control" id="newSuplier" value="<?=$media->name?>" placeholder="media url">
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="maker_id" value="<?=$media->maker_id?>">
                    <input type="hidden" name="id" value="<?=$media->id?>">
                    <input type="submit" name="submit" value="Save" class="btn btn-primary">
                </div>
         </form>
         <?php else:?>
         <div class="callout callout-danger">
             <h4>Error</h4>
             <p>Region ID not found</p>
         </div>
         <?php endif;?>
    </div>
    <!-- /.box-body -->
</div>
<script>
$('#mediaSave').submit(function(){
    $.post( "/media/ajaxsave",  $( this ).serialize() )
        .done(function( data ) {
//console.log(data);
            if ('0' == data.substring(0,1)) {
                $("#openModalDefault").click();
                $("#modal-default h4").text('Error');
                $("#modal-default div.modal-body p").html(data.substring(1));
            } else {
                window.location.href = '/maker/view?id=<?=$maker->id?>&tab=media';
            }
        });
    
    event.preventDefault();
    return false;
});
</script>

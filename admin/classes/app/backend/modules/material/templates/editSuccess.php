<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Update material</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
         <?php if ($material) :?>
         <form method="post" action="/material/save/" id="materialSave" class="form-horizontal">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" id="newSuplier" value="<?=$material->name?>" placeholder="material name">
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="id" value="<?=$material->id?>">
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
$('#materialSave').submit(function(){
    $.post( "/material/ajaxsave",  $( this ).serialize() )
        .done(function( data ) {
//console.log(data);
            if ('0' == data.substring(0,1)) {
                $("#openModalDefault").click();
                $("#modal-default h4").text('Error');
                $("#modal-default div.modal-body p").html(data.substring(1));
            } else {
                window.location.href = '/material/index';
            }
        });
    
    event.preventDefault();
    return false;
});
</script>

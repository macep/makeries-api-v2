<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?=isset($makergroup->id) ? 'Update':'Create'?> makergroup</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
         <?php if ($makergroup) :?>
         <form method="post" action="/makergroup/save/" id="makergroupSave" class="form-horizontal">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="newSuplier" value="<?=$makergroup->name?>" placeholder="makergroup name">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Regions</label>
                <div class="col-sm-10">
                    <select name="region_id[]" multiple size="7" class="form-control">
                        <?php foreach ($regions as $region):?>
                        <option value="<?=$region->id?>"<?=containsId($makergroup, 'regions',$region->id)?' selected':''?>><?=$region->name?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Products</label>
                <div class="col-sm-10">
                    <select name="product_id[]" multiple size="7" class="form-control">
                        <?php foreach ($products as $product):?>
                        <option value="<?=$product->id?>"<?=containsId($makergroup, 'products',$product->id)?' selected':''?>><?=$product->name?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Business types</label>
                <div class="col-sm-10">
                    <select name="business_type_id[]" multiple size="7" class="form-control">
                        <?php foreach ($businessTypes as $businessType):?>
                        <option value="<?=$businessType->id?>"<?=containsId($makergroup, 'businesstypes',$businessType->id)?' selected':''?>><?=$businessType->name?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Service Types</label>
                <div class="col-sm-10">
                    <select name="service_type_id[]" multiple size="7" class="form-control">
                        <?php foreach ($serviceTypes as $serviceType):?>
                        <option value="<?=$serviceType->id?>"<?=containsId($makergroup, 'servicetypes',$serviceType->id)?' selected':''?>><?=$serviceType->name?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="box-footer">
                <input type="hidden" name="id" value="<?=$makergroup->id?>">
                <input type="submit" name="submit" value="Save" class="btn btn-primary">
            </div>
         </form>
         <?php else:?>
         <div class="callout callout-danger">
             <h4>Error</h4>
             <p>Maker Group ID not found</p>
         </div>
         <?php endif;?>
    </div>
    <!-- /.box-body -->
</div>
<script>
$('#makergroupSave').submit(function(){
    $.post( "/makergroup/ajax",  $( this ).serialize() )
        .done(function( data ) {
//console.log(data);
            if ('0' == data.substring(0,1)) {
                $("#openModalDefault").click();
                $("#modal-default h4").text('Error');
                $("#modal-default div.modal-body p").html(data.substring(1));
            } else {
                window.location.href = '/makergroup/index';
            }
        });
    
    event.preventDefault();
    return false;
});
</script>


<?php
function containsId($makergroup, $objectName, $id) {
    if (!isset($makergroup->$objectName)) {
        return false;
    }
    foreach ($makergroup->$objectName as $object) {
        if ($object->id == $id) {
            return true;
        }
    }
    return false;
}

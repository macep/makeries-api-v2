<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?=isset($maker->id) ? 'Update':'Create'?> maker</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
         <?php if ($maker) :?>
         <form method="post" action="/maker/save/" id="makerSave" class="form-horizontal">
            <div class="form-group">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" value="<?=$maker->name?>" placeholder="maker name">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Address1</label>
                <div class="col-sm-10">
                    <input type="text" name="address1" class="form-control" value="<?=$maker->address1?>" placeholder="maker address1">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Address2</label>
                <div class="col-sm-10">
                    <input type="text" name="address2" class="form-control" value="<?=$maker->address2?>" placeholder="maker address2">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">City</label>
                <div class="col-sm-10">
                    <input type="text" name="city" class="form-control" value="<?=$maker->city?>" placeholder="maker city">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Post code</label>
                <div class="col-sm-10">
                    <input type="text" name="postcode" class="form-control" value="<?=$maker->postcode?>" placeholder="maker postal code">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" name="email" class="form-control" value="<?=$maker->email?>" placeholder="maker email">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Telephone</label>
                <div class="col-sm-10">
                    <input type="text" name="telephone" class="form-control" value="<?=$maker->telephone?>" placeholder="maker telephone number">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Website</label>
                <div class="col-sm-10">
                    <input type="text" name="website" class="form-control" value="<?=$maker->website?>" placeholder="maker website">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Social1</label>
                <div class="col-sm-10">
                    <input type="text" name="social1" class="form-control" value="<?=$maker->social1?>" placeholder="maker social1">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Social2</label>
                <div class="col-sm-10">
                    <input type="text" name="social2" class="form-control" value="<?=$maker->social2?>" placeholder="maker social2">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Social3</label>
                <div class="col-sm-10">
                    <input type="text" name="social3" class="form-control" value="<?=$maker->social3?>" placeholder="maker social3">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Map Url</label>
                <div class="col-sm-10">
                    <input type="text" name="map_url" class="form-control" value="<?=$maker->map_url?>" placeholder="maker map url">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Admin Email</label>
                <div class="col-sm-10">
                    <input type="text" name="admin_email" class="form-control" value="<?=$maker->admin_email?>" placeholder="maker admin email">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Brief description</label>
                <div class="col-sm-10">
                    <textarea name="brief_description" class="form-control" placeholder="brief description"><?=$maker->brief_description?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Long description</label>
                <div class="col-sm-10">
                    <textarea name="long_description" class="form-control" placeholder="long description"><?=$maker->long_description?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="published" value="1" <?=$maker->published == 'yes'?' checked':''?>> Published
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="featured" value="1" <?=$maker->featured == 'yes' ?' checked':''?>> Featured
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="subscription" value="1" <?=$maker->subscription == 'yes' ?' checked':''?>> Subscription
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Regions</label>
                <div class="col-sm-10">
                    <select name="region_id[]" multiple size="7" class="form-control">
                        <?php foreach ($regions as $region):?>
                        <option value="<?=$region->id?>"<?=containsId($maker, 'regions',$region->id)?' selected':''?>><?=$region->name?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Products</label>
                <div class="col-sm-10">
                    <select name="product_id[]" multiple size="7" class="form-control">
                        <?php foreach ($products as $product):?>
                        <option value="<?=$product->id?>"<?=containsId($maker, 'products',$product->id)?' selected':''?>><?=$product->name?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Business types</label>
                <div class="col-sm-10">
                    <select name="business_type_id[]" multiple size="7" class="form-control">
                        <?php foreach ($businessTypes as $businessType):?>
                        <option value="<?=$businessType->id?>"<?=containsId($maker, 'businesstypes',$businessType->id)?' selected':''?>><?=$businessType->name?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Service Types</label>
                <div class="col-sm-10">
                    <select name="service_type_id[]" multiple size="7" class="form-control">
                        <?php foreach ($serviceTypes as $serviceType):?>
                        <option value="<?=$serviceType->id?>"<?=containsId($maker, 'servicetypes',$serviceType->id)?' selected':''?>><?=$serviceType->name?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Maker Groups</label>
                <div class="col-sm-10">
                    <select name="maker_group_id[]" multiple size="7" class="form-control">
                        <?php foreach ($makerGroups as $makerGroup):?>
                        <option value="<?=$makerGroup->id?>"<?=containsId($maker, 'makergroups',$makerGroup->id)?' selected':''?>><?=$makerGroup->name?></option>
                        <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="box-footer">
                <input type="hidden" name="id" value="<?=$maker->id?>">
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
$('#makerSave').submit(function(){
    $.post( "/maker/ajax",  $( this ).serialize() )
        .done(function( data ) {
//console.log(data);
            if ('0' == data.substring(0,1)) {
                $("#openModalDefault").click();
                $("#modal-default h4").text('Error');
                $("#modal-default div.modal-body p").html(data.substring(1));
            } else {
                window.location.href = '/maker/index';
            }
        });
    
    event.preventDefault();
    return false;
});
</script>


<?php
function containsId($maker, $objectName, $id) {
    if (!isset($maker->$objectName)) {
        return false;
    }
    foreach ($maker->$objectName as $object) {
        if ($object->id == $id) {
            return true;
        }
    }
    return false;
}
<style>
    span.red{
        color: #900 !important;
        font-weight:bold;
    }
</style>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?=isset($maker->id) ? 'Update':'Create'?> maker</h3>
    </div>
    <!-- /.box-header -->

    <div class="row">
        <div class="col-sm-5">
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
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Min</label>
                <div class="col-sm-10">
                    <input type="text" name="min" class="form-control" value="<?=$maker->min?>" placeholder="min">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Max</label>
                <div class="col-sm-10">
                    <input type="text" name="max" class="form-control" value="<?=$maker->max?>" placeholder="max">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Map Url</label>
                <div class="col-sm-10">
                    <input type="text" name="map_url" class="form-control" value="<?=$maker->map_url?>" placeholder="maker map url">
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
                    <label class="col-sm-2 control-label">What we do</label>
                    <div class="col-sm-10">
                        <textarea name="what_we_do" class="form-control" placeholder="what_we_do" style="height:140px !important;"><?=$maker->what_we_do?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Testimonials</label>
                    <div class="col-sm-10">
                        <textarea name="testimonials" class="form-control" placeholder="testimonials" style="height:140px !important;"><?=$maker->testimonials?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Story description</label>
                    <div class="col-sm-10">
                        <textarea name="story_description" class="form-control" placeholder="story description" style="height:140px !important;"><?=$maker->story_description?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Company description</label>
                    <div class="col-sm-10">
                        <textarea name="company_description" class="form-control" placeholder="company_description" style="height:140px !important;"><?=$maker->company_description?></textarea>
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
                    <label class="col-sm-2 control-label">Materials</label>
                    <div class="col-sm-10">
                        <select name="material_id[]" multiple size="7" class="form-control">
                            <?php foreach ($materials as $material):?>
                            <option value="<?=$material->id?>"<?=containsId($maker, 'materials',$material->id)?' selected':''?>><?=$material->name?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Capacities</label>
                    <div class="col-sm-10">
                        <select name="capacity_id[]" multiple size="7" class="form-control">
                            <?php foreach ($capacities as $capacity):?>
                            <option value="<?=$capacity->id?>"<?=containsId($maker, 'capacities',$capacity->id)?' selected':''?>><?=$capacity->name?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Services</label>
                    <div class="col-sm-10">
                        <select name="service_id[]" multiple size="7" class="form-control">
                            <?php foreach ($services as $service):?>
                            <option value="<?=$service->id?>"<?=containsId($maker, 'services',$service->id)?' selected':''?>><?=$service->name?></option>
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

        <div class="col-sm-7">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active <?=($tab=='image'  ?'active':'')?>"><a href="#images" data-toggle="tab" aria-expanded="true">Images</a></li>
                  <li class="<?=($tab=='project'?'active':'')?>"><a href="#projects" data-toggle="tab" aria-expanded="false">Projects</a></li>
                  <li class="<?=($tab=='media'  ?'active':'')?>"><a href="#media" data-toggle="tab" aria-expanded="false">Media</a></li>
                  <li class="<?=($tab=='text'   ?'active':'')?>"><a href="#text" data-toggle="tab" aria-expanded="false">Texts</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active<?=($tab=='image' ?' active':'')?>" id="images">
                        <form class="form-horizontal" action="/image/ajaxsave" id="imageSave"  method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                              <label for="inputName" class="col-sm-2 control-label">Name</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="makerImageName" name="name" value="" placeholder="Name">
                              </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">File</label>
                                <div class="col-sm-10">
                                <input type="file" class="form-control" id="makerImageFile" name="upfile">
                                <small>Allowed images are: JPEG, GIF and PNG</small>
                                </div>
                            </div>
                            <div class="form-group">
                              <div class="col-sm-offset-2 col-sm-10">
                                <span class="red hide makerImageErr"></span><br>
                                <input type="hidden" name="maker_id" value="<?=$maker->id?>">
                                <button type="submit" class="btn btn-primary">Add image</button>
                              </div>
                            </div>
                        </form>
                        <div id="makerImage"></div>
                    </div>
                    <div class="tab-pane<?=($tab=='project' ?' active':'')?>" id="projects">
                        <form class="form-horizontal" action="/project/ajaxsave" id="projectSave">
                            <div class="form-group">
                              <label for="inputName" class="col-sm-2 control-label">Name</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="makerProjectName" name="name" value="" placeholder="Name">
                              </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-10">
                                  <textarea name="description" class="form-control" id="makerProjectDescription"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                              <div class="col-sm-offset-2 col-sm-10">
                                <input type="hidden" name="maker_id" value="<?=$maker->id?>">
                                <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </div>
                        </form>
                        <div id="makerProject"></div>
                    </div>
                    <div class="tab-pane<?=($tab=='media' ?' active':'')?>" id="media">
                        <form class="form-horizontal" action="/media/ajaxsave" id="mediaSave">
                            <div class="form-group">
                              <label for="inputName" class="col-sm-2 control-label">Name</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputName" name="name" value="" placeholder="Name">
                              </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">URL</label>
                                <div class="col-sm-10">
                                  <input type="text" class="form-control" id="inputUrl" name="url" value="" placeholder="url">
                                </div>
                            </div>
                            <div class="form-group">
                              <div class="col-sm-offset-2 col-sm-10">
                                <input type="hidden" name="maker_id" value="<?=$maker->id?>">
                                <button type="submit" class="btn btn-primary">Save</button>
                              </div>
                            </div>
                        </form>
                        <div id="makerMedia"></div>
                    </div>
                    <div class="tab-pane<?=($tab=='text' ?' active':'')?>" id="text">
                        <h3>What we do</h3>
                        <p><?=nl2br($maker->what_we_do)?></p>
                        <h3>Testimonials</h3>
                        <p><?=nl2br($maker->testimonials)?></p>
                        <h3>Story description</h3>
                        <p><?=nl2br($maker->story_description)?></p>
                        <h3>Company description</h3>
                        <p><?=nl2br($maker->company_description)?></p>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </div>
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
                window.location.href = '/maker/view?id='+data;
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
?>

<script>
    function reloadMakerImage(pageNr=1) {
        $.get( "/image/ajaxlist?maker_id=<?=$maker->id?>&page_nr="+pageNr, function( data ) {
            $( "#makerImage" ).html( data );
        });
    }
    function reloadMakerProject(pageNr=1) {
        $.get( "/project/ajaxlist?maker_id=<?=$maker->id?>&page_nr="+pageNr, function( data ) {
            $( "#makerProject" ).html( data );
        });
    }
    function reloadMakerMedia(pageNr=1) {
        $.get( "/media/ajaxlist?maker_id=<?=$maker->id?>&page_nr="+pageNr, function( data ) {
            $( "#makerMedia" ).html( data );
        });
    }
    function deleteMakerImage(id) {
         var r = confirm("Are you sure!");
         if (r == true) {
             $.get( "/image/delete?maker_id=<?=$maker->id?>&id="+id, function( data ) {
                 reloadMakerImage();
             });
         }
         return false;
    }
    reloadMakerImage();
    reloadMakerMedia();
    reloadMakerProject();
    $('#projectSave').submit(function(){
        $.post( "/project/ajaxsave",  $( this ).serialize() )
            .done(function( data ) {
                //console.log(data);
                if ('0' == data.substring(0,1)) {
                    $("#openModalDefault").click();
                    $("#modal-default h4").text('Error');
                    $("#modal-default div.modal-body p").html(data.substring(1));
                } else {
                    $('#projectSave').closest('form').find("input[type=text], textarea").val("");
                    reloadMakerProject();
                    //window.location.href = '/maker/view?id=<?=$maker->id?>&tab=project';
                }
            });

        event.preventDefault();
        return false;
    });

    $('#mediaSave').submit(function(){
        $.post( "/media/ajaxsave",  $( this ).serialize() )
            .done(function( data ) {
    //console.log(data);
                if ('0' == data.substring(0,1)) {
                    $("#openModalDefault").click();
                    $("#modal-default h4").text('Error');
                    $("#modal-default div.modal-body p").html(data.substring(1));
                } else {
                    $('#mediaSave').closest('form').find("input[type=text], textarea").val("");
                    reloadMakerMedia();
                    //window.location.href = '/maker/view?id=<?=$maker->id?>&tab=media';
                }
            });

        event.preventDefault();
        return false;
    });
    $('#imageSave').submit(function(){
        event.preventDefault();
        var form = $('#imageSave')[0];
        var data = new FormData(form);
        var theThisForm = this;
        $.ajax({
            type: 'POST',
            enctype: 'multipart/form-data',
            data: data,
            url: "/image/ajaxsave",
            cache: false,
            contentType: false,
            processData: false,
            success: function(data){
                $(".makerImageErr").addClass('hide');
                if ('0' == data.substring(0,1)) {
                    $(".makerImageErr").html(data.substring(1));
                    $(".makerImageErr").removeClass('hide');
                } else {
                    theThisForm.reset();
                    reloadMakerImage();
                    // window.location.href = '/maker/view?id=<?=$maker->id?>&tab=media';
                }
            },
            error: function(e) {
                $("#openModalDefault").click();
                $("#modal-default h4").text('Error');
                $("#modal-default div.modal-body p").html(e.responseText);
            }
        });
        return false;
    });
</script>

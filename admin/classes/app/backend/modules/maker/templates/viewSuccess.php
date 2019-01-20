<style>
    span.red{
        color: #900 !important;
        font-weight:bold;
    }
</style>
<div class="row">
    <div class="col-sm-4">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$maker->name?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa"></i> Address</strong>
              <p class="text-muted">
                <?=$maker->address1?>
                <?=$maker->address2?>
              </p>
              <strong><i class="fa"></i> City</strong>
              <p class="text-muted">
                <?=$maker->city?>
              </p>
              <strong><i class="fa"></i> Postcode</strong>
              <p class="text-muted">
                <?=$maker->postcode?>
              </p>
              <strong><i class="fa"></i> Email</strong>
              <p class="text-muted">
                <?=$maker->email?>
              </p>
              <strong><i class="fa"></i> Telephone</strong>
              <p class="text-muted">
                <?=$maker->telephone?>
              </p>
              <strong><i class="fa"></i> Website</strong>
              <p class="text-muted">
                <?=$maker->website?>
              </p>
              <strong><i class="fa"></i> Social1</strong>
              <p class="text-muted">
                <?=$maker->social1?>
              </p>
              <strong><i class="fa"></i> Social2</strong>
              <p class="text-muted">
                <?=$maker->social2?>
              </p>
            <strong><i class="fa"></i> Social3</strong>
              <p class="text-muted">
                <?=$maker->social3?>
              </p>
            <strong><i class="fa"></i> Min</strong>
              <p class="text-muted">
                <?=$maker->min?>
              </p>
            <strong><i class="fa"></i> Max</strong>
              <p class="text-muted">
                <?=$maker->max?>
              </p>
            <strong><i class="fa margin-r-5"></i> Brief description</strong>
                <p><?=$maker->brief_description?></p>            

            <strong><i class="fa margin-r-5"></i> Regions</strong>
              <p>
                <?php foreach ($maker->regions as $region) :?>
                <span class="label label-primary"><?=$region->name?></span>
                <?php endforeach;?>
              </p>
            <strong><i class="fa margin-r-5"></i> Products</strong>
              <p>
                <?php foreach ($maker->products as $product) :?>
                <span class="label label-primary"><?=$product->name?></span>
                <?php endforeach;?>
              </p>
            <strong><i class="fa margin-r-5"></i> Materials</strong>
              <p>
                <?php foreach ($maker->materials as $material) :?>
                <span class="label label-primary"><?=$material->name?></span>
                <?php endforeach;?>
              </p>
            <strong><i class="fa margin-r-5"></i> Capacities</strong>
              <p>
                <?php foreach ($maker->capacities as $capacity) :?>
                <span class="label label-primary"><?=$capacity->name?></span>
                <?php endforeach;?>
              </p>
            <strong><i class="fa margin-r-5"></i> Services</strong>
              <p>
                <?php foreach ($maker->services as $service) :?>
                <span class="label label-primary"><?=$service->name?></span>
                <?php endforeach;?>
              </p>
            <strong><i class="fa margin-r-5"></i> MakerGroups</strong>
              <p>
                <?php foreach ($maker->makergroups as $maker_group) :?>
                <span class="label label-primary"><?=$maker_group->name?></span>
                <?php endforeach;?>
              </p>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <div class="col-sm-8">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="<?=($tab=='image'  ?'active':'')?>"><a href="#images" data-toggle="tab" aria-expanded="true">Images</a></li>
              <li class="<?=($tab=='project'?'active':'')?>"><a href="#projects" data-toggle="tab" aria-expanded="true">Projects</a></li>
              <li class="<?=($tab=='media'  ?'active':'')?>"><a href="#media" data-toggle="tab" aria-expanded="false">Media</a></li>
              <li class="<?=($tab=='text'   ?'active':'')?>"><a href="#text" data-toggle="tab" aria-expanded="false">Texts</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane<?=($tab=='image' ?' active':'')?>" id="images">
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

        <div>
          <hr>
          <a href="/maker/edit?id=<?=$maker->id?>" class="btn btn-success btn-block">
            <i class="fa fa-pencil"></i>&nbsp;
            <b>EDIT DETAILS</b>
        </a>
        </div>
    </div>
</div>

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
                //window.location.href = '/maker/view?id=<?=$maker->id?>&tab=media';
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
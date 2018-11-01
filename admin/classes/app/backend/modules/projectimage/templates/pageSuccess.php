<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <form class="form-horizontal" action="/projectimage/ajaxsave" id="projectImageSaveAjax"  method="POST" enctype="multipart/form-data">
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
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <input type="hidden" name="project_id" value="<?=$project->id?>">
                    <input type="hidden" name="maker_id" value="<?=$project->maker_id?>">
                    <button type="submit" class="btn btn-primary">Add image</button>
                  </div>
                </div>
            </form>
        </div>
    </div>
    <div class="box-body">
        <div id="projectImagesAjaxList"></div>
    </div>
</div>
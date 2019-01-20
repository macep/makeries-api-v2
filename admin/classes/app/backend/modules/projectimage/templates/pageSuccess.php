<style>
    span.red{
        color: #900 !important;
        font-weight:bold;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <form class="form-horizontal" action="/projectimage/ajaxsave" id="projectImageSaveAjax"  method="POST" enctype="multipart/form-data">
                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Name</label>
                  <div class="col-sm-10">
                    <span class="red hide projImageErrName">Please add a name for this file</span>
                    <input type="text" class="form-control" id="makerImageName" name="name" value="" placeholder="Name">
                  </div>
                </div>
                <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">File</label>
                    <div class="col-sm-10">
                    <span class="red hide projImageErrFile">Please select a file</span>
                    <input type="file" class="form-control" id="makerImageFile" name="upfile">
                    <small>Allowed images are: JPEG, GIF and PNG</small>
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <span class="red hide projImageErr"></span><br>
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
<script>
$('#projectImageSaveAjax').submit(function(){
    event.preventDefault();
    var form = $('#projectImageSaveAjax')[0];
    var data = new FormData(form);
    var theThisForm = this;
    $.ajax({
        type: 'POST',
        enctype: 'multipart/form-data',
        data: data,
        url: "/projectimage/ajaxsave",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
            $(".projImageErr").addClass('hide');
            if ('0' == data.substring(0,1)) {
                $(".projImageErr").html(data.substring(1));
                $(".projImageErr").removeClass('hide');
            } else {
                theThisForm.reset();
                reloadProjectImage(<?=$project->id?>);
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
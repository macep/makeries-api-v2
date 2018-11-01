<div class="row">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Search</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="/servicetype/index">
              <div class="box-body">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" name="name" value="<?=$filter['name']?>" class="form-control" placeholder="servicetype name">
                </div>
              </div>
              <!-- /.box-body -->
    
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Search</button>
              </div>
            </form>
        </div>    
    </div>
    <div class="col-md-9">
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus fa-font-big"></i>
                </button>
                <h3 class="box-title">Add servicetype</h3>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: none;">
                <form method="post" action="/servicetype/save/" id="servicetypeSave" class="form-horizontal">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Service Type</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="newService TypeName" placeholder="new servicetype name">
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" name="submit" value="Add" class="btn btn-primary">
                        </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Service Types</h3>
          </div>
          <div class="box-body">
            <?php $pos = 1;?>
            <table class="table table-hover" width="100%">
                <tr><thead><th style="width:20px;">#</th><th>NAME</th><th style="width:20px;"></th></thead></tr>
                <?php foreach ($servicetypes as $servicetype) :?>
                <tr>
                    <td><?=(($pagination['current']-1)*$pagination['per']+$pos++)?></td>
                    <td><a href='/servicetype/edit/?id=<?=$servicetype->id?>'><?=$servicetype->name?></a></td>
                    <td><a href='/servicetype/delete/?id=<?=$servicetype->id?>' class="fa fa-remove danger"></a></td>
                </tr>
                <?php endforeach;?>
            </table>  
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <?php if (isset($pagination) && $pagination['pages']>1) :?>
            <ul class="pagination">
            <?php
            $link = '/servicetype/index/?';
            ?>
               <?php for ($i=$pagination['start']; $i<=$pagination['end']; $i++) :?>
               <li<?=$i==$pagination['current'] ? ' class="current"':''?>><a href='<?=$link.'&pageNr='.$i.$linkMore?>'><?=$i?></a></li>
               <?php endfor;?>
            </ul>
            <?php endif;?>
          </div>
          <!-- /.box-footer-->
        </div>
    </div>
</div>

<script>
$('#servicetypeSave').submit(function(){
    $.post( "/servicetype/ajaxsave",  $( this ).serialize() )
        .done(function( data ) {
            console.log(data);
            if ('0' == data.substring(0,1)) {
                $("#openModalDefault").click();
                $("#modal-default h4").text('Error');
                $("#modal-default div.modal-body p").html(data.substring(1));
            } else {
                location.reload();
            }
        });
    
    event.preventDefault();
    return false;
});
</script>

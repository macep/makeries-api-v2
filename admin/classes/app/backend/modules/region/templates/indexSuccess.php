<div class="row">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Search</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="/region/index">
              <div class="box-body">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" name="name" value="<?=$filter['name']?>" class="form-control" placeholder="region name">
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
                <h3 class="box-title">Add region</h3>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: none;">
                <form method="post" action="/region/save/" id="regionAdd" class="form-horizontal">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Region</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="newRegionName" placeholder="new region name">
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
            <h3 class="box-title">Regions</h3>
          </div>
          <div class="box-body">
            <?php $pos = 1;?>
            <table class="table table-hover" width="100%">
                <tr><thead><th style="width:20px;">#</th><th>NAME</th><th style="width:20px;"></th></thead></tr>
                <?php foreach ($regions as $region) :?>
                <tr>
                    <td><?=(($pagination['current']-1)*$pagination['per']+$pos++)?></td>
                    <td><a href='/region/edit/?id=<?=$region->id?>'><?=$region->name?></a></td>
                    <td><a href='/region/delete/?id=<?=$region->id?>' class="fa fa-remove danger"></a></td>
                </tr>
                <?php endforeach;?>
            </table>  
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <?php if (isset($pagination) && $pagination['pages']>1) :?>
            <ul class="pagination">
            <?php
            $link = '/region/index/?';
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
$('#regionAdd').submit(function(){
    $.post( "/region/ajaxsave",  $( this ).serialize() )
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

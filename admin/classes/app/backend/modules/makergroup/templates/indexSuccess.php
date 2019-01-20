<div class="row">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Search</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="/makergroup/index">
              <div class="box-body">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" name="name" value="<?=$filter['name']?>" class="form-control" placeholder="makergroup name">
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
               <h3 class="box-title"><a href="/makergroup/edit/">Add maker Group</a></h3>
                <!-- /.box-tools -->
            </div>
        </div>

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Maker Groups</h3>
          </div>
          <div class="box-body">
            <?php $pos = 1;?>
            <table class="table table-hover" width="100%">
                <tr><thead><th style="width:20px;">#</th><th>NAME</th><th style="width:20px;"></th></thead></tr>
                <?php foreach ($makergroups as $makergroup) :?>
                <tr>
                    <td><?=(($pagination['current']-1)*$pagination['per']+$pos++)?></td>
                    <td><a href='/makergroup/edit/?id=<?=$makergroup->id?>'><?=$makergroup->name?></a></td>
                    <td><a href='/makergroup/delete/?id=<?=$makergroup->id?>' class="fa fa-remove danger" onclick="return confirm('Are you sure?');"></a></td>
                </tr>
                <?php endforeach;?>
            </table>  
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <?php if (isset($pagination) && $pagination['pages']>1) :?>
            <ul class="pagination">
            <?php
            $link = '/makergroup/index/?';
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

<div class="row">
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Search</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="/maker/index">
              <div class="box-body">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" name="name" value="<?=$filter['name']?>" class="form-control" placeholder="maker name">
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="text" name="email" value="<?=$filter['email']?>" class="form-control" placeholder="maker email">
                </div>
                <div class="form-group">
                  <label>Phone</label>
                  <input type="text" name="telephone" value="<?=$filter['telephone']?>" class="form-control" placeholder="maker phone">
                </div>
                <div class="form-group">
                  <label>Address</label>
                  <input type="text" name="address1" value="<?=$filter['address1']?>" class="form-control" placeholder="maker address">
                </div>
                <div class="form-group">
                  <label>Postal code</label>
                  <input type="text" name="postcode" value="<?=$filter['postcode']?>" class="form-control" placeholder="maker postal code">
                </div>
                <div class="form-group">
                  <label>City</label>
                  <input type="text" name="city" value="<?=$filter['city']?>" class="form-control" placeholder="maker city">
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
        <?php if (!Logged::isViewOnly()) :?>
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
               <h3 class="box-title"><a href="/maker/edit/">Add maker</a></h3>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="display: none;">
                <form method="post" action="/maker/save/" id="makerSave" class="form-horizontal">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Maker Group</label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="newMaker GroupName" placeholder="new maker name">
                            </div>
                        </div>
                        <div class="box-footer">
                            <input type="submit" name="submit" value="Add" class="btn btn-primary">
                        </div>
                </form>
            </div>
            <!-- /.box-body -->
        </div>
        <?php endif;?>

        <!-- Default box -->
        <div class="box makers-list">
			<div class="box-header with-border">
				<h3 class="box-title">Makers</h3>
			</div>
			<div class="box-body">
			<?php $pos = 1;?>
			<table class="table table-hover" width="100%">
			    <tr><thead><th style="width:20px;">#</th><th>NAME</th><th>WEB</th><th style="width:20px;"></th></thead></tr>
			    <?php foreach ($makers as $maker) :?>
			    <tr class="maker-header">
			        <td><?=(($pagination['current']-1)*$pagination['per']+$pos++)?></td>
			        <th title="Edit <? echo $maker->name ?>"><?=urlGroupRestriction('/maker/edit/?id='.$maker->id, $maker->name)?></th>
			        <td><?= $maker->website?></td>
			        <td title="View <? echo $maker->name ?>">
			            <?=urlGroupRestriction('/maker/view/?id='.$maker->id, '', 'fa fa-eye')?>
			        </td>
			        <td title="Delete <? echo $maker->name ?>">
			            <?=urlGroupRestriction('/maker/delete/?id='.$maker->id, '', 'fa fa-remove', false, true)?>
			        </td>
			    </tr>
			    <tr class="maker-details">
			      <td></td>
			      <td colspan="2">
			        <address>
			          <?=$maker->city?>
			          <div><?=$maker->address1?></div>
			          <div><?=$maker->postcode?></div>
			          <?php if (isset($maker->telephone)) :?>
			            <div>Phone: <?=$maker->telephone?></div>
			          <?php endif;?>
			          <?php if (isset($maker->email)) :?>
			            <div>Email: <?=$maker->email?></div>
			          <?php endif;?>
			        </address>
			      </td>
			      <td></td>
			    </tr>
			    <?php endforeach;?>
			</table>  
			</div>
          	<!-- /.box-body -->
			<div class="box-footer">
				<?php if (isset($pagination) && $pagination['pages']>1) :?>
					<ul class="pagination">
						<?php
						$link = '/maker/index/?';
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

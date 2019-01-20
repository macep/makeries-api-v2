<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <a href="/user/edit"><h3 class="box-title">Add user</h3></a>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-body -->
        </div>

        <!-- Default box -->
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Users</h3>
          </div>
          <div class="box-body">
            <?php $pos = 1;?>
            <table class="table table-hover" width="100%">
                <tr><thead><th style="width:20px;">#</th><th>NAME</th><th>EMAIL</th><th style="width:20px;"></th></thead></tr>
                <?php foreach ($users as $user) :?>
                <tr>
                    <td><?=($pos++)?></td>
                    <td><?=isset($user['name']) ? $user['name']: ''?></td>
                    <td><a href='/user/edit/?id=<?=$user['user_id']?>'><?=$user['email']?></a></td>
                    <td><!--<a href='/user/delete/?id=<?=$user['user_id']?>' class="fa fa-remove danger"></a>--></td>
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

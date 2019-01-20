<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$user['email']?'Update':'Add'?> user</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
         <?php if (isset($user)) :?>
         <form method="post" action="/user/ajaxsave/" id="userSave" class="form-horizontal">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" name="email" class="form-control" value="<?=$user['email']?>" placeholder="email address"<?=$user['email']?' disabled':''?>>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" name="username" class="form-control" value="<?=$user['username']?>" placeholder="user name"<?=$user['email']?' disabled':''?>>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">UserID</label>
                    <div class="col-sm-10">
                        <input type="text" name="user_id" class="form-control" value="<?=$user['userId']?>" placeholder="user id">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Role</label>
                    <div class="col-sm-10">
                        <select name="userRole" class="form-control">
                           <option value="">- Select -</option>
                           <?php foreach($userRoles as $userRole):?>
                           <option value="<?=$userRole?>"<?=$userRole==$user['userRole']?' selected':''?>><?=$userRole?></option>
                           <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Access To Group</label>
                    <div class="col-sm-10">
                        <input type="text" name="accessToGroup" class="form-control" value="<?=$user['accessToGroup']?>" placeholder="none | all | list of IDs 3,4,5">
                    </div>
                </div>
                <?php if (!$user['email']) : ?>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">New password</label>
                    <div class="col-sm-10">
                        <input type="password" name="pass" class="form-control" placeholder="new passowrd">
                    </div>
                </div>
                <?php endif;?>
                <!--
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Repeat new password</label>
                    <div class="col-sm-10">
                        <input type="password" name="pass2" class="form-control" placeholder="new passowrd">
                    </div>
                </div>
                -->

                <div class="box-footer">
                    <input type="hidden" name="id" value="<?=$user['id']?>">
                    <input type="submit" name="submit" value="Save" class="btn btn-primary">
                </div>
         </form>
         <?php else:?>
         <div class="callout callout-danger">
             <h4>Error</h4>
             <p>User ID not found</p>
         </div>
         <?php endif;?>
    </div>
    <!-- /.box-body -->
</div>
<script>
$('#userSave').submit(function(){
    $.post( "/user/ajaxsave",  $( this ).serialize() )
        .done(function( data ) {
//console.log(data);
            if ('0' == data.substring(0,1)) {
                $("#openModalDefault").click();
                $("#modal-default h4").text('Error');
                $("#modal-default div.modal-body p").html(data.substring(1));
            } else {
                window.location.href = '/user/index';
            }
        });
    
    event.preventDefault();
    return false;
});
</script>

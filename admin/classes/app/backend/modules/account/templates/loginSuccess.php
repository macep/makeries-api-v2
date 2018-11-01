<div class="login-box-body col-sm-offset-2 col-sm-4">
  <p class="login-box-msg">Sign in to start your session</p>

  <form action="/account/login" method="post">
    <!--
    <div class="form-group has-feedback">
      <input type="email" class="form-control" name="email" value="<?=$email?>" placeholder="Email">
      <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    </div>
    <div class="form-group has-feedback">
      <input type="password" class="form-control" name="password" placeholder="Password">
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
  -->
    <div class="form-group has-feedback">
      <textarea class="form-control" name="token" placeholder="JWT Token"></textarea>
      <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    </div>
    <div class="row">
      <div class="col-xs-4">
        <?php if (isset($_SESSION['loginError'])) :?>
        <div class="alert alert-warning alert-dismissible">
            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
            <?=$_SESSION['loginError']?>
            <?php unset($_SESSION['loginError'])?>
        </div>
        <?php endif;?>
      </div>
      <!-- /.col -->
      <div class="col-xs-4">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
      </div>
      <!-- /.col -->
    </div>
  </form>
</div>

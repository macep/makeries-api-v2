<div class="login-box-body col-sm-offset-2 col-sm-4">
    <div class="row">
      <div class="col-4">
        <?php if (isset($_SESSION['loginError'])) :?>
        <div class="alert alert-warning alert-dismissible">
            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
            <?=$_SESSION['loginError']?>
            <?php unset($_SESSION['loginError'])?>
        </div>
        <?php endif;?>
      </div>
    </div>

  <p class="login-box-msg">Sign in to start your session</p>

  <form action="/account/login" method="post">
    <div class="row">
      <!-- /.col -->
      <div class="col-sm-offset-4 col-sm-4">
        <a href="/login.php" class="btn btn-primary btn-block btn-flat">Login</a>
      </div>
      <!-- /.col -->
    </div>
  </form>
</div>

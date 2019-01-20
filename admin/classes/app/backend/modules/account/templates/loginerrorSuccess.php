<div class="login-box-body col-sm-offset-2 col-sm-4">
  <p class="login-box-msg">Sign in to start your session Error</p>

  <form action="/account/login" method="post">
    <div class="row">
      <div class="col-xs-4">
        <div class="alert alert-warning alert-dismissible">
            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
            <?=$message?><h2>Test</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <!-- /.col -->
      <div class="col-xs-4">
        <a href="/login.php">LOGIN</a>
      </div>
      <!-- /.col -->
    </div>
  </form>
</div>

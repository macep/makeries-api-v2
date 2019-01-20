<ul class="sidebar-menu" data-widget="tree">
  <li class="header">Meniu</li>
  <li>
    <a href="#">
      <i class="fa fa-list"></i> <span>Collection</span>
    </a>
    <ul class="section-menu" style="display: block;">
      <li><a href="/maker/index"><i class="fa fa-male"></i> <span>Makers</span></a></li>
    </ul>
  </li>
  <!-- <li><a href="/test/index?flux=0"><i class="fa fa-circle-o text-aqua"></i> <span>Test menu</span></a></li> -->
  <?php if ($_SESSION['payload']['userRole'] == 'superAdmin') :?>
    <li>
      <a href="#">
        <i class="fa fa-asterisk"></i> <span>Taxonomies</span>
      </a>
      <ul class="section-menu" style="display: block;">
        <li><a href="/makergroup/index"><i class="fa fa-object-group"></i> Maker Group</a></li>
        <li><a href="/material/index"><i class="fa fa-briefcase"></i> Material</a></li>
        <li><a href="/service/index"><i class="fa fa-circle-o"></i> Service</a></li>
        <li><a href="/region/index"><i class="fa fa-location-arrow"></i> Region</a></li>
        <li><a href="/product/index"><i class="fa fa-cube"></i> Product</a></li>
      </ul>
    </li>
  <?php endif;?>
  <?php if ($_SESSION['payload']['userRole'] == 'superAdmin') :?>
    <li>
      <a href="#">
        <i class="fa fa-superpowers"></i> <span>Admins</span>
      </a>
      <ul class="section-menu" style="display: block;">
        <li><a href="/user/index"><i class="fa fa-user"></i> Users</a></li>
      </ul>
    </li>
  <?php endif;?>
</ul>


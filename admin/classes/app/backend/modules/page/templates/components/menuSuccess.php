<ul class="sidebar-menu" data-widget="tree">
  <li class="header">Meniu</li>
  <li class="treeview menu-open">
    <a href="#">
      <i class="fa fa-search"></i> <span>Search</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu" style="display: block;">
      <li><a href="/maker/index"><i class="fa fa-male"></i> <span>Maker</span></a></li>
    </ul>
  </li>
  <!-- <li><a href="/test/index?flux=0"><i class="fa fa-circle-o text-aqua"></i> <span>Test menu</span></a></li> -->
<?php if ($_SESSION['payload']['userRole'] == 'superAdmin') :?>
  <li class="treeview menu-open">
    <a href="#">
      <i class="fa fa-gears"></i> <span>Config</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu" style="display: block;">
      <li><a href="/makergroup/index"><i class="fa fa-circle-o"></i> Maker Group</a></li>
      <li><a href="/businesstype/index"><i class="fa fa-circle-o"></i> Business Type</a></li>
      <li><a href="/servicetype/index"><i class="fa fa-circle-o"></i> Service Type</a></li>
      <li><a href="/region/index"><i class="fa fa-circle-o"></i> Region</a></li>
      <li><a href="/product/index"><i class="fa fa-circle-o"></i> Product</a></li>
    </ul>
  </li>
</ul>
<?php endif;?>

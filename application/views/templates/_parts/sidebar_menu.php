<?php
  $menus = array(
    array(
      'menuId' => "home",
      'menuName' => "Beranda",
      'menuPath' => site_url("admin/"),
      'menuIcon' => "ni ni-tv-2 text-primary",
      'menuChild' => array()
    )
  );

  $dashboard = array(
    'menuId' => "admin",
    'menuName' => "User Management",
    'menuPath' => site_url("admin/user_management"),
    'menuIcon' => 'fa fa-times text-orange',
    'menuChild' => array()
  );

  $user_management = array(
    'menuId' => "admin",
    'menuName' => "User Management",
    'menuPath' => site_url("admin/user_management"),
    'menuIcon' => 'fa fa-times text-orange',
    'menuChild' => array()
  );
  $category = array(
    'menuId' => "category",
    'menuName' => "Kategori",
    'menuPath' => site_url("category"),
    'menuIcon' => 'fa fa-times'
  );

  if( $this->user_auth->is_admin() ){
    array_push($menus, $user_management) ;
  }else{
    $menus[0]['menuPath'] = site_url("user");
  }

?>
<ul class="navbar-nav"> 
  <?php
    foreach($menus as $menu):
  ?>
    <li class="nav-item" id="<?php echo $menu['menuId'] ?>" >
      <a class="nav-link" href="<?php echo $menu['menuPath'] ?>">
        <i class="<?php echo $menu['menuIcon'] ?>"></i> <?php echo $menu['menuName'] ?>
      </a>
    </li>
  <?php
      endforeach;
  ?>
</ul>
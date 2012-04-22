<?php
function render_menu($menu_item) {
  if ( ! isset($_SESSION['user'])) {
    @header('Location: login.php');
  }
  $user = $_SESSION['user'];
  $_SESSION['focus'] = $menu_item;
  echo('
<div id="menu">
');
  if ($user['role'] == 'admin') {
    admin_menu();
  } else {
    engineer_menu();
  }
  echo(logout_menu().'
</div>

<script type="text/javascript">
$(function() {
  select_in_menu("' . $menu_item . '");
});
</script>
');
}

function logout_menu() {
echo('
  <span id="logout" class="menuitem logout">
      <a href="logout.php" title="Logout.">('.$_SESSION['user']['name'].') Logout</a>
  </span>
');
}

function engineer_menu() {
  echo('
  <span id="focus" class="menuitem">
      <a href="focus.php" title="Current list of defects/issues/concerns/complaints/rants/raves.">Focus</a>
  </span>
  <span id="component" class="menuitem">
      <a href="component.php" title="Manage component list.">Component</a>
  </span>
  <span id="primetrack" class="menuitem">
      <a href="primetrack.php" title="Manage primary track list.">Primary Track</a>
  </span>
');
}
function admin_menu() {
  echo('
  <span id="focus" class="menuitem">
      <a href="focus.php" title="Current list of defects, feature requests, etc.">Focus</a>
  </span>
  <span id="category" class="menuitem">
      <a href="category.php" title="Manage category list.">Category</a>
  </span>
  <span id="severity" class="menuitem" >
      <a href="severity.php" title="Manage severity list.">Severity</a>
  </span>
  <span id="status" class="menuitem" >
      <a href="status.php"
         title="Manage status list.">Status</a>
  </span>
  <span id="resolution" class="menuitem">
      <a href="resolution.php" title="Manage resolution list.">Resolution</a>
  </span>
  <span id="primetrack" class="menuitem">
      <a href="primetrack.php" title="Manage primary track list.">Primary Track</a>
  </span>
  <span id="component" class="menuitem">
      <a href="component.php" title="Manage component list.">Component</a>
  </span>
  <span id="user" class="menuitem">
      <a href="user.php" title="Manage list of this program\'s user list."> User </a>
  </span>
  <span id="usertrack" class="menuitem">
      <a href="usertrack.php" title="Manage mapping of of this program\'s users to primary tracks.">User/Track</a>
  </span>
');
}
?>
<script type="text/javascript">
$(function() {
  $('#logout').click(function() {
      if (confirm('Are you sure you wish to log out ?')) {
        document.location.replace('logout.php');
        return true;
      }
      return false;
    });
});
</script>

<?php
include_once('head.inc');
include_once('utils.inc');

function play() {
  $link = connect();
  render_menu('focus');
  disconnect($link);
}

play();
?>

<script type="text/javascript">
$(function() {
  select_in_menu('focus');
});
</script>

<?php
include_once('foot.inc');
?>
<pre><?php
if (isset($_GET['name'])) {
  $file = str_replace("'", "", escapeshellarg( $_GET['name'] )) . ".php";
  if (!strpos($_GET['name'],'..') !== false && !strpos($_GET['name'],'.php') !== false) {
    highlight_string(file_get_contents($file));
  } else {
    if (strpos($_GET['name'],'.php') !== false) {
      die('Nope. Try removing .php');
    } else {
      die('Nope.');
    }
  }
} else { ?>
<form>
<input type='text' name='name'>
</form> <?php }
?>
</pre>

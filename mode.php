<?php
$cur_dir = explode('/', getcwd());
$_POST['mode'] = strtoupper($cur_dir[count($cur_dir)-1]);
include "../index.php";

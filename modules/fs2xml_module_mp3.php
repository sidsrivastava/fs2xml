<?php
  $id = 'mp3';
  $node_name = 'mp3';
  $attributes = array ('id' => 'FILE_PATH', 'name' => 'FILE_NAME');

  $module = new fs2xml_module ($id, $node_name, $attributes);
  return ($module);
?>
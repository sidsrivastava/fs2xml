<?php
  $id = 'file';
  $node_name = 'file';
  $attributes = array ('id' => 'FILE_PATH', 'name' => 'FILE_NAME');

  $module = new fs2xml_module ($id, $node_name, $attributes);
  return ($module);
?>
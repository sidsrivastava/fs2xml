<?php
  $id = 'folder';
  $node_name = 'folder';
  $attributes = array ('id' => 'FILE_PATH', 'name' => 'FOLDER_NAME');

  $module = new fs2xml_module ($id, $node_name, $attributes);
  return ($module);
?>
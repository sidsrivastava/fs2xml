<?php
/*
  Copyright (C) 2006 Sid Srivastava 
 
  Permission is hereby granted, free of charge, to any person obtaining a
  copy of this software and associated documentation files (the
  "Software"), to deal in the Software without restriction, including
  without limitation the rights to use, copy, modify, merge, publish,
  distribute, sublicense, and/or sell copies of the Software, and to
  permit persons to whom the Software is furnished to do so, subject to
  the following conditions:
 
  The above copyright notice and this permission notice shall be included
  in all copies or substantial portions of the Software.
 
  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
  OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
  MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
  IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY
  CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
  TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
  SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/
?>
<?php
class fs2xml_module
{
  var $id;
  var $node_name;
  var $attributes;

  function fs2xml_module($id, $node_name, $attributes)
  {
    $this->id = $id;
    $this->node_name = $node_name;
    $this->attributes = $attributes;
  } 

  function get_array()
  {
    $module = array ();
    $module['id'] = $this->id;
    $module['node_name'] = $this->node_name;
    $module['attributes'] = $this->attributes;

    return ($module);
  }
}

function get_modules($dir_path = '') 
{
  $modules = array ();

  /* If the path isn't specified, look in the "modules" folder, under the same directory as the library */
  if ($dir_path === '') 
    $dir_path = dirname (__FILE__) ;

  /* Load all currently installed modules into an array */
  if ($dir = @opendir ($dir_path)) 
  {
    while (($file = readdir ($dir)) !== false) 
    {
      if ($file != "CVS" && $file != "." && $file != ".." && is_file ($dir_path . '/' . $file) && strtolower (substr ($file, -4)) == '.php') 
      {
        $module = include_once ($dir_path.'/'.$file);
        if (is_object ($module))
          $modules[] = $module;
      }
    }
    closedir ($dir);
  }
  return ($modules);
}

function find_module_by_id($id, $modules = '') 
{
  /* Load up the modules if they aren't provided */
  if ($modules == '') $modules = get_modules ();

  foreach ($modules as $module) 
  {
    if ($module->id == $id)
      return ($module);
  }

  return (false);
}


function process_module_element($module_element, $path)
{
  $processed_element = $module_element;

  switch ($module_element)
  {
    case 'FILE_PATH': $processed_element = $path; break;
    case 'FILE_NAME': $processed_element = fs2xml_utilities::get_name_from_path($path); break;
    case 'FOLDER_PATH': $processed_element = $path; break;
    case 'FOLDER_NAME': $processed_element = fs2xml_utilities::get_name_from_path($path); break;
  }
  return $processed_element;
}

function process_module_array($module_array, $path)
{
  $processed_array = $module_array;
  foreach ($processed_array as $key => $value)
  {
    $processed_array[$key] = process_module_element($value, $path);
  }
  return $processed_array;
}
?>

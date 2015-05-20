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
class fs2xml
{
  var $xml_doc;

  function fs2xml($folder_path, $config = '')
  {
    if ($config['use_absolute_paths'])
      $folder_path = realpath($folder_path);

    $this->xml_doc = new DomDocument();
    $doc_element = $this->xml_doc->createElement("folder");
    $doc_element->setAttribute('id', $folder_path);
    $working_name = fs2xml_utilities::get_name_from_path($folder_path);
    $doc_element->setAttribute("name", $working_name);

    $this->xml_doc->appendChild($doc_element);
    $modules = get_modules($config['modules_path']);
    fs2xml::traverse($folder_path, $this->xml_doc->documentElement, $modules);
  }

  function traverse($base_folder_path, &$parent_node, &$modules)
  {
    $subfolders = fs2xml_utilities::get_subfolders($base_folder_path);
    $subfiles = fs2xml_utilities::get_subfiles($base_folder_path);

    /* Recurse through all the subfolders */
    foreach ($subfolders as $key => $folder)
    {
      if ($folder != NULL)
      {
        $module = find_module_by_id("folder", $modules);
        $new_node =  fs2xml::create_folder_node($folder, $module);
        $new_parent_node = $parent_node -> appendChild($new_node);
        fs2xml::traverse($folder, $new_parent_node, $modules);
      }
    }

    foreach ($subfiles as $key => $file)
    {
      if ($file != NULL)
      {
        $module = find_module_by_id(fs2xml_utilities::get_file_extension($file), $modules);
        /* If no module exists for the given file type, try to find a module for a generic file */
        if (!$module)
          $module = find_module_by_id("file", $modules);

        $new_node =  fs2xml::create_file_node($file, $module);
        $new_parent_node = $parent_node -> appendChild($new_node);
        fs2xml::traverse($file, $new_parent_node, $modules);
      }
    }
  }

   function create_folder_node($folder_path, $module)
   {
     /* Default parameters for a folder node */
     $node_name = "folder";
     $attributes =  array("id" => $folder_path, "name" => fs2xml_utilities::get_name_from_path($folder_path));

     if ($module)
     {
       $node_name = process_module_element($module->node_name, $folder_path);
       $attributes = process_module_array($module->attributes, $folder_path);
     }

     $new_node = $this->xml_doc->createElement($node_name);
     foreach ($attributes as $attribute_name => $attribute_value)
       $new_node -> setAttribute($attribute_name, $attribute_value);

     return $new_node;
   }

   function create_file_node($file_path, $module)
   {
     /* Default parameters for a folder node */
     $node_name = "file";
     $attributes =  array("id" => $file_path, "name" => fs2xml_utilities::get_name_from_path($file_path));

     if ($module)
     {
       $node_name = process_module_element($module->node_name, $file_path);
       $attributes = process_module_array($module->attributes, $file_path);
     }

     $new_node = $this->xml_doc->createElement($node_name);
     foreach ($attributes as $attribute_name => $attribute_value)
       $new_node -> setAttribute($attribute_name, $attribute_value);

     return $new_node;
   }

   function get_xml_doc()
   {
     return $this->xml_doc;
   }
}

function fs2xml($folder_path)
{    
  $xml_doc = domxml_new_doc("1.0");
  $doc_element = $xml_doc -> createElement("folder");
  $doc_element -> set_attribute("id", $folder_path);
    
  $working_name =  fs2xml_utilities::get_name_from_path($folder_path);
  $doc_element -> setAttribute("name", $working_name);

  $xml_doc -> appendChild($doc_element);
  fs2xml_xml::traversal($folder_path, $xml_doc, $xml_doc -> documentElement);
  return $xml_doc;
}
?>

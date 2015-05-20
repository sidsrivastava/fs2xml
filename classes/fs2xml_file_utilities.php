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
class fs2xml_file_utilities
{

  function get_subfolders($folder_path)
  {
    $folders = array();
    /* Open parent folder */
    if ($handle = @opendir($folder_path)) {
      /* Loop through all the files */
      while ($file = readdir($handle)) {
        /* Ignore hidden files */
        if (!preg_match("/^\./", $file)) {
           if (@is_dir("$folder_path/$file"))
             $folders[] = "$folder_path/$file";
        }
      }
      /* Close directory */
      closedir($handle);
    }
    sort($folders);
    return $folders;
  }

  function get_subfiles($folder_path)
  {
    $files = array();
    /* Open current directory */
    if ($handle = @opendir($folder_path)) {
      /* Loop through all the files */
      while ($file = readdir($handle))
      {
        /* Ignore hidden files */
        if (!preg_match("/^\./", $file))
        {
          if (!@is_dir("$folder_path/$file"))
            $files[] = "$folder_path/$file";
        }
      }
      /* Close directory */
      closedir($handle);
    }
    sort($files);
    return $files;
  }

  function get_name_from_path($path)
  {
    $broken_fragments = explode("/", $path);
    return $broken_fragments[count($broken_fragments)- 1];
  }
  
  function get_file_extension($file_path)
  {
    /* TODO: deal with file permissions errors */
    if (!@is_file($file_path))
      return NULL;
    return substr($file_path, -3);
  }

  function truncate_file_extension($file_path)
  {
    /* TODO: deal with file permissions errors */
    if (!@is_file($file_path))
      return $file_path;
    /* 3 characters for file extension + 1 character for the period */
    return substr($file_path, 0, strlen($file_path) - 4);
  }
}
?>

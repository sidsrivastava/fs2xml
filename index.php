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
  require_once("classes/fs2xml.php");
  require_once("classes/fs2xml_module.php");
  require_once("classes/fs2xml_utilities.php");
?>
<?php
  /* Configuration variables */

  /* Path to the modules folder. */
  $config['modules_path'] = 'modules';

  /* Whether to display canonicalized absolute paths. */
  $config['use_absolute_paths'] = true;
?>
<?php
  if (isset($HTTP_POST_VARS['submit']))
  {
    $base_folder_path = $HTTP_POST_VARS['base_folder_path'];
    $xml = new fs2xml($base_folder_path, $config);
    $xml_doc = $xml->get_xml_doc();
    header ("content-type: text/xml");
    echo $xml_doc->saveXML();
    exit();
  }
?>
<html>
<head><title>fs2xml</title></head>
<body>
<h1>fs2xml</h1>
<form method="post">
<table>
<tr><td>Base folder:</td><td><input type="text" name="base_folder_path" value="test" /></td></tr>
</table>
<p>
<input type="submit" name="submit" value="Generate XML" />
</p>
</form>
</body>
</html>

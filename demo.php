<?php

/*
 * demo.php
 * 
 * Copyright (c) 2013 Sofiane Oumaouche <oumsof@gmail.com>. 
 * 
 * This file is part of Expression program is undefined on line 8, column 40 in Templates/Licenses/license-gplv3.txt..
 * 
 * Expression program is undefined on line 10, column 19 in Templates/Licenses/license-gplv3.txt. is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Expression program is undefined on line 15, column 19 in Templates/Licenses/license-gplv3.txt. is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with JqplotPHPWrapper.  If not, see <http ://www.gnu.org/licenses/>.
 */

require_once('ClassLoader-master/UniversalClassLoader.php');

use Symfony\Component\ClassLoader\UniversalClassLoader;
$loader = new UniversalClassLoader();

$loader->registerNamespaces(array(
    'Jqplot' => __DIR__,
));
$loader->register();

$jqplot = new Jqplot\Core\Jqplot();

$jqplot->stackSeries = true;
$jqplot->showMarker = false;
$jqplot->seriesDefaults->fill = true;
$jqplot->axes->xaxis->renderer = new Jqplot\Core\JqplotExpression('$.jqplot.CategoryAxisRenderer');
$jqplot->axes->xaxis->ticks = array("Mon", "Tue", "Wed", "Thr", "Fri");

// add plugins
$jqplot->addScript('Jqplot/dist/plugins/jqplot.categoryAxisRenderer.min.js');
$jqplot->addScript('Jqplot/dist/plugins/jqplot.highlighter.min.js');
$jqplot->addScript('Jqplot/dist/plugins/jqplot.canvasTextRenderer.min.js');
$jqplot->addScript('Jqplot/dist/plugins/jqplot.canvasAxisTickRenderer.min.js');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Area </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <link class="include" rel="stylesheet" type="text/css" href="Jqplot/dist/jquery.jqplot.min.css" />
    <?php
      foreach ($jqplot->getScripts() as $script) {
         echo '<script type="text/javascript" src="' . $script . '"></script>' . "\n";
      }
    ?>
    
    
  </head>
  <body>
    <div id="container"></div>
    <script type="text/javascript">
    <?php
      echo $jqplot->render("container", array(array(11, 9, 5, 12, 14), array(4, 8, 5, 3, 6), array(12, 6, 13, 11, 2)));
    ?>
    </script>
    

  </body>
</html>
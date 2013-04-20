<?php

/*
 * Jqplot.php
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

/**
 * Description of jqplot
 *
 * @author Sofiane Oumaouche <oumsof@gmail.com>
 */
namespace Jqplot\Core ;

class Jqplot implements \ArrayAccess {

    /**
     * JQplot scripts
     * @var type array
     */
    private $scripts = array();
    
    
    /**
     * data to be represented by the chart 
     * 
     * @var type array
     */
    private $_data = array();

    /**
     * JQplot options
     * 
     * @var type array
     */
    private $_options = array();
    
    /**
     * JQplot constructor
     */
    public function __construct( $options = null, $confPath = 'conf.php')
    {
        include_once $confPath;
 
        foreach($jsFiles as $jsFile)
        {
            $this->scripts[] = $jsFile['path'] . $jsFile['name'];
        }
        
        $this->_options = $options;  
    }
    
    /**
     * Render the JQplot chart options and returns the javascript that
     * represents them
     *
     * @return string The javascript code
     */
    public function renderOptions()
    {
        $jsExpressions = array();
        //Replace any js expression with random strings so we can switch
        //them back after json_encode the options
        $options = self::_replaceJsExpr($this->_options, $jsExpressions);

        //TODO: Check for encoding errors
        $result = json_encode($options);

        //Replace any js expression on the json_encoded string
        foreach ($jsExpressions as $key => $expr) 
        {
            $result = str_replace('"' . $key . '"', $expr, $result);
        }
        return $result;
    }

    /**
     * Render the chart and returns the javascript that
     * must be printed to the page to create the chart
     *
     * @param string $varName The javascript chart variable name
     * @param string $callback The function callback to pass
     *                         to the JQplot.Chart method
     *
     * @return string The javascript code
     */
    public function render($renderTo,  array $data, $varName = null)
    {
        $result = '';
        
        if (!is_null($varName)) {
            $result = "$varName = ";
        }

        $result .= '$.jqplot("' . $renderTo . '", ';
        $result .= json_encode($data) . ', ';

        $result .= $this->renderOptions();
        $result .= ');';
        return $result;
    }

    public function __set($offset, $value)
    {
        $this->offsetSet($offset, $value); 
    }

    public function __get($offset)
    {
        return $this->offsetGet($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->_options[$offset] = new JqplotOption($value);
    }

    public function offsetExists($offset)
    {
        return isset($this->_options[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->_options[$offset]);
    }

    public function offsetGet($offset)
    {
        if (!isset($this->_options[$offset])) {
            $this->_options[$offset] = new JqplotOption();
        }
        return $this->_options[$offset];
    }
    
    /**
     * Finds the javascript files that need to be included on the page
     * Uses the conf.php file to build the files path
     *
     * @return array The javascript files path
     */
    public function addScript($script)
    {
        $this->scripts[] = $script;

        return $this->scripts;
    }
    
    
    public function getScripts()
    {
        return $this->scripts;
    }
    
    /**
     * Recursively generate multidimentional array of JqplotOptions
     *
     * @param mixed $data           The data to analyze
     * @param array &$jsExpressions The array that will hold
     *                              information about the replaced
     *                              js expressions
     */
    private static function _replaceJsExpr($data, &$jsExpressions)
    {
        if (!is_array($data) &&
            !is_object($data)) {
            return $data;
        }

        if (is_object($data) &&
            ! ($data instanceof JqplotExpression)) {
          
            $data = $data->getValue();
        }

        if ($data instanceof JqplotExpression) {
            $magicKey = "____" . count($jsExpressions) . "_" . count($jsExpressions);
            $jsExpressions[$magicKey] = $data->getExpression();
            return $magicKey;
        }
        
        if(!empty($data) && is_array($data))
        {
            foreach ($data as $key => $value) {
                $data[$key] = self::_replaceJsExpr($value, $jsExpressions);
            }
        }

        return $data;
    }
}





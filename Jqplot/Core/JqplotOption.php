<?php

/*
 * JqplotOption.php
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
 * Description of JqplotOption
 *
 * @author Sofiane Oumaouche <oumsof@gmail.com>
 */
namespace Jqplot\Core ;

class JqplotOption implements \ArrayAccess{
    /**
     * An array of JqplotOption
     *
     * @var array
     */
    private $children = array();

    /**
     * The option value
     *
     * @var mixed
     */
    private $value;
    
    /**
     * The JqplotOption constructor
     *
     * @param mixed $value The option value
     */
    public function __construct($value = null)
    {
        if (is_string($value)) {
            //Avoid json-encode errors latter on
            $this->value = iconv(
                mb_detect_encoding($value),
                "UTF-8//IGNORE",
                $value
            );
        } elseif (is_array($value)) {
            foreach($value as $key => $val) {
                $this->offsetSet($key, $val);
            }
        } else {
            $this->value = $value;
        }
         
    }
    
    /**
     * Returns the value of the current option
     *
     * @return mixed The option value
     */
    public function getValue()
    {
        if (isset($this->value)) {
            //This is a final option
            return $this->value;
        } elseif (!empty($this->children)) {
            //The option value is an array
            $result = array();
            
            foreach ($this->children as $key => $value) {
                
                $result[$key] = $value->getValue();
            }

            return $result;
        }
        return null;
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
        if (is_null($offset)) { 
            $this->children[] = new self($value);
        } else {
            $this->children[$offset] = new self($value);
        }
        //If the option has at least one child, then it won't
        //have a final value
         
        unset($this->value);
    }
    
    public function offsetExists($offset)
    {
        return isset($this->children[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->children[$offset]);
    }

    public function offsetGet($offset)
    {
        //Unset the value, because we will always
        //have at least one child at the end of
        //this method
        unset($this->value);
        if (is_null($offset)) {
            $this->children[] = new self();
            return end($this->children);
        }
        if (!isset($this->children[$offset])) {
            $this->children[$offset] = new self();
        }
        return $this->children[$offset];
    }

}
<?php

/*
 * JqplotExpression.php
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
 * Description of JqplotExpression this is used to handle javascript expressions
 *
 * @author Sofiane Oumaouche <oumsof@gmail.com>
 */

namespace Jqplot\Core;

class JqplotExpression {
    /**
     * The javascript expression
     *
     * @var string
     */
    private $_expression;

    /**
     * The JqplotExpression constructor
     *
     * @param string $expression The javascript expression
     */
    public function __construct($expression)
    {
        $this->_expression = iconv(
            mb_detect_encoding($expression),
            "UTF-8",
            $expression
        );
    }

    /**
     * Returns the javascript expression
     *
     * @return string The javascript expression
     */
    public function getExpression()
    {
        return $this->_expression;
    }
}

?>

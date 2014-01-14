<?php
/**
 * @package       common-bundle
 * @author        Aaron Scherer
 * @copyright (c) 2013 Underground Elephant
 *
 * Copyright 2013 Underground Elephant
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Uecode\Bundle\CommonBundle\Extension;

use Twig_Extension;
use Twig_SimpleFunction;

/**
 * InspectExtension Class
 */
class InspectExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('inspect', [$this, 'inspect']),
            new Twig_SimpleFunction('var_dump', [$this, 'var_dump']),
        ];
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'inspect';
    }

    public function inspect($variable, $depth = 5, $die = false, $dumpOut = false)
    {
        if (is_object($variable)) {
            $variable = [
                'methods'  => get_class_methods($variable),
                'variable' => $variable
            ];
        }

        return \Uecode::dump($variable, $depth, $die, $dumpOut);
    }

    public function var_dump($variable)
    {
        var_dump($variable);

        return;
    }
}

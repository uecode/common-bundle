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

use Symfony\Component\HttpKernel\KernelInterface;

/**
 * FileExtension Class
 */
class FileExtension extends \Twig_Extension
{

    /**
     * @var KernelInterface
     */
    protected $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function getFunctions()
    {
        $functions = [
            new Twig_SimpleFunction('file_include', [$this, 'file'], ['is_safe' => ['html']]),
            new Twig_SimpleFunction('file_exists', [$this, 'fileExists'])
        ];

        return $functions;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'file';
    }

    /**
     * Checks to see if the given file exists
     *
     * @param $path A logical path to the file ( e.g '@AcmeFooBundle:Foo:resource.txt' ).
     *
     * @return bool Whether or not the file exists
     */
    public function fileExists($path)
    {
        $path = $this->kernel->locateResource($path, null, true);

        return file_exists($path);
    }

    /**
     * Returns the contents of a file to the template.
     *
     * @param string $path A logical path to the file (e.g '@AcmeFooBundle:Foo:resource.txt').
     *
     * @return string         The contents of a file.
     */
    public function file($path)
    {
        $path = $this->kernel->locateResource($path, null, true);

        return file_get_contents($path);
    }
}

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

namespace Uecode\Bundle\CommonBundle;

/**
 * Contains all the events thrown in the UecodeCommonBundle
 */
final class UecodeCommonEvents
{
    /**
     * The PRE_CONTROLLER_INITIALIZE event occurs before `initialize()` is called on the controllers.
     *
     * This can be used to call certain functions on the controller before initialize is fired.
     */
    const PRE_CONTROLLER_INITIALIZE = 'uecode_common.controller.initialize.pre';

    /**
     * The POST_CONTROLLER_INITIALIZE event occurs after `initialize()` is called on the controllers.
     *
     * This can be used to call certain functions on the controller after initialize is fired.
     */
    const POST_CONTROLLER_INITIALIZE = 'uecode_common.controller.initialize.post';

    /**
     * The RENDER_TEMPLATE_RESPONSE event occurs after the template engine has rendered the template, but before its returned.
     *
     * This can be used to alter the response before it is sent
     */
    const RENDER_TEMPLATE_RESPONSE = 'uecode_common.response.render_template';
}

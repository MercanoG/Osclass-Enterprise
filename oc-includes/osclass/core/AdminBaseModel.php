<?php if ( ! defined('ABS_PATH')) exit('ABS_PATH is not loaded. Direct access is not allowed.');

/*
 * Copyright 2022 Osclass Enterprise
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

    class AdminBaseModel extends BaseModel
    {
        function __construct()
        {
            parent::__construct();
            // @deprecated: to be removed
            osc_run_hook( 'init_admin' );
            osc_run_hook( 'init_admin_insecure' );
        }

        function doModel() {}
        function doView($file) {}
    }

    /* file end: ./oc-includes/osclass/core/AdminBaseModel.php */

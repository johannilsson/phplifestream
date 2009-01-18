<?php
/**
 * Common
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.
 *
 * @category   Common
 * @package    Common_Db_Table
 * @copyright  Copyright (c) 2008 Johan Nilsson. (http://www.markupartist.com)
 * @license    New BSD License
 */

require_once 'Zend/Db/Table/Rowset.php';

class Common_Db_Table_Rowset extends Zend_Db_Table_Rowset
{
    protected $_rowClass = 'Common_Db_Table_Row';
}

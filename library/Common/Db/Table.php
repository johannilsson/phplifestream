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
 * @package    Table_Db
 * @copyright  Copyright (c) 2008 Johan Nilsson. (http://www.markupartist.com)
 * @license    New BSD License
 */

require_once 'Zend/Db/Table/Abstract.php';

class Common_Db_Table extends Zend_Db_Table_Abstract
{
    protected $_rowClass = 'Common_Db_Table_Row';
    protected $_rowsetClass = 'Common_Db_Table_Rowset';

    public function getCols()
    {
        return $this->_cols;
    }

   /**
     * Called by parent table's class during delete() method.
     *
     * @param  string $parentTableClassname
     * @param  array  $primaryKey
     * @return int    Number of affected rows
     */
    public function _cascadeDelete($parentTableClassname, array $primaryKey)
    {
        $this->_setupMetadata();
        $rowsAffected = 0;
        foreach ($this->_getReferenceMapNormalized() as $map) {
            if ($map[self::REF_TABLE_CLASS] == $parentTableClassname && isset($map[self::ON_DELETE])) {
                switch ($map[self::ON_DELETE]) {
                    case self::CASCADE:
                        $where = array();
                        for ($i = 0; $i < count($map[self::COLUMNS]); ++$i) {
                            $col = $this->_db->foldCase($map[self::COLUMNS][$i]);
                            $refCol = $this->_db->foldCase($map[self::REF_COLUMNS][$i]);
                            $type = $this->_metadata[$col]['DATA_TYPE'];
                            $where[] = $this->_db->quoteInto(
                                $this->_db->quoteIdentifier($col, true) . ' = ?',
                                $primaryKey[$refCol], $type);
                        }
                        // To support more than one cascade.
                        // See http://framework.zend.com/issues/browse/ZF-1103
                        //$rowsAffected += $this->delete($where);
                        $toDelete = $this->fetchAll($where);
                        foreach($toDelete as $row) {
                            $rowsAffected += $row->delete();
                        }
                        break;
                    default:
                        // no action
                        break;
                }
            }
        }
        return $rowsAffected;
    }
}


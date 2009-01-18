<?php

/**
 * Tag Model
 *
 */
class Tags extends Common_Db_Table
{
    /**
     * Table name
     *
     * @var string
     */
    protected $_name = 'tags';

    protected $_dependentTables = array('TaggedStreams');

    /**
     * Primary key
     *
     * @var string
     */
    protected $_primary = 'id';

    public function insert(array $data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        return parent::insert($data);
    }

    public function update(array $data, $where)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        return parent::update($data, $where);
    }

    /**
     * Find by name
     *
     * @param string $name
     * @return unknown
     */
    public function findByName($name)
    {
        $where = $this->getAdapter()->quoteInto('name = ?', $name);
        return $this->fetchRow($where);
    }

    /**
     * Create tags from supplied array of tag names, if tag already exists it 
     * will just add it to the returned arrays.
     *
     * @param array $tagNames
     * @return array
     */
    public function createTags(array $tagNames)
    {
        $tags = array();
        foreach ($tagNames as $tagName) {
            if ($tagName != '') {
                $tag = $this->findByName($tagName);
                if (!$tag instanceof App_Db_Table_Row) {
                    $tag = $this->createRow();
                    $tag->name = trim($tagName);
                    $tag->save();
                }
                $tags[] = $tag;
            }
        }
        return $tags;
    }
}

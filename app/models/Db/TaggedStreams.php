<?php
require_once 'Streams.php';
require_once 'Tags.php';

/**
 * Tagged Streams
 *
 */
class TaggedStreams extends Common_Db_Table
{
    protected $_name = 'tagged_streams';

    protected $_referenceMap    = array(
        'Tag' => array(
            'columns'           => array('tag_id'),
            'refTableClass'     => 'Tags',
            'refColumns'        => array('id'), 
            'onDelete'          => self::CASCADE,
        ),
        'Stream' => array(
            'columns'           => array('stream_id'),
            'refTableClass'     => 'Streams',
            'refColumns'        => array('id'),
            'onDelete'          => self::CASCADE,
        ),
    );

    public function deleteByStreamId($id)
    {
        $where  = $this->getAdapter()->quoteInto('stream_id = ?', (int) $id);
        $resultSet = $this->fetchAll($where);

        foreach ($resultSet as $relation) {
            $relation->delete();
        }
    }

    public function addTagsToStream(array $tagNames, $stream)
    {
        if ($stream instanceof Zend_Db_Table_Row) {
            $streamId = $stream->id;
        }
        $streamId = $stream;

        // Remove all references        
        $this->deleteByStreamId($streamId);

        $tags = array();
        $tagTabel = new Tags();
        if (!empty($tagNames)) {
            $tags = $tagTabel->createTags($tagNames);
            foreach ($tags as $tagRow) {
                try {
                    $taggedRow = $this->createRow(array(
                        'tag_id'    => $tagRow->id, 
                        'stream_id' => $streamId));
                    $taggedRow->save();
                } catch (Exception $e) {
                    ;
                }
            }
        }
        return $tags;
    }
}

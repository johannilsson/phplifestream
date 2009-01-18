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

    public function addStreamToTags($stream, array $tagNames)
    {
        if ($stream instanceof Zend_Db_Table_Row) {
            $streamId = $stream->id;
        }
        $streamId = $stream;

        // Remove all references        
        $this->deleteByStreamId($streamId);

        $tags = new Tags();

        $sanitizeFilter = new Common_Filter_SanitizeString();
        $assoccTags = array();
        foreach ($tagNames as $name) {
            $name = trim($name);
            if ($name == '') {
                continue; // skip bogus names in array.
            }
            $tag = $tags->findByName($name);

            if (null == $tag) {
                $tag = $tags->createRow();
                $tag->name = (string) $name;
                $tag->clean_name = $sanitizeFilter->filter($name);
                $tag->save();
            }

            $tagged = $this->createRow(array(
                'tag_id'   => $tag->id, 
                'stream_id' => $streamId));

            $tagged->save();

            $assoccTags[] = $tag;
        }
        return $assoccTags;
    }
}

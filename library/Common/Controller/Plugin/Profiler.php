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
 * @package    Controller_Plugin
 * @copyright  Copyright (c) 2008 Johan Nilsson. (http://www.markupartist.com)
 * @license    New BSD License
 */
class Common_Controller_Plugin_Profiler extends Zend_Controller_Plugin_Abstract
{
    private $startTime;
    private $endTime;
    private $db;

    /**
     * Will enable the database profiler and set the start time for the page
     * execution time.
     * @param Zend_Db_Adapter_Abstract $db
     * @return void
     */
    public function __construct(Zend_Db_Adapter_Abstract $db) {
        $this->db = $db;
        $this->startTime = microtime(true);
        $this->db->getProfiler()->setEnabled(true);
    }

    /**
     * Stops the page execution timer. Will also calculate data that the db
     * profiler has collected during the execution.
     * 
     * Results is echoed in a html comment block direct.
     * @return void
     */
    public function __destruct()
    {
        $this->endTime = microtime(true);
        $executionTime = $this->endTime - $this->startTime;

        $profiler = $this->db->getProfiler();

        $totalTime    = $profiler->getTotalElapsedSecs();
        $queryCount   = $profiler->getTotalNumQueries();
        $longestTime  = 0;
        $longestQuery = null;
        
        foreach ($profiler->getQueryProfiles() as $query) {
            if ($query->getElapsedSecs() > $longestTime) {
                $longestTime  = $query->getElapsedSecs();
                $longestQuery = $query->getQuery();
            }
        }

        $out = array();
        $out[] = "Page rendered in $executionTime seconds";
        $out[] = 'Executed ' . $queryCount . ' queries in ' . $totalTime .
                 ' seconds';
        $out[] = 'Average query length: ' . $totalTime / $queryCount .
                 ' seconds';
        $out[] = 'Queries per second: ' . $queryCount / $totalTime;
        $out[] = 'Longest query length: ' . $longestTime;
        $out[] = "Longest query: " . $longestQuery;

        echo "<!--\n";
        echo implode("\n", $out);
        echo "\n-->\n";
    }
}
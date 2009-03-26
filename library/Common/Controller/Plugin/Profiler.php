<?php
class Common_Controller_Plugin_Profiler extends Zend_Controller_Plugin_Abstract
{
    private $startTime;
    private $endTime;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->startTime = microtime(true);
        $this->db->getProfiler()->setEnabled(true);
    }

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
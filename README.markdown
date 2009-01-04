PHP Lifestream
==============

Aggregates feeds and combines them to one.

* Built with Zend Framework
* Easy to extends with new aggregators and services
* Atom and RSS support

Live example is availabe at <http://www.johannilsson.me>

Contact me on Twitter if you have any suggestions, like it or dont like it 
<http://twitter.com/johanjohanjohan>

Changelog
---------

Concider it unstable and to break for every commit.

Setup
-----

### Webserver

Point the webservers webroot to the public directory. 

Refer to the Zend documentation if running another server than apache what to 
replace the .htaccess file with.

### Cronjob

Setup the cron job for aggregation, the example will run every 5 minute change it
to whatever suits you best.

<pre>
*/5 * * * * php /path/to/app/jobs/aggregate.php >> /path/to/cron_log
</pre>

Todo
----

* Ideas?
* Tags
* Comments

Credits
-------

* Photo icon by Mark James <http://www.famfamfam.com/lab/icons/silk/>
* Zend Framework

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

### Add Feeds

Currently there is no admin interface to add feeds, so I just post some example
sql for adding a simple atom or RSS feed to phplifestream.

<pre>
insert into services set
    `id` = 1, 
    `name` = "Twitter", 
    `code` = "twitter",
    `url` = "http://www.twitter.com/MY USER NAME HERE", 
    `aggregator` = "feed",
    `display_content` = 0,
    `created_at` = now(), 
    `updated_at` = now();
insert into service_options set 
    `service_id` = 1,
    `name` = "url", 
    `value` = "http://twitter.com/statuses/user_timeline/MY ID HERE",
    `created_at` = now(), 
    `updated_at` = now();
</pre>

To get the fancy icons in the beginning set the code to any of these

* delicious
* feed
* flickr
* github
* lastfm
* photo
* twitter 


Todo
----

* Admin Admin
* Statistics, That google thing
* Ideas?
* Tags
* Comments

Credits
-------

* Photo icon by Mark James <http://www.famfamfam.com/lab/icons/silk/>
* Zend Framework

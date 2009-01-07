PHP Lifestream
==============

Aggregates feeds and combines them to one.

* Built with Zend Framework
* Easy to extends with new aggregators and services
* Atom and RSS support

Live example is availabe at <http://www.johannilsson.me>

Contact me on Twitter if you have any suggestions, like it or dont like it 
<http://twitter.com/johanjohanjohan>

Installation
------------

### Configuration

#### Database

Edit the file app/conf/db.ini

#### Include path

If Zend Framework is not in your include path you need to add it. Rename the 
file phplifestream-conf.php.example into phplifestream-conf.php and add the path
to Zend Framework.

#### Environment

You can change the environment in the above mention file phplifestream-conf.php
see comment in it.

### Webserver

Point the webservers webroot to the public directory. 

Refer to the Zend documentation if running another server than apache what to 
replace the .htaccess file with.

### Logging

Application logs is stored in ./log you might need to chmod this.

### Cronjob

Setup the cron job for aggregation, the example will run every 5 minute change it
to whatever suits you best.

<pre>
*/5 * * * * php /path/to/phplifestream/app/jobs/aggregate.php >> /dev/null
</pre>

In production make sure that the directory where the phplifestream-conf.php is is
in the include path for an easy way to set environment.

<pre>
*/5 * * * * php -d include_path="/path/to/phplifestream/" /path/to/phplifestream/app/jobs/aggregate.php
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
    `aggregator` = "Feed",
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
* googlereader  

Deployment
----------

Rename the file deploy_env.properties.example into deploy_env.properties and edit
it, properties in this file will replace production properties in the directory
app/conf.

Then run

<pre>
ant package
</pre>

The directory dist is created containing the following. Everything prepared for
your production environment based on the settings in deploy_env.properties.

<pre>
dist/
|-- app
|-- library
|-- phplifestream.tar.gz
`-- public
</pre>

Changelog
---------

Concider it unstable and to break for each commit.

* Since commit 52a208dcae4e3d7b526d462c655054a0c0c507fc the schema was updated
  please run db/migrate/1.0.1/up.sql to migrate to the latest schema. Also changed
  to use sha1 instead of md5 when calculating the unique_id so you might want to
  re run aggregation.

Todo
----

* Admin Admin
* Ideas?
* Tags from feeds
* Comments

Credits
-------

* Photo icon by Mark James <http://www.famfamfam.com/lab/icons/silk/>
* Zend Framework

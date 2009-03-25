PHPLifestream
=============

PHPLifestream aggregates and provides graphs of your activities around the 
internet.

* Easy to extends with new aggregators and services
* Aggregates any Atom and RSS feed
* Atom and tags is extracted from feeds
* Atom and RSS for aggregated items
* Admin with openid login
* Built with Zend Framework

Live example is availabe at <http://www.johannilsson.me>

Contact me on Twitter if you have any suggestions, like it or dont like it 
<http://twitter.com/johanni>

Installation
------------

* Download zend framework
* Point the document root to /path/to/phplifestream/public
* Add zend framework to the include path
* Log files is located in /path/to/phplifestream/log you might need to chmod 
  this directory.
* Edit the file /path/to/phplifestream/app/conf/app.ini
* Add services to aggregate at http://example.com/services
* Add cron job to aggregate added services.

### Cron job for aggregation

Setup the cron job for aggregation. The example will run every 5 minute change 
it to whatever suits you best.

<pre>
*/5 * * * * php /path/to/phplifestream/app/jobs/aggregate.php >> /dev/null
</pre>

In production make sure that the directory where the phplifestream-conf.php is 
is in the include path for an easy way to set environment.

<pre>
*/5 * * * * php -d include_path="/path/to/phplifestream/" /path/to/phplifestream/app/jobs/aggregate.php
</pre>

### phplifestream-conf.php

This file makes it easier to add the include path and choose the application 
environment. Rename the file phplifestream-conf.php.example to 
phplifestream-conf.php. Add the path to zend framework and choose your 
environment you can choose between 'devlopment' and 'production'.

### deploy_env.properties

Instead of editing the app.ini settings you can edit the options via 
deploy_env.properties. Rename the file deploy_env.properties.example into 
deploy_env.properties.

When running the ant target 'package' these options are applied to the 
production properties in the app.ini file. The project file structure is then 
copied to and prepared with production settings to the 'dist' directory. A 
tar ball is also created in this directory. Just for you to deploy.

Todo
----

* Admin Admin
* Ideas?
* Fix TODO marks in the code.

Credits
-------

* Photo icon by Mark James <http://www.famfamfam.com/lab/icons/silk/>
* Zend Framework

PHP Lifestream
==============

Aggregates feeds and combines them to one.

* Built with Zend Framework
* Easy to extends with new aggregators and services
* Aggregates any Atom or RSS stream
* Atom and RSS support for aggregated items

Live example is availabe at <http://www.johannilsson.me>

Contact me on Twitter if you have any suggestions, like it or dont like it 
<http://twitter.com/johanni>

Installation
------------

### Configuration

All application configuration is done in the file ./app/conf/app.conf.

#### Include path

If Zend Framework is not in your include path you need to add it. Rename the 
file phplifestream-conf.php.example into phplifestream-conf.php and add the path
to Zend Framework.

#### Environment

You can change the environment in the above mention file phplifestream-conf.php
see comment in it.

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

Go to /services/add to add services you want to aggregate.

### Webserver

Point the webservers webroot to the public directory. 

Refer to the Zend documentation if running another server than apache what to 
replace the .htaccess file with.

Deployment
----------

Rename the file deploy_env.properties.example into deploy_env.properties and edit
it, properties in this file will replace production properties in the directory
app/conf.

Then run

<pre>
ant package
</pre>

The directory dist is created containing a prepared version of the application for
your production environment based on the settings in deploy_env.properties.

Changelog
---------
Concider it unstable and to break for each commit.

A full changelog is found in the file CHANGELOG.

Todo
----

* Admin Admin
* Ideas?
* Fix TODO marks in the code.

Credits
-------

* Photo icon by Mark James <http://www.famfamfam.com/lab/icons/silk/>
* Zend Framework

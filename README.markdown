PHP Lifestream
==============

Aggregates feeds and combines them to one.

* Zend Framework
* Atom and RSS support
* Easy to add new aggregators

Changelog
---------

Concider it unstable and to break for every commit.

Setup
-----

### Apache conf

This is just a simple apache vhost conf, but you get the idea.

  <VirtualHost phplifestream>
         ServerName phplifestream
         DocumentRoot /path/to/phplifestream/public
         ErrorLog /path/to/log/phplifestream-error.log
         CustomLog /path/to/log/phplifestream-access.log combined
         <Directory /path/to/log/phplifestream/public>
                 Options Indexes FollowSymLinks MultiViews
                 AllowOverride All
                 Order allow,deny
                 allow from all
         </Directory>
  </VirtualHost>

### Cronjob

Setup the cron job for aggregation 

  */5 * * * * php /path/to/phplifestream/jobs/aggregate.php >> /dev/null

Todo
----

* Replace the aggregation model with service specific aggregators
* Tags
* Comments

Credits
-------

* Photo icon by Mark James <http://www.famfamfam.com/lab/icons/silk/>
* Zend Framework

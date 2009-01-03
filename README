PHP Lifestream
==============

Introduction
------------ 

Aggregates feeds and combines them to one.

* Zend Framework
* Atom and RSS support

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

 */5 * * * * php /path/to/phplifestream/jobs/aggregate.php >> /dev/null

Todo
----

* Replace the aggregation model with service specific aggregators
* Tags
* Comments
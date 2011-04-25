Copyright 2011 John H White <https://github.com/johnhwhite>

Implements the mysql_* functions using the mysqli oop methods. Rather than
rewriting a large codebase to take advantage of the mysqli functions, load
this using http://us3.php.net/manual/en/ini.core.php#ini.auto-prepend-file
and then open /etc/php.d/mysql.ini to comment out the mysql extension.

The /etc/php.d/mysql.ini file exists in RedHat, Centos, and Fedora to
dynamically load the mysql extension.

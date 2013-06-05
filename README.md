# easel
`easel` is a super light-weight MVC framework written for PHP 5.4+

# Getting started
Create a directory for your app, with a basic structure like so:

    bootstrap.php
    lib/
    www/
    templates/

These each have their own purpose:
 * `bootstrap.php` - Common loader file, run on each request
 * `lib/` - Holds all your PHP classes, should follow `Class_Name` to `Class/Name.php` naming convention
 * `www/` - This is your document root and where you will point your webserver
 * `templates/` - This will hold all of your templates, or view files



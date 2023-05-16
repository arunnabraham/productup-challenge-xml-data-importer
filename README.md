XML Data Importer
A console based application to parse XML data and converts to various formats Mainly JSON, CSV etc. Easly implement other formats with reusable/extensible code.

## Initial Setup

composer install

chmod +x ./run

# Dev mode How to Run
## Arguments 

<file stream stdin> | php ./run export <format>

Example:

Remote option: 

<code> curl -s http://a.cdn.searchspring.net/help/feeds/searchspring.xml | php ./run export csv </code>


<code> curl -s http://a.cdn.searchspring.net/help/feeds/searchspring.xml | php ./run export json </code>


<code> cat path/filename.xml | php ./run export csv </code>
 
 
 <code> cat path/filename.xml | php ./run export json </code>
 
 ## Unit testing
 
 Edit phpunit.xml env attribute to relevent values
 run <code> vendor/bin/phpunit </code>
 
 Known Issue, some test cases expects STDIN. To run them
use <code> curl -s http://a.cdn.searchspring.net/help/feeds/searchspring.xml | vendor/bin/phpunit </code>
 
 ## System Requirements
 
 Tested in Linux Environment
 
 PHP version 8.1 with CURL enabled

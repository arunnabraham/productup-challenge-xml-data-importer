# ProductUp Challenge XML Data Importer
A console based application to parse XML data and converts to various formats Mainly JSON, CSV etc. Easly implement other formats with reusable code.

## Initial Setup

composer install

chmod +x ./run

# Dev mode How to Run
## Arguments 

export csv|json

-t [input Type] local|remote

-i [input file path] http(s) | /filepath

Example:

Remote option: 

<code> curl -s http://a.cdn.searchspring.net/help/feeds/searchspring.xml | php ./run export csv </code>
<code> curl -s http://a.cdn.searchspring.net/help/feeds/searchspring.xml | php ./run export json </code>

 <code> cat path/filename.xml | php ./run export csv </code>
  <code> cat path/filename.xml | php ./run export json </code>
 
 
 ## System Requirements
 
 Tested in Linux Environment
 
 PHP version 8.1 with CURL enabled

# ProductUp Challenge XML Data Importer
A console based application to parse XML data and converts to various formats Mainly JSON, CSV etc. Easly implement other formats with reusable code.

# Dev mode How to Run
## Arguments 

export csv|json

-t [input Type] local|remote

-i [input file path] http(s) | /filepath

Example:

<code> ./run export csv -t local -i /rootpath/xml-samples/employee.xml</code>

 <code> ./run export csv -t remote -i http://a.cdn.searchspring.net/help/feeds/searchspring.xml </code>

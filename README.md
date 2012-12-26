This little project was a demo that I was asked to do for a Job interview of sorts. Its a standalone application built on the Joomla! 12.1 Application platform. 
It was a good exercise, because through doing it I disovered Joomla!'s newish RESTful implementation. 

Usage

Each request must have ?p=demo&a=demo attached to the request. a is the username and p is the password. Same for the REST part
You can change the sort order by clicking the Buttons about the list.
Click edit to load the form.
Click delete to get rid of the item.
REST

Use http://example.com/resource/item/[LIST ITEM ID]?p=demo&a=demo to get JSON of the item, i.e. http://example.com/resource/item/8?p=demo&a=demo
Use http://example.com/resource/list/?p=demo&a=demo to get JSON of the entire list.


Install: 

1. SQL IMPORT the /install/mylist.sql file
2. Get the Joomla! Platform v 12.1 and put on your server. 
3. Adjust the DIRLIBRARY constant in the index.php file to match your Joomla! platform location
4. Add DB creds to the configuration.php file. 

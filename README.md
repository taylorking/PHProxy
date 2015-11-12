# PHProxy


### What this is

This is a simple router / proxy server to send requests from PHP to some other server. Because we have virtually zero access to change any configuration of the server, I cannot install the PHP HttpRequest library. To circumvent this, I just call out to bash with curl.

### Motivation

In the database class at school, we are expected to produce some kind of php front end for our final mysql database project. On the student server, the school runs the standard LAMP stack. The server is behind a firewall and no additional ports can be opened to additional servers on the machine. I really hate PHP, with this however, you are able to route requests through apache, to be forwarded to any available host. 

### Usage
Open Index.php and change 

```php
$forwardingAddress = "http://sample";
```

To

```php
$forwardingAddress = "http://my_host:my_port";
```
And keep index.php accessible in your apache directory.

### Making requests
In order to make the request, you need to treat the php file as part of the request path

#### Examples

```http
GET    http://apache_address/index.php/entity
DELETE http://apache_address/index.php/entity
```

These requests are then translated to:

```http
GET    http://my_host:my_port/entity
DELETE http://my_host:my_port/entity
```

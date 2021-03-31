<p align="center">
    <h1 align="center">To deploy project</h1>
    <br>
</p>


INSTALLATION
------------
First of all clone project to your local space from github:

~~~
$ git clone https://github.com/Goganasan86/orders.git
~~~

For deploy project use docker, in command line run:

    docker-compose up -d
    
You can then access the application through the following URL:

~~~
 $ http://localhost:8000/orders
~~~

And you can access the PMA(PhpMyAdmin) through the following URL:

~~~
 $ http://localhost:8080/
~~~

In project folder <i>database</i> you can found two dump sql files, import them into PMA settings 

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.0.

<p align="center">
    <h1 align="center">To deploy project</h1>
    <br>
</p>


INSTALLATION
------------
First of all clone project to your local space via github:

~~~
$ git clone https://github.com/Goganasan86/orders.git
~~~

For deploy project use docker, in command line(Unix, MacOS) run command:

    docker-compose up -d
    
You can then access the application through the following URL:

~~~
 $ http://localhost:8000/orders
~~~

And you can access the PMA(PhpMyAdmin) through the following URL:

~~~
 $ http://localhost:8080/
~~~

In project folder <i>database</i> you can found two dump sql files, import them into PMA settings or put this sql files in <i>modules/orders/web</i> use special action actionAddDataToDb() in OrdersController 


REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 7.0.

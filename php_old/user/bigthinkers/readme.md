## WHAT DATABASE ARE WE USING?

We use MySQL database, otherwise also known as MariaDB.

## WHERE WILL I FIND MYSQL DATABASE?

You have to install a server either locally or remotely. For local servers you may use the following:
1. XAMPP
2. WAMP

The above come packaged with:
1. PHP - A server side programming language.
2. MySQL/MariaDB - RDBMS(Relation Database Management System) Database.
3. Apache - Server.

To use localhost go to Constants class and uncomment either of the following:
```java
private  static  final String base_url = "http://10.0.2.2/php/user/bigthinkers/"; //IF YOU ARE USING ANDROID STUDIO EMULATOR
```
Or:
```java
private  static  final String base_url = "http://10.0.3.2/php/user/bigthinkers/"; //IF YOU ARE USING GENYMOTION
```
Or:
```java
    //supply your ip address. Type ipconfig while connected to internet to get your
    //ip address in cmd and copy value of IPv4.  For example below I have used my ip address
    private  static  final String base_url = "http://YOUR_IP_ADDRESS/php/user/bigthinkers/";
    //e.g private  static  final String base_url = "http://192.168.43.91/php/user/bigthinkers/";
```

For demo purposes we provide a database hosted online. You can insert,update,select and delete from it. To use it go to Constants class in the android code and uncomment the base url pointing to camposha.info e.g:
```java
 public static final String BASE_URL = "https://camposha.info/php/user/bigthinkers/";
```


## HOW TO AUTO-CREATE DATABASE AND TABLE

Our php code can automatically do the following for you:
1. Create for you database
2. Create for you Table
3. Create Fields with appropriate data types
4. INSERT data into table, UPDATE the table, SELECT as well as DELETE.
5. ALTER TABLE properties like data types.

Here is what you do:
1. Go to root directory of your server. If you are using XAMPP this is the htdocs folder. If you are using WAMP this is the WWW folder. If you are using an online host with cpanel then it is the public_html folder.
2. In that root directory, create a folder called `php`.
3. In that `php` folder, extract php code you downloaded.
4. The path is like this : `/php/user/bigthinkers/index.php` or `/php/users/bigthinkers/index.php`.
5. Such that our full URL will be something like this: `https://camposha.info/php/user/bigthinkers/index.php`. or `http://10.0.2.2/php/user/bigthinkers/index.php`
6. Test the full URL in the browser. It should show some json data. If it's not then make sure you have specified the correct url.
7. Now go to your app in the device or emulator.
8. Go to the Upload page. Type the details. Click Upload.
9. The table will be auto-created for you based on the fields if it isn't already there.


## How do I find my IP Address?

Here are the steps for finding your local ip address in windows:
1. Go to command prompt.
2. Type ipconfig.
3. Locate the value of `IPv4`. That is your ip address.
4. You can use it like this:

```java
private  static  final String base_url = "http://192.168.43.91/php/user/bigthinkers/";
```

## TABLE NAMING CONVENTION

Because we are using redbean, a php ORM to generate our tables, we must respect the conventions it lays down. Here are the important ones:

1. No special characters in table names, not even `_` and `-`.
2. No CamelCase e.g `StarsTb` or `StarsTB`, rathre we have `starstb` or `STARSTB`.

For example:

in our php code you can change the table names in the static field in our constants class:
```php
    class Constants{
        static $TABLE_STAR = 'user/bigthinkers';
    }
```




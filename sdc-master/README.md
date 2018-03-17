# Cloud

> A front end base.

1. Change `$DB_HOST`, `$DB_USERNAME` & `$DB_PASS` in `config/config.php`

2. Create DB named **`instances`** in `phpmyadmin`

3. Create **`users`** table  
<code>CREATE TABLE users (
	user_id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    somaiya_id int(10) not null,
    user_name varchar(256) not null,
    user_uid varchar(256) not null,
    user_pass varchar(256) not null
);</code>

4. Create **`instance_data`** table
<code>CREATE TABLE instance_data (
	id int(11) not null AUTO_INCREMENT PRIMARY KEY,
    somaiya_id int(10) not null,
    instance_name varchar(256) not null,
    instance_flavor_name varchar(256) not null,
    instance_image_name varchar(256) not null
);</code>

5. Create **`instance_id_data`** table
<code>
  CREATE TABLE instance_id_data ( id int(11) not null AUTO_INCREMENT PRIMARY KEY, somaiya_id int(10) not null, instance_id varchar(256) not null );
</code>

Use the [reference manual](https://dev.mysql.com/doc/refman/5.5/en/tutorial.html) for a tutorial.

**NOTES**

At college, 

1. $DB_HOST = '192.168.3.16'
   $DB_USERNAME = 'root'
   $DB_PASSWORD = 'root'
  
2. Replace `admin-openrc.sh` with `admin-openrc`.
3. Start outputRows index at **1**.


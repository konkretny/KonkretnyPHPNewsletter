<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>
    <?php
    /*
        Author: Marcin Romanowicz
        URL: http://konkretny.pl/
        License: MIT
        Version: 1.1.2
        */

    require_once('../src/KonkretnyPHPNewsletter.php');
    $mail = new Konkretny\KonkretnyPHPNewsletter();


    //setting mails
    $mail->setContent('My content'); //the content of e-mails
    $mail->setMy_mail('myemail@example.com'); //your e-mail adress
    $mail->setTitle('My title'); //the title of mails
    $mail->setFrom('My name'); //your name

    /*
        $mail->setLimit('2,4'); //limit of sent emails from 2 to 4 - OPTIONAL
         */

    //database connection settings
    $mail->setDatabase_type(0); //0 - MySQL or MariaDB, 1- PostreSQL
    /*
        $mail->setPqsqlschema('your schema') //schema PostreSQL - OPTIONAL
         */
    $mail->setHost('localhost'); //database host
    $mail->setDb_name('database_name'); //database name
    /*
        $mail->setPort(1234567); //if your port other than the default for a given database - OPTIONAL
        */
    $mail->setDb_user('user_name'); //database user name
    $mail->setDb_password('example password'); //database password
    $mail->setTablename('table_name'); //your table in database with mails adress
    $mail->setColumnname('column_name'); //your column in database with mails adress


    //execute
    $mail->pdo_read(); //enable connection with database and read mails
    $mail->sendmassmail(); //send e-mails

    ?>
</body>

</html>
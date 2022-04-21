<?php

// constructor class that is used for sqllite 3 to connect to the database

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('myDB.db');
    }
}

$db = new MyDB();

//creating all the tables and attributes for each table, including priamry keys e.t.c...

$db->exec('CREATE TABLE Products (Product_ID STRING PRIMARY KEY, Product_Name STRING, Price MONEY, Current_Stock INTEGER, Minimum_Stock INTEGER, Supplier_ID STRING)');
$db->exec('CREATE TABLE Orders (Order_ID STRING PRIMARY KEY, Order_Date DATE, Product_ID STRING, Number_Shipped INTEGER)');
$db->exec('CREATE TABLE Stock_Purchases(Purchase_ID STRING PRIMARY KEY, Supplier_ID STRING, Product_ID STRING, Quantity_Recieved INTEGER, Order_Date DATE, Status STRING)');
$db->exec('CREATE TABLE Suppliers (Supplier_ID STRING PRIMARY KEY, Supplier_Name STRING)');
$db->exec('CREATE TABLE Users (Username STRING, Password STRING, Access_Level INT)');

//inserting test data into the database 

$db->exec("INSERT INTO Users(Username,Password,Access_Level) Values ('Admin', 'password1','2')");
$db->exec("INSERT INTO Users(Username,Password,Access_Level) Values ('Finn', 'password1','1')");
$db->exec("INSERT INTO Products Values ('HM001', 'HKHammer','10.00', '15', '2', 'HK')");
?>
<?php






function createCustomer($db2,$fName,$lName,$email,$passwd,$date){

$ret = runDb2InsertQuery($db2,"INSERT INTO CUSTOMERS(FNAME,LNAME,EMAIL,PASSWD,FODDATE TIMESTAMP) values(?,?,?,?,?)",array($fName,$lName,$email,$passwd,$date));
return $ret ? true : false;
}




?>



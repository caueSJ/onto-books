<?php

// CONFIG 
define("DBHOST", "YOUR HOST");
define("DBUSER", "YOUR USER");
define("DBPASS", "YOUR PASSWORD");
define("DBNAME", "YOUR DATABASE NAME");

require_once("mysqli.php");

$db = new dbConn();

    // GENERIC QUERY EXECUTE
    echo "GENERIC QUERY EXECUTE:<br />";
    $a = $db->query("select * from _Users");
    foreach ($a as $b) {
        echo "ID [" . $b["UserID"] . "] - Name [" . $b["UserName"] . "] - Mail [" . $b["UserMail"] . "]<br />";
    }
    $a->close();

    
    // SELECT
    echo "<br />SELECT:<br />";
    if ($r = $db->select("UserID, UserName, UserMail", "_Users", "where UserID=1")) { 
        echo "ID [" . $r["UserID"] . "] - Name [" . $r["UserName"] . "] - Mail [" . $r["UserMail"] . "]<br />";
    } else {
        echo "- No Record Found!<br />";
    }
    unset($r);

    
    // SELECT GROUP
    echo "<br />SELECT GROUP:<br />";
    $d = $db->selectGroup("*", "_Users", "LIMIT 10");
    if ($d->num_rows > 0) {
        while($r = $d->fetch_assoc() ) {
            echo "ID [" . $r["UserID"] . "] - Name [" . $r["UserName"] . "] - Mail [" . $r["UserMail"] . "]<br />";
        }
    } else {
        echo "- No Records Found!<br />";
    }
    echo "- Number of Records [" . $d->num_rows . "]<br />";    
    $d->close();
    
    
    // INSERT
    echo "<br />INSERT:<br />";
    $t = array();
    $t["UserName"] = "Industria Virtual 1";
    $t["UserMail"] = "email1@industriavirtual.com.br";
    if ($db->insert("_Users", $t)) {
        $i = $db->insert_id();
        echo "- New Record ID [" . $i . "]<br />";
    } else {
        echo "- Error Inserting Data!<br />";
    }    

    
    // UPDATE
    echo "<br />UPDATE:<br />";
    $t = array();
    $t["UserName"] = "Industria Virtual 2";
    $t["UserMail"] = "email2@industriavirtual.com.br";
    if ($db->update("_Users", $t, "WHERE UserID=" . $i)) {
        echo "- Record " . $i . " Renamed!<br />"; 
    } else {
        echo "- Error Renamming!<br />"; 
    }
    
    
    // DELETE
    echo "<br />DELETE:<br />";
    if ( $db->delete("_Users", "WHERE UserID=" . $i)) {
        echo "- Record " . $i . " Deleted!<br />"; 
    } else {
        echo "- Delete Error!<br />"; 
    }  
    

    // LIST TABLES ON DATABASE:
    echo "<br />TABLES LIST:<br />";
    $tables = $db->listTables();
    $arrlength = count($tables);
    for($x = 0; $x < $arrlength; $x++) {
        echo $tables[$x] . "<br />";
    }
    
    
    // LIST FIELDS ON TABLE:
    echo "<br />FIELDS LIST:<br />";    
    $fields = $db->listFields("_Users");
    $arrlength = count($fields);
    for($x = 0; $x < $arrlength; $x++) {
        echo "Field [" . $fields[$x]['name'] . "] - Type [" . $fields[$x]['type'] . " (" . $fields[$x]['code'] . ")] - Max Length [" . $fields[$x]['size'] . "]<br />";
    }
    
    
$db->close();
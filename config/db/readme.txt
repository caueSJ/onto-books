MySQLi CLASS

------------------------------------------------------------------------------------------------------------------------
Example Table:

CREATE TABLE `_Users` (
	`UserID` INT(11) NOT NULL AUTO_INCREMENT,
	`UserName` VARCHAR(100) NULL DEFAULT NULL,
	`UserMail` VARCHAR(180) NULL DEFAULT NULL,
	PRIMARY KEY (`UserID`)
)
ENGINE=innoDB
;
INSERT INTO `_Users` (`UserName`, `UserMail`) VALUES ('User 01 Name', 'user1@industriavirtual.com.br');
INSERT INTO `_Users` (`UserName`, `UserMail`) VALUES ('User 02 Name', 'user2@industriavirtual.com.br');
INSERT INTO `_Users` (`UserName`, `UserMail`) VALUES ('User 03 Name', 'user3@industriavirtual.com.br');

------------------------------------------------------------------------------------------------------------------------

HOW TO USE (in your PHP code):

1) Define Database Connection:

define("DBHOST", "host");
define("DBUSER", "user");
define("DBPASS", "password");
define("DBNAME", "database");

------------------------------------------------------------------------------------------------------------------------

2) Include Class File:

require_once("mysqli.php");

------------------------------------------------------------------------------------------------------------------------

3) Open Connection:

$db = new dbConn();

------------------------------------------------------------------------------------------------------------------------

3) Record Select Example:

    if ($r = $db->select("UserID, UserName, UserMail", "_Users", "where UserID=1")) { 
        echo $r["UserMail"] . "<br />";
    } else {
        echo "- No Record Found!<br />";
    }
    unset($r);

------------------------------------------------------------------------------------------------------------------------

3) Close Connection:

$db->close();

------------------------------------------------------------------------------------------------------------------------

NOTE: Optional Connection With Other Database:

$db = new dbConn("host", "user", "password", "database");

------------------------------------------------------------------------------------------------------------------------

OTHER INCLUDED FUNCTIONS:

A) Select Group of Records Example:

    $d = $db->selectGroup("*", "_Users", "LIMIT 10");

        while($r = $d->fetch_assoc() ) {
            echo $r["UserMail"] . "<br />";
        }

    $d->close();

------------------------------------------------------------------------------------------------------------------------

B) Insert Example:

    $t = array();
    $t["UserName"] = "Industria Virtual 1";
    $t["UserMail"] = "email1@industriavirtual.com.br";

    $db->insert("_Users", $t)

------------------------------------------------------------------------------------------------------------------------

C) Update Example:

    $t = array();
    $t["UserName"] = "Industria Virtual 2";
    $t["UserMail"] = "email2@industriavirtual.com.br";

    $db->update("_Users", $t, "WHERE UserID=1")

------------------------------------------------------------------------------------------------------------------------

D) Delete Example:

    $db->delete("_Users", "WHERE UserID=1")

------------------------------------------------------------------------------------------------------------------------

E) Free Query Execute:

    $a = $db->query("select * from _Users");
    foreach ($a as $b) {
        echo $b["UserMail"] . "<br />";
    }
    $a->close();

------------------------------------------------------------------------------------------------------------------------

BONUS:

I) List Tables in Database:

    $tables = $db->listTables();
    $arrlength = count($tables);
    for($x = 0; $x < $arrlength; $x++) {
        echo $tables[$x] . "<br />";
    }

------------------------------------------------------------------------------------------------------------------------

II) List Fields from Table:

    $fields = $db->listFields("_Users");
    $arrlength = count($fields);
    for($x = 0; $x < $arrlength; $x++) {
        echo "Field [" . $fields[$x]['name'] . "] - Type [" . $fields[$x]['type'] . " (" . $fields[$x]['code'] . ")] - Max Length [" . $fields[$x]['size'] . "]<br />";
    }

------------------------------------------------------------------------------------------------------------------------

Check file "example.php" for more information.

Contact: Marcelo Franco (codes@industriavirtual.com.br)
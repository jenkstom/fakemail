<?php

?> 
<HTML><BODY>
<?php
function get_random_string($valid_chars, $length)
{
    // start with an empty random string
    $random_string = "";
    $my_domain = "domain.com";

    // count the number of chars in the valid chars string so we know how many choices we have
    $num_valid_chars = strlen($valid_chars);

    // repeat the steps until we've created a string of the right length
    for ($i = 0; $i < $length; $i++)
    {
        // pick a random number from 1 up to the number of valid chars
        $random_pick = mt_rand(1, $num_valid_chars);

        // take the random character out of the string of valid chars
        // subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
        $random_char = $valid_chars[$random_pick-1];

        // add the randomly-chosen char onto the end of our string so far
        $random_string .= $random_char;
    }

    // return our finished random string
    return $random_string;
}


$dbh = new PDO("mysql:host=127.0.0.1;dbname=valias","valias", "dbpass");


//generate random string
$rand=get_random_string('abcdefghijklmnopqrstuvwxyz1234567890',6).$my_domain;
//echo "Random: $rand\n";

//insert string into database with given email address
$email = $_GET["email"];
$note = $_GET["note"];
$days = $_GET["days"];
$daysdb = $days." 0:0:0";
//echo "Dest: $email\n";

$stmt = $dbh->prepare("insert into mxaliases (alias,forw_addr,valid_thru) values (:rand,:email,".
	"addtime(current_timestamp,:days))");

$stmt->bindParam(":rand",$rand);
$stmt->bindParam(":email",$email);
$stmt->bindParam(":days",$daysdb);

if (!$stmt->execute())
{
    echo "PDO Error 1.1:\n";
    print_r($stmt->errorInfo());
    exit;
}


echo "<p>$rand now forwards to $email. This will be deleted in $days days.</p>\n";

mail($email, "Fake email address generated", 
"$rand now forwards to this email address and will be ".
"deleted $days days from now. Note: $note",
"From: webmaster@$my_domain\n" );


?>
</body></html>

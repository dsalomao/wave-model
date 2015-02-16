<?php
/**
 * Created by PhpStorm.
 * User: Daniel
 * Date: 15/02/15
 * Time: 22:03
 */

require("phpsqlajax_dbinfo.php");

// Start XML file, create parent node
$doc = new DOMDocument("1.0");
$node = $doc->createElement("markers");
$parnode = $doc->appendChild($node);

// Opens a connection to a MySQL server
$connection = mysql_connect('localhost', $username, $password);
if(!$connection){
    die('Not connected : '.mysql_error());
}

// Set the active MySQL database
$db_selected = mysql_select_db('wave_model', $connection);
if(!$db_selected){
    die('Can\'t use db : '.mysql_error());
}

// Select all the rows in the markers table
$query = "SELECT * FROM markers WHERE 1";
$result = mysql_query($query);
if(!$result){
    die('Invalid query : '.mysql_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding xml nodes to it
while($row = @mysql_fetch_assoc($result)){
    // ADD TO XML DOCUMENT NODE
    $node = $doc->createElement("marker");
    $newnode = $parnode->appendChild($node);

    $newnode->setAttribute("name", utf8_encode($row['name']));
    $newnode->setAttribute("address", utf8_encode($row['address']));
    $newnode->setAttribute("lat", utf8_encode($row['lat']));
    $newnode->setAttribute("lng", utf8_encode($row['lng']));
    $newnode->setAttribute("type", utf8_encode($row['type']));
}


echo $doc->saveXML();

?>
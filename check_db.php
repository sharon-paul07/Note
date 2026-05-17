<?php
require 'config.php';
$result = $conn->query("SHOW TABLES");
if ($result->num_rows > 0) {
    while($row = $result->fetch_array()) {
        echo $row[0] . "\n";
    }
} else {
    echo "No tables found.";
}
$conn->close();
?>

<?php
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Nested Query");
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
    echo $output;
}

$query = "select Manufacturer_ID, GROUP_CONCAT(DISTINCT Player_Name) as 'PlayerName' from Players group by Manufacturer_ID;";
$stmt = $mysqli -> prepare($query);
$stmt -> execute();

if ($stmt) {
    echo "<div class='row'>
    <center>
    <h2>Davidson Query:</h2>
    select Manufacturer_ID, GROUP_CONCAT(DISTINCT Player_Name) as 'PlayerName' from Players group by Manufacturer_ID
    <br>
    <br>
    <table>
        <thead>
            <tr><th>Manufacturer ID</th><th>Players</th>
        </thead>
        <tbody>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $mID = $row['Manufacturer_ID'];
        $players = $row['PlayerName'];
        echo "<td style='text-align-center'>".$mID."</td>";
        echo "<td style='text-align-center'>".$players."</td></tr>";
    }
    echo "</tbody>
    </table>
    <br>
    <a href='DGDBRead.php'>Back To Players</a>
    </center>
    </div>";
}
new_footer("2021 Disc Golf Players");
Database::dbDisconnect($mysqli);
?>

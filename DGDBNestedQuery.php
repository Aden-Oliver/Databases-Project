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

$query = "select Manufacturer_Name from Manufacturers natural join Players natural join Player_Stats
where Player_Stats.Last_Event_Won IN (Select Event_ID from Tour_Events where Event_Tier = 'Elite Series');";
$stmt = $mysqli -> prepare($query);
$stmt -> execute();

if ($stmt) {
    echo "<div class='row'>
    <center>
    <h2>Nested Query:</h2>
    select Manufacturer_Name from Manufacturers natural join Players natural join Player_Stats
    where Player_Stats.Last_Event_Won IN (Select Event_ID from Tour_Events where Event_Tier = 'Elite Series')
    <br>
    <br>
    <table>
        <thead>
            <tr><th>Manufacturers with players who won an Elite Series event: </th>
        </thead>
        <tbody>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $mname = $row['Manufacturer_Name'];
        echo "<td style='text-align-center'>".$mname."</td></tr>";
    }
    echo "</tbody>
    </table>

    (Two Players won the Ledgestone Insurance Open, both sponsored by Innova) <br>
    <a href='DGDBRead.php'>Back To Players</a>
    </center>
    </div>";
}
new_footer("2021 Disc Golf Players");
Database::dbDisconnect($mysqli);
?>

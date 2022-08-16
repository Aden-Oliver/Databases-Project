<?php
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Top Disc Golfers 2021");
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
    echo $output;
}

$query = "select Player_ID, Player_Name, Manufacturer_Name, C1_Putting, Best_Tour_Finish_2021 from Player_Stats natural join Players natural join Manufacturers natural join Tour_Events Group by Player_ID";
$stmt = $mysqli -> prepare($query);
$stmt -> execute();

if ($stmt) {
    echo "<div class='row'>
    <center>
    <h2>Top Players 2021</h2>
    <table>
        <thead>
            <tr><th></th><th>Player Name</th><th>Manufacturer Sponsor</th><th>Circle 1 Putting Percentage</th><th>Best Tour Finish 2021</th><th></th>
        </thead>
        <tbody>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $pID = $row['Player_ID'];
        $pName = $row['Player_Name'];
        $manuf = $row['Manufacturer_Name'];
        $c1Putt = $row['C1_Putting'];
        $bestTour = $row['Best_Tour_Finish_2021'];
        echo "<tr><td><a href='DGDBDelete.php?id=".urlencode($pID)."' style=' color: red ' onclick='return confirm(\"Are you sure?\"); '>X</a></td>
        <td style='text-align-center'>".$pName."</td>
        <td style='text-align-center'>".$manuf."</td>
        <td style='text-align-center'>".$c1Putt."</td>
        <td style='text-align-center'>".$bestTour."</td>
        <td><a href='DGDBUpdate.php?id=".urlencode($pID)."'>Edit</a></td>
        </tr>";
    }
    echo "</tbody>
    </table>


    <a href='DGDBCreate.php'>Add a Player</a> |
    <a href='DGDBNestedQuery.php'>Nested Query</a> |
    <a href='DGDBAggregateQuery.php'>Aggregate Query</a> | 
    <a href='DGDBDavidsonQuery.php'>Davidson Query</a>
    </center>
    </div>";
}
new_footer("2021 Disc Golf Players");
Database::dbDisconnect($mysqli);
?>

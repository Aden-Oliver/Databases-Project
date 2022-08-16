<?php
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Aggregate Query");
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
    echo $output;
}

$query = "select Manufacturer_Name, count(Manufacturer_ID) from Discs natural join Manufacturers
    group by Manufacturer_Name order by Count(Manufacturer_ID)";
$stmt = $mysqli -> prepare($query);
$stmt -> execute();

if ($stmt) {
    echo "<div class='row'>
    <center>
    <h2>Aggregate Query:</h2>
    select Manufacturer_Name, count(Manufacturer_ID) from Discs natural join Manufacturers group by Manufacturer_Name order by Count(Manufacturer_ID)
    <br>
    <br>
    <table>
        <thead>
            <tr><th>Manufacturer </th><th>Number of Discs </th>
        </thead>
        <tbody>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $MN = $row['Manufacturer_Name'];
        $count = $row['count(Manufacturer_ID)'];
        echo "<td style='text-align-center'>".$MN."</td>";
        echo "<td style='text-align-center'>".$count."</td></tr>";
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

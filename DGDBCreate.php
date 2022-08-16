<?php
require_once("included_functions.php");
require_once("database.php");
require_once("session.php");

$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
	echo $output;
}
	echo "<center>";
	echo "<h3>Add a New Player</h3>";
	echo "<div class='row'>";
	echo "<label for='left-label' class='left inline'>";
		echo "</center>";

	if (isset($_POST["submit"])) {
		if( (isset($_POST["Name"]) && $_POST["Name"] !== "") && (isset($_POST["Manufacturer"]) && $_POST["Manufacturer"] !== "") && (isset($_POST["C1Putting"]) && $_POST["C1Putting"] !== "") && (isset($_POST["TourFinish"]) && $_POST["TourFinish"] !== "")) {
					$stmt3 = $mysqli -> prepare("insert into Players (Player_Name, Manufacturer_ID) values (?,?)");
					$stmt3 -> execute([$_POST["Name"], $_POST["Manufacturer"]]);

					if($stmt3) {
							$stmt5 = $mysqli -> prepare("insert into Player_Stats(Player_Name, C1_Putting, Best_Tour_Finish_2021) values (?, ?, ?)");
							$stmt5 -> execute([$_POST["Name"], $_POST["C1Putting"], $_POST["TourFinish"]]);

							if($stmt5) {
								$_SESSION["message"] = $_POST["Name"]." has been added!";
							}

							else {
								$_SESSION["message"] = $_POST["Name"]." could not be added.";
							}
						}
					else {
						$_SESSION["message"] = "There was an error creating ".$_POST["Name"];
					}
						redirect("DGDBRead.php");
					}

		else {
				$_SESSION["message"] = "Unable to add video game. Fill in all information!";
				redirect("DGDBRead.php");
		}
	}
	else {

			echo "<form method='post' action='DGDBCreate.php'>";
			echo "<center>";
			echo "<p>Name: <input type=text name='Name'></p>";
			echo "Manufacturer: <select name='Manufacturer'>";

			$stmt2 = $mysqli -> prepare("select distinct Manufacturer_ID, Manufacturer_Name from Manufacturers");
			$stmt2 -> execute();
			while(($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))){
				echo "<option value=".$row2["Manufacturer_ID"].">".$row2["Manufacturer_Name"]."</option>";
			}

			echo "</select>";
			echo "<p>Circle 1 Putting Percentage: <input type='number' name='C1Putting'></p>";
			echo "<p>Best 2021 Tour Finish: <input type='number' name='TourFinish'></p>";
			echo "</p><input type='submit' name='submit' class='button tiny round' value='Add Player'/>";
			echo "</form>";

	}
	echo "</label>";
	echo "</div>";
	echo "<br /><p>&laquo:<a href='DGDBRead.php'>Back to Main Page</a>";

new_footer("2021 Disc Golf Players ");
Database::dbDisconnect($mysqli);
?>

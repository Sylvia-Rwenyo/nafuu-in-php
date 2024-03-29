<?php
// Include necessary files and start session
require_once __DIR__ . '/vendor/autoload.php';
use Phpml\Classification\KNearestNeighbors;
include_once 'conn.php';

// Initialize empty arrays to store data for each day
$sleepData = array();
$mealsData = array();
$exerciseData = array();
$riskLevels = array();
$userID = $_SESSION['id'];

// Function to calculate risk level based on criteria
function calculateRiskLevel($sleepPercentage, $mealsPercentage, $exercisePercentage) {
    // Define  criteria and calculations  to determine the risk level (0, 1, or 2)
    // Example criteria:
    if ($sleepPercentage >= 80 && $mealsPercentage >= 80 && $exercisePercentage >= 80) {
        return 0; // Low risk
    } elseif ($sleepPercentage >= 60 && $mealsPercentage >= 60 && $exercisePercentage >= 60) {
        return 1; // Moderate risk
    } else {
        return 2; // High risk
    }
}

// Function to fetch and calculate data for a specific day
function fetchDataForDay($conn, $userID, $tableName, &$sleepData, &$mealsData, &$exerciseData, &$riskLevels, &$i) {
    $sql = "SELECT * FROM $tableName WHERE userID = '$userID' AND DATE(recordDate) BETWEEN CURDATE() - INTERVAL $i DAY AND CURDATE()";
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        // Handle query error
        echo "Error executing query: " . mysqli_error($conn);
        return;
    }

    $rowCount = mysqli_num_rows($result);

    if ($rowCount > 0) {
        while ($row = mysqli_fetch_array($result)) {
            // Fetch and calculate sleep, meals, exercise data for the day
            $sleepTime = 0;
            if(isset($row['sleepTime'])){
                $sleepTime = $row['sleepTime'];
            }
            $mealNumbers = 0;
            if(isset($row['mealName'])){
                $mealNumbers += 1; 
            }
            $exerciseTime = 0;
            if(isset($row['exerciseDuration'])){
                $exerciseTime = $row['exerciseDuration'];
            }

            $targetSleep = 9;
            $targetMeals = 3;
            $targetExercise = 60;

            $sleepPercentage = 100 * $sleepTime / $targetSleep;
            $mealsPercentage = 100 * $mealNumbers / $targetMeals;
            $exercisePercentage = 100 * $exerciseTime / $targetExercise;

            // Store data for the day
            $sleepData[] = $sleepTime;
            $mealsData[] = $mealNumbers;
            $exerciseData[] = $exerciseTime;

            // Calculate risk level for the day
            $riskLevel = calculateRiskLevel($sleepPercentage, $mealsPercentage, $exercisePercentage);
            $riskLevels[] = $riskLevel;
        }
    }
}


// Fetch and calculate data for each of the last seven days
for ($i = 0; $i < 7; $i++) {
    // Adjust the table names accordingly (e.g., 'patientsleeplog', 'patientsmeallog', 'patientsexerciselog')
    $sleepTableName = 'patientsleeplog';
    $mealsTableName = 'patientsmeallog';
    $exerciseTableName = 'patientsexerciselog';

    // Initialize arrays for each day
    $sleepData = array();
    $mealsData = array();
    $exerciseData = array();
    $riskLevels = array();

    // Fetch data for each category
    fetchDataForDay($conn, $userID, $sleepTableName, $sleepData, $mealsData, $exerciseData, $riskLevels, $i);
    fetchDataForDay($conn, $userID, $mealsTableName, $sleepData, $mealsData, $exerciseData, $riskLevels, $i);
    fetchDataForDay($conn, $userID, $exerciseTableName, $sleepData, $mealsData, $exerciseData, $riskLevels, $i);

    // Check if there is sufficient data for the day
    if (count($riskLevels) > 0) {
        // echo "Contents of riskLevels array for day $i:<br>";
        // print_r($riskLevels);

        // Create an array for k-NN input
        $samples = [];
        foreach ($riskLevels as $key => $value) {
            $samples[] = [$sleepData[$key], $mealsData[$key], $exerciseData[$key]];
        }

        // Labels for k-NN input
        $labels = $riskLevels;

        // Create and train the k-NN classifier
        $classifier = new KNearestNeighbors();
        $classifier->train($samples, $labels);

        // Use the classifier to predict the risk level for the latest data
        $latestData = [$sleepData[count($riskLevels) - 1], $mealsData[count($riskLevels) - 1], $exerciseData[count($riskLevels) - 1]];
        $predictedRiskLevel = $classifier->predict($latestData);
    } else {
        $predictedRiskLevel = 3;
    }
}



?>

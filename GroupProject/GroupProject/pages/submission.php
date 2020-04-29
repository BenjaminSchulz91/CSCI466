<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Athletic Database - Form Submission</title>
  <meta name="description" content="Athletic Database">
  <meta name="author" content="SitePoint">
  <link rel="stylesheet" href="../styles.css">
  <script src="https://www.w3schools.com/lib/w3.js"></script>
</head>

<?PHP
  include('user_info.php');
  $username = 'z1799041';
  $connected = false;
  try { // if something goes wrong, an exception is thrown
    $dsn = "mysql:host=courses;dbname=z1799041";
    $pdo = new PDO($dsn, $username, $password);
    $connected = true;
  }
  catch(PDOexception $e) { // handle that exception
    echo "Connection to database failed: " . $e->getMessage();
  }
?>

<header>
  <a href="../index.html"><img src="../images/athleticLogo.png" alt="logo"></a>
</header>

<body>
  <div id="content">

    <?php
    //Convert relevant unit to micrograms in order to be stored in database
    function toMicroGrams($unit, &$value){
  	   switch($unit) {
  	      case "grams":
            $value *= 1000;
    				break;
    			case "milligrams":
    				break;
          case "micrograms":
            $value *= .001;
    			case "ounces":
    				$value *= 28.35 * 1000;
    				break;
    			case "pounds":
    				$value *= 454 * 1000;
    				break;
          case "cups":
            $value *= 128 * 1000;
    		}
        return $value;
      }

    // semi-convoluted way of making sure the values appear to the user in a nice readable format
    function fromMicroGrams(&$value){
      if($value > 1000){
        $value *= 0.001;
        $value = strval($value + 0) . 'g';
      }
      else if($value < 0){
        $value *= 1000;
        $value = strval($value + 0) . 'ug';
      }
      else{
        $value = strval($value + 0) . 'mg';
      }
      return $value;
    }

    if($connected){
      //Enter New workout
      if(isset($_POST['enter_workout_submit'])){
        $addWorkout= $pdo->prepare('INSERT INTO Workout (user_ID, type, duration, intensity) VALUES (?, ?, ?, ?);');
        $addWorkout->execute(array($_POST["user_ID"], $_POST["type"], $_POST["duration"], $_POST["intensity"]));

        echo "<p>Successfully added workout</p><p>Page will redirect in 3 seconds</p>";
        ?>
          <script>
            setTimeout(function (){window.location.href= 'http://students.cs.niu.edu/~z1799041/GroupProject/pages/enter_workout.php';},3000); // 5 seconds
          </script>
        <?php
      }

      // View Workout History
      if(isset($_POST['workout_history_submit'])){
        $user = $_POST["user_ID"];
        $from = date("Y-m-d", strtotime($_POST["from_date"]));
        $to = date("Y-m-d", strtotime($_POST["to_date"]));
        $rs = $pdo->query("SELECT * FROM Workout WHERE user_ID = $user AND (date_completed BETWEEN CAST('$from  00:00:00' as DATETIME) AND CAST('$to 23:59:59' as DATETIME));");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

        echo "<h4>Workout History for User #" . $user . "</h4>";
        echo "<table border=1 cellspaces=1 id=\"myTable\">";
        echo "<tr>
                <th onclick=\"w3.sortHTML('#myTable','.item', 'td:nth-child(2)')\">Type</th>
                <th onclick=\"w3.sortHTML('#myTable','.item', 'td:nth-child(3)')\">Intensity</th><th>Duration</th>
                <th onclick=\"w3.sortHTML('#myTable','.item', 'td:nth-child(4)')\">Date</th>
              </tr>\n";
        foreach ($rows as $row) {
          echo "<tr class=\"item\"><td>" . $row["type"] . "</td><td>" . $row["intensity"] . "</td><td>" . $row["duration"] . "</td><td>" . $row["date_completed"] . "</td></tr>\n";
        }
        echo "</table>";
      }

      // Update Weight
      if(isset($_POST['update_weight_submit'])){
        $addWeight= $pdo->prepare('INSERT INTO Weight (user_ID, user_weight) VALUES (?, ?);');
        $addWeight->execute(array($_POST["user_ID"], $_POST["user_weight"]));

        echo "<p>Successfully updated weight</p>";
      }

      // View Weight History
      if(isset($_POST['weight_history_submit'])){
        $user = $_POST["user_ID"];
        $from = date("Y-m-d", strtotime($_POST["from_date"]));
        $to = date("Y-m-d", strtotime($_POST["to_date"]));
        $rs = $pdo->query("SELECT * FROM Weight WHERE user_ID = $user AND (date_logged BETWEEN CAST('$from  00:00:00' as DATETIME) AND CAST('$to 23:59:59' as DATETIME));");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

        echo "<h4>Weight History for User #" . $user . "</h4>";
        echo "<table border=1 cellspaces=1 id=\"myTable\">";
        echo "<tr>
                <th onclick=\"w3.sortHTML('#myTable','.item', 'td:nth-child(2)')\">Weight</th>
                <th onclick=\"w3.sortHTML('#myTable','.item', 'td:nth-child(3)')\">Date</th>
              </tr>\n";
        foreach ($rows as $row) {
          echo "<tr class=\"item\"><td>" . $row["user_weight"] . "</td><td>" . $row["date_logged"] . "</td></tr>\n";
        }
        echo "</table>";
      }

      // Add Meal Item
      if(isset($_POST['enter_meal_item_submit'])){
        $addMealItem= $pdo->prepare('INSERT INTO Eats (user_ID, item_name, num_of_servings) VALUES (?, ?, ?);');
        $addMealItem->execute(array($_POST["user_ID"], $_POST["item_name"], $_POST["num_of_servings"]));

        echo "<p>Successfully added meal item</p><p>Page will redirect in 3 seconds</p>";
        ?>
          <script>
            setTimeout(function (){window.location.href= 'http://students.cs.niu.edu/~z1799041/GroupProject/pages/track_meals.php';},3000); // 5 seconds
          </script>
        <?php
      }

      // View Meal History
      if(isset($_POST['meal_history_submit'])){
        $user = $_POST["user_ID"];
        $from = date("Y-m-d", strtotime($_POST["from_date"]));
        $to = date("Y-m-d", strtotime($_POST["to_date"]));
        $rs = $pdo->query("SELECT * FROM Eats WHERE user_ID = $user AND (date_consumed BETWEEN CAST('$from  00:00:00' as DATETIME) AND CAST('$to 23:59:59' as DATETIME));");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

        echo "<h4>Meal History for User #" . $user . "</h4>";
        echo "<table border=1 cellspaces=1 id=\"myTable\">";
        echo "<tr>
                <th onclick=\"w3.sortHTML('#myTable','.item', 'td:nth-child(2)')\">Food/Drink</th>
                <th onclick=\"w3.sortHTML('#myTable','.item', 'td:nth-child(3)')\"># of Servings</th>
                <th onclick=\"w3.sortHTML('#myTable','.item', 'td:nth-child(4)')\">Date</th></tr>\n";
        foreach ($rows as $row) {
          echo "<tr class=\"item\"><td>" . $row["item_name"] . "</td><td>" . $row["num_of_servings"] . "</td><td>" . $row["date_consumed"] . "</td></tr>\n";
        }
        echo "</table>";

        $protein = $fat = $sugars = $fiber = $cholestrol = $sodium = $calories = 0;

        foreach ($rows as $row){
          $item = $row["item_name"];

          $info = $pdo->query("SELECT * FROM NutritionalInfo WHERE item_name = '$item';");
          $info_rows = $info->fetchAll(PDO::FETCH_ASSOC);
          foreach($info_rows as $info_row){
            switch($info_row["nutrient_name"]){
              case "Protein":
                $protein += floatval($info_row["nutrient_amount"]);
              break;
              case "Fat":
                $fat += floatval($info_row["nutrient_amount"]);
              break;
              case "Sugars":
                $sugars += floatval($info_row["nutrient_amount"]);
              break;
              case "Fiber":
                $fiber += floatval($info_row["nutrient_amount"]);
              break;
              case "Cholestrol":
                $cholestrol += floatval($info_row["nutrient_amount"]);
              break;
              case "Sodium":
                $sodium += floatval($info_row["nutrient_amount"]);
              break;
            }
          }

          $info = $pdo->query("SELECT * FROM FoodBeverage WHERE item_name = '$item';");
          $info_rows = $info->fetchAll(PDO::FETCH_ASSOC);
          foreach($info_rows as $info_row){
            $calories += floatval($info_row["calories"]);
          }
        }

        echo "<h4>Totals Calories and Macronutrients for the period</h4>";
        echo "<table border=1 cellspaces=1>
                <tr>
                  <th>Calories</th><th>Protein</th><th>Fat</th><th>Sugars</th><th>Fiber</th><th>Cholestrol</th><th>Sodium</th>
                </tr>
                <tr>
                  <td>" . $calories . "</td>
                  <td>" . fromMicroGrams($protein) . "</td>
                  <td>" . fromMicroGrams($fat) . "</td>
                  <td>" . fromMicroGrams($sugars) . "</td>
                  <td>" . fromMicroGrams($fiber) . "</td>
                  <td>" . fromMicroGrams($cholestrol) . "</td>
                  <td>" . fromMicroGrams($sodium) . "</td>
                </tr>
              </table>";
      }
      // New user
      if(isset($_POST['new_user_submit'])){
        $user = $_POST["name"];
        $addUser= $pdo->prepare('INSERT INTO User (name) VALUES (?);');
        $addUser->execute(array($user));

        echo "<p>Added '" . $user . "'  to User database</p><p>Page will redirect in 3 seconds</p>";
        ?>
          <script>
            setTimeout(function (){window.location.href= 'http://students.cs.niu.edu/~z1799041/GroupProject/index.html';},3000); // 5 seconds
          </script>
        <?php

      }

      // New Food/Beverage
        if(isset($_POST['food_beverage_submit'])){
          $one_serving_size = toMicroGrams($_POST["units"], $_POST["serving_size"]);
          $item_name = $_POST["item_name"];
          $addFoodBev= $pdo->prepare('INSERT INTO FoodBeverage (item_name, serving_size, calories) VALUES (?, ?, ?);');
          $addFoodBev->execute(array($_POST["item_name"], $one_serving_size, $_POST["calories"]));

          echo "<p>Added '" . $item_name . "'  to FoodBeverage database</p>";
          ?>
            <script>
              setTimeout(function (){window.location.href= 'http://students.cs.niu.edu/~z1799041/GroupProject/pages/food&drink.php';},3000); // 5 seconds
            </script>
          <?php
        }

        // New NutritionalInfo
        if(isset($_POST['nutritional_info_submit'])){
          $nutrient_ammount = toMicroGrams($_POST["units"], $_POST["nutrient_amount"]);
          $nutrient_name = $_POST["nutrient_name"];
          $item_name = $_POST["item_name"];
          $addNutrient= $pdo->prepare('INSERT INTO NutritionalInfo (nutrient_name, item_name, nutrient_amount) VALUES (?, ?, ?);');
          $addNutrient->execute(array($_POST["nutrient_name"], $_POST["item_name"], $nutrient_ammount));

          echo "<p>Added '" . $nutrient_name . " contained in " . $item_name . "'  to NutritionalInfo database</p><p>Page will redirect in 3 seconds</p>";
          ?>
            <script>
              setTimeout(function (){window.location.href= 'http://students.cs.niu.edu/~z1799041/GroupProject/pages/food&drink.php';},3000); // 5 seconds
            </script>
          <?php
        }
    }
    ?>

  </div>
</body>

<footer>
  <p>Created by the Wuhan Clan for NIU CSCI466 Group Project &copy; 4/20/2020</p>
</footer>
</html>

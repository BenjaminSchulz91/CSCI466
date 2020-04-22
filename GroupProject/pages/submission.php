<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Athletic Database - Form Submission</title>
  <meta name="description" content="Athletic Database">
  <meta name="author" content="SitePoint">
  <link rel="stylesheet" href="../styles.css">
</head>

<?PHP
  include('user_info.php');
  $username = 'z1799041';
  $connected = false;
  try { // if something goes wrong, an exception is thrown
    $dsn = "mysql:host=courses;dbname=test";
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
    if($connected){
      if(isset($_POST['workout_history_submit'])){
        $user = $_POST["user_ID"];
        $from = date("Y-m-d", strtotime($_POST["from_date"]));
        $to = date("Y-m-d", strtotime($_POST["to_date"]));
        $rs = $pdo->query("SELECT * FROM Workout WHERE user_ID = $user AND (date_completed BETWEEN CAST('$from  00:00:00' as DATETIME) AND CAST('$to 00:00:00' as DATETIME));");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border=1 cellspaces=1>";
        echo "<tr><th>User ID</th><th>Type</th><th>Intensity</th><th>Duration</th><th>Date</th></tr>\n";
        foreach ($rows as $row) {
          echo "<tr><td>" . $row["user_ID"] . "</td><td>" . $row["type"] . "</td><td>" . $row["intensity"] . "</td><td>" . $row["duration"] . "</td><td>" . $row["date_completed"] . "</td></tr>\n";
        }
        echo "</table>";
      }

      if(isset($_POST['weight_history_submit'])){
        $user = $_POST["user_ID"];
        $from = date("Y-m-d", strtotime($_POST["from_date"]));
        $to = date("Y-m-d", strtotime($_POST["to_date"]));
        $rs = $pdo->query("SELECT * FROM Weight WHERE user_ID = $user AND (date_logged BETWEEN CAST('$from  00:00:00' as DATETIME) AND CAST('$to 00:00:00' as DATETIME));");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border=1 cellspaces=1>";
        echo "<tr><th>User ID</th><th>Weight</th><th>Date</th></tr>\n";
        foreach ($rows as $row) {
          echo "<tr><td>" . $row["user_ID"] . "</td><td>" . $row["user_weight"] . "</td><td>" . $row["date_logged"] . "</td></tr>\n";
        }
        echo "</table>";
      }

      if(isset($_POST['meal_history_submit'])){
        $user = $_POST["user_ID"];
        $from = date("Y-m-d", strtotime($_POST["from_date"]));
        $to = date("Y-m-d", strtotime($_POST["to_date"]));
        $rs = $pdo->query("SELECT * FROM Eats WHERE user_ID = $user AND (date_consumed BETWEEN CAST('$from  00:00:00' as DATETIME) AND CAST('$to 00:00:00' as DATETIME));");
        $rows = $rs->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border=1 cellspaces=1>";
        echo "<tr><th>User ID</th><th>Food/Drink</th><th># of Servings</th><th>Date</th></tr>\n";
        foreach ($rows as $row) {
          echo "<tr><td>" . $row["user_ID"] . "</td><td>" . $row["item_name"] . "</td><td>" . $row["num_of_servings"] . "</td><td>" . $row["date_consumed"] . "</td></tr>\n";
        }
        echo "</table>";
      }
    }
    ?>

  </div>
</body>

<footer>
  <p>Created by the Wuhan Clan for NIU CSCI466 Group Project &copy; 4/20/2020</p>
</footer>
</html>

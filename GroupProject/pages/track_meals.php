<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Athletic Database - Track Meals</title>
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
    <h3 class="title">Enter Meal Item</h3>
    <form action="submission.php" method="POST">
      <label>User</label>
        <select name="user_ID" class="data">
          <?php
          if($connected){
            $rs = $pdo->query("SELECT * FROM User;");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
              echo "<option value=" . $row["user_ID"] . ">" . $row["user_ID"] . " | " . $row["name"] . "</option>";
            }
          }
          ?>
        </select>
      <label>Food/Drink</label>
        <select name="type" class="data">
          <?php
          if($connected){
            $rs = $pdo->query("SELECT * FROM FoodBeverage;");
            $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
              echo "<option value=" . $row["item_name"] . ">" . $row["item_name"] . "</option>";
            }
          }
          ?>
        </select>
      <label>Number of Servings</label>
        <input type="number" name="num_of_servings" step="1" value="" title="Enter Number of Servings" required>
      <input type="submit" name="enter_meal_item_submit" value="Enter Meal Item">
      </form>

      <h3 class="title" style="margin-top: 20px;">View Meal History</h3>
      <form  action="submission.php" method="POST">
        <label>User</label>
          <select name="user_ID" class="data">
            <?php
            if($connected){
              $rs = $pdo->query("SELECT * FROM User;");
              $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
              foreach ($rows as $row) {
                echo "<option value=" . $row["user_ID"] . ">" . $row["user_ID"] . " | " . $row["name"] . "</option>";
              }
            }
            ?>
          </select>
          <label>From</label>
            <input type="date" id="from" name="from_date">
          <label>To</label>
            <input type="date" id="to" name="to_date">
        <input type="submit" name="meal_history_submit" value="View History">
      </form>
  </div>
</body>

<footer>
  <p>Created by the Wuhan Clan for NIU CSCI466 Group Project &copy; 4/20/2020</p>
</footer>
</html>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Athletic Database - New Food/Drink</title>
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



    <h3 class="title">Add New Food/Drink Item</h3>
    <form action="submission.php" method="POST">
      <label>Food/Drink Name</label>
        <input type="text" name="item_name" value="" required>
      <label>Serving size</label>
        <input type="number" name="serving_size" value="" required title="How large a serving is">
        <select name="units" class="units">
          <option value="grams">grams (g)</option>
          <option value="milligrams">milligrams (mg)</option>
          <option value="ounces">ounces (oz)</option>
          <option value="grams">pounds (lbs)</option>
        </select>
      <label>Calories per Serving</label>
        <input type="number" name="calories" value="" title="Number of calories per serving" required>
      <input type="submit" name="food_beverage_submit" value="Add Item">
    </form>



    <h3 class="title" style="margin-top: 20px;">Add Nutritional Info</h3>
    <form  action="submission.php" method="POST">
      <label>Food/Drink Name</label>
        <select name="item_name" class="data">
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
      <label>Nutrient</label>
        <select name="nutrient_name" class="data">
          <?php
            if($connected){
              $rs = $pdo->query("SELECT * FROM Nutrients;");
              $rows = $rs->fetchAll(PDO::FETCH_ASSOC);
              foreach ($rows as $row) {
                echo "<option value=" . $row["nutrient_name"] . ">" . $row["nutrient_name"] . "</option>";
              }
            }
          ?>
        </select>
      <label for="">Amount</label>
        <input type="number" step="1" name="nutrient_amount" value="" title="How many servings that were had" required>
        <select name="units" class="units">
          <option value="grams">grams (g)</option>
          <option value="milligrams">milligrams (mg)</option>
          <option value="ounces">ounces (oz)</option>
          <option value="grams">pounds (lbs)</option>
        </select>
        <input type="submit" name="nutritional_info_submit" value="Add Info">
    </form>


  </div>
</body>

<footer>
  <p>Created by the Wuhan Clan for NIU CSCI466 Group Project &copy; 4/20/2020</p>
</footer>
</html>

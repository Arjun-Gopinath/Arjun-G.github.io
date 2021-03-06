<!DOCTYPE HTML>  
<html>
<head>
<title>DC Universe</title>
<style>
.center {
    margin: auto;
    width: auto;
    border: 3px solid white;
    padding: 1% 10% 1% 40%;
}

.center1{
	height: auto;
    width: auto;
	display:block;
}
.error {color: #FF0000;}



</style>
</head>
<body style="background-color:#000000;color:white">  

<?php
// define variables and set to empty values
$nameErr = $emailErr = $genderErr = $phoneErr = $fanErr = "";
$name = $email = $gender = $address = $phone = $fan = $request = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $nameErr = "Only letters and white space allowed"; 
    }
  }
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    
	// check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
	{
      $emailErr = "Invalid email format"; 
    }
  }
    
  if (empty($_POST["phone"])) {
    $phoneErr = "Phone no. is required";
  } else {
    $phone = test_input($_POST["phone"]);
	
    // check if phone not contains letters and whitespace
    if (preg_match("/^[a-zA-Z ]*$/",$phone)) {
      $nameErr = "Letters and white space not allowed"; 
    }
  }

  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }

  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }
  
  if (empty($_POST["fan"])) {
    $fanErr = "Specify how fanatic your are";
  } else {
    $fan = test_input($_POST["fan"]);
  }
  
  if (empty($_POST["comment"])) {
    $comment = "";
  } else {
    $comment = test_input($_POST["comment"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>


<h1 align="center">DC Fan Page</h1>

<div class="center1">
	<img src="dcpic.jpg" alt="dc">
</div>

<div class="center">

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <input type="text" name="name" value="<?php echo $name;?>" placeholder="Full Name">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  <input type="text" name="email" value="<?php echo $email;?>" placeholder="E-mail">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>
  <input type="text" name="phone" value="<?php echo $phone;?>" placeholder="Phone no.">
  <span class="error">* <?php echo $phoneErr;?></span>
  <br><br>
  <textarea name="address" rows="5" cols="40" placeholder="Addresss"><?php echo $address;?></textarea>
  <br><br>
  <b>Gender:</b>
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="other") echo "checked";?> value="other">Other  
  <span class="error">* <?php echo $genderErr;?></span>
  <br><br>
  <b>How fanatic are you?:</b>
  <input type="radio" name="fan" <?php if (isset($help) && $help=="wfh") echo "checked";?> value="wfh">Very
  <input type="radio" name="fan" <?php if (isset($help) && $help=="phy") echo "checked";?> value="phy">Not much
  <span class="error">* <?php echo $fanErr;?></span>
  <br><br>
  <input type="submit" name="submit" value="Submit">  
</form>
</div>

<?php
$servername = "localhost";
$username = "root";
$password = "";
if (empty($_POST["name"])) {
    $nameErr = "Name is required";
  } else {

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Create database
$sql = "CREATE DATABASE abcd";
if ($conn->query($sql) === TRUE) {
  //  echo "Database created successfully";	
	$dbname1 = "abcd";
} else {
  //  echo "Error creating database: " . $conn->error;
}
  
$conn->close();

$dbname="abcd";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


// sql to create table
$sql = "CREATE TABLE vol (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
fullname VARCHAR(30) NOT NULL,
phone VARCHAR(30) NOT NULL,
email VARCHAR(50) NOT NULL,
address VARCHAR(50),
gender VARCHAR(50),
fan VARCHAR(50),
reg_date TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
  //  echo "Table vol created successfully";
} else {
  //  echo "Error creating table: " . $conn->error;
}


$stmt = $conn->prepare("INSERT INTO vol (fullname, phone, email, address, gender, fan) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $firstname, $phone1, $email1, $address1, $gender1, $fan1);

// set parameters and execute
$firstname = $name;
$phone1 = $phone;
$email1 = $email;
$address1 = $_POST['address'];
$gender1 = $gender;
$fan1 = $fan;
$stmt->execute();


//echo "New records created successfully";

$stmt->close();

$conn->close();

$cookie_name = "user";
$cookie_value = "1";
setcookie($cookie_name, $cookie_value, time() + 20, "/"); 
header("Location: data.php");
}
?>

</body>
</html>
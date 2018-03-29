<?php

var_dump($_POST);

/**
 * Define variables and set to empty values
 * Define error variables and set to empty values
 */

$firstName = $lastName = $email = $phoneNumber = $message = "";
$firstNameErr = $lastNameErr = $emailErr = $phoneNumberErr = $messageErr = "";

/**
 *
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstName = test_input($_POST["firstName"]);
  $lastName = test_input($_POST["lastName"]);
  $email = test_input($_POST["email"]);
  $phoneNumber = test_input($_POST["phoneNumber"]);
  $message = test_input($_POST["message"]);
}

/**
 * Remove unnecessary characters
 */

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

/**
 * Error messages for empty fields and form validation
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["firstName"])) {
    $firstNameErr = "First name is required";
  } else {
    $firstName = test_input($_POST["firstName"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
        $firstNameErr = "Please insert letters and white space";
      }
  }

  if (empty($_POST["lastName"])) {
    $lastNameErr = "Last name is required";
  } else {
    $lastName = test_input($_POST["lastName"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
        $lastNameErr = "Please insert letters and white space";
      }
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Please insert a valid email address";
      }
  }

  if (empty($_POST["phoneNumber"])) {
    $phoneNumber= "";
  } else {
    $phoneNumber = test_input($_POST["phoneNumber"]);
    if (!is_numeric($phoneNumber)) {
        $phoneNumberErr = "Please insert a valid number";
      }
  }

  if (empty($_POST["message"])) {
    $messageErr = "Message is required";
  } else {
    $message = test_input($_POST["message"]);
  }

}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<section id="contact" class="contact p-4">

<div class="container">

    <h2 class="mb-4">CONTACT ME</h2>
    <span class="error">* required field.</span>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputFirstname">First name <span class="error">* <?php echo $firstNameErr;?></span></label>
                <input type="text" class="form-control" name="firstName" id="inputFirstname">
            </div>
            <div class="form-group col-md-6">
                <label for="inputLastname">Last name <span class="error">* <?php echo $lastNameErr;?></span></label>
                <input type="text" class="form-control" name="lastName" id="inputLastname">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputEmail">Email <span class="error">* <?php echo $emailErr;?></span></label>
                <input type="email" class="form-control" name="email" id="inputEmail">
            </div>
                <div class="form-group col-md-6">
                <label for="inputPhone">Phone</label>
                <input type="tel" class="form-control" name="phoneNumber" id="inputPhone" placeholder="+31 67 777 7777">
            </div>
        </div>
        <div class="form-group">
            <label for="inputMessage">Message <span class="error">* <?php echo $messageErr;?></span></label>
            <textarea class="form-control" rows="5" name="message" id="inputMessage" placeholder="What's up?"></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit">Send message  <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
    </form>
</div>
</section>

</body>
</html>

<?php
include_once "env.php";
ini_set('display_errors', 'On');
error_reporting(E_ALL);
/**
 * Initialization
 */
$dbh = new PDO(
    'mysql:host='.HOST.';dbname='.DBNAME, USERNAME, PASSWORD
);

/**
 * Define variables and set to empty values
 * Define error variables and set to empty values
 */

$firstName = $lastName = $email = $phoneNumber = $message = "";
$firstNameErr = $lastNameErr = $emailErr = $phoneNumberErr = $messageErr = "";


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
  if (empty($_POST["first_name"])) {
    $firstNameErr = "First name is required";
  } else {
    $firstName = test_input($_POST["first_name"]);
    if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
        $firstNameErr = "Please insert letters and white space";
      }
  }

  if (empty($_POST["last_name"])) {
    $lastNameErr = "Last name is required";
  } else {
    $lastName = test_input($_POST["last_name"]);
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

  if (empty($_POST["phone"])) {
    $phoneNumber= "";
  } else {
    $phoneNumber = test_input($_POST["phone"]);
    if (!filter_var($phoneNumber, FILTER_VALIDATE_INT)) {
        $phoneNumberErr = "Please insert a valid number";
      }
  }

  if (empty($_POST["message"])) {
    $messageErr = "Message is required";
  } else {
    $message = test_input($_POST["message"]);
  }

  /**
   * Send input fields to mysql server in case fields are filled in
   */

  if ($firstName == " " || $lastName == " " || $email == " " || $message == " ")
     {
        header('Location: ?success=no');
    } else {
        $statement = $dbh->prepare('INSERT INTO messages (`first_name`, `last_name`, `email`, `phone`, `message`) VALUES (?,?,?,?,?');
        $result = $statement->execute([$firstName, $lastName, $email, $phoneNumber, $message]);
        var_dump($result);

        header('Location: ?success=yes');
    }
}

/**
 * Template for outcome 'success'
 */
$success = filter_input(INPUT_GET, 'success');

//var_dump($_POST);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mireille Bobbert Portfolio</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    <a class="sr-only sr-only-focusable" href="#content">Skip to main content</a>

    <?php if ($success =='no') echo '<p style="color: red">We were unable to send your message.</p>'; ?>
    <?php if ($success =='yes') echo '<p style="color: green">Your message was succesfully sent.</p>'; ?>

    <nav class="navbar navbar-expand-lg navbar-light">
        <!--<a class="navbar-brand" href="#">Navbar</a>-->
        <a href="index.html">
            <img src="img/mb-logo-99.png" width="30" height="30" alt="My portfolio">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="container">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item header-home">
                        <a class="nav-link" href="#home">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item header-skills">
                        <a class="nav-link" href="#skills">Skills</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about-me">About me</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="home">
        <div class="jumbotron jumbotron-fluid">

            <div class="container">
                <p>
                    <h1>Hi, I'm <strong class="name">Mireille Bobbert</strong></h1>

                    <h2>I'm a full-stack developer</h2>
                </p>
            </div>
        </div>

    </section>



    <div class="work-together row d-flex justify-content-center align-items-center m-1">
        <div class="container">
            <p>
                Let's work together to <strong>create amazing products</strong>. I work with my clients from the idea stage until the <strong>fully functioning
                web application</strong>.
            </p>
        </div>
    </div>

    <section id="process" class="process p-4">

        <div class="container">

            <h1 class="sr-only"></h1>

                <div  class="row">
                    <div class="col-sm-6 col-md">
                        <h2>Discover</h2>
                        <i class="fa fa-comments fa-3x" aria-hidden="true"></i>
                            <p>Tell me about your project and we brainstorm together the features to create a plan for your product to launch.</p>
                    </div>
                    <div class="col-sm-6 col-md">
                        <h2>Design</h2>
                        <i class="fa fa-pencil fa-3x" aria-hidden="true"></i>
                            <p>We design the wireframe and agree together how to create the best experience for your users to present your brand.</p>
                    </div>
                    <div class="col-sm-6 col-md">
                        <h2>Deploy </h2>
                        <i class="fa fa-code fa-3x" aria-hidden="true"></i>
                            <p>We protoype and develop your product. We work together intensily to incorporate your feedback.</p>
                    </div>
                    <div class="col-sm-6 col-md">
                        <h2>Be ready</h2>
                        <i class="fa fa-line-chart fa-3x" aria-hidden="true"></i>
                            <p>We deploy your product and now your website is ready to get the traction. Get out there and grow your audience.</p>
                    </div>
                </div>
        </div>

    </section>

    <section id="skills" class="skills p-4">

        <h1 class="sr-only"></h1>

        <h2 class="mb-4">MY SKILLS</h2>

        <div class="container">
            <div id="progress-evolution">

                <div class="progress">
                    <div class="progress-bar"  id="bar-HTML" role="progressbar">
                    <!--<div class="progress-bar"  id="bar-Javascript" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">-->
                        <span class="sr-only">progress HTML</span>
                    </div>
                    <span class="progress-type">HTML</span>
                    <span class="progress-completed">80%</span>
                </div>

                <br/>

                <div class="progress">
                    <div class="progress-bar"  id="bar-CSS" role="progressbar">
                    <!--<div class="progress-bar"  id="bar-Javascript" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">-->
                        <span class="sr-only">progress CSS</span>
                    </div>
                    <span class="progress-type">CSS / Sass</span>
                    <span class="progress-completed">80%</span>
                </div>

                <br/>

                <div class="progress">
                    <div class="progress-bar"  id="bar-Javascript" role="progressbar">
                    <!--<div class="progress-bar"  id="bar-Javascript" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">-->
                        <span class="sr-only">progress Javascript</span>
                    </div>
                    <span class="progress-type">Javascript</span>
                    <span class="progress-completed">75%</span>
                </div>

                <br/>

                <div class="progress">
                    <div class="progress-bar"  id="bar-jQuery" role="progressbar">
                    <!--<div class="progress-bar"  id="bar-jQuery" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">-->
                        <span class="sr-only">progress jQuery</span>
                    </div>
                    <span class="progress-type">jQuery</span>
                    <span class="progress-completed">75%</span>
                </div>

                <br/>

                <div class="progress">
                    <div class="progress-bar"  id="bar-PHP" role="progressbar">
                    <!--<div class="progress-bar"  id="bar-Javascript" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">-->
                        <span class="sr-only">progress PHP</span>
                    </div>
                    <span class="progress-type">PHP</span>
                    <span class="progress-completed">80%</span>
                </div>

                <br/>

                <div class="progress">
                    <div class="progress-bar"  id="bar-React" role="progressbar">
                    <!--<div class="progress-bar"  id="bar-React" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">-->
                        <span class="sr-only">progress React</span>
                    </div>
                    <span class="progress-type">React</span>
                    <span class="progress-completed">75%</span>
                </div>

                <br/>

                <div class="progress">
                    <div class="progress-bar"  id="bar-Laravel" role="progressbar">
                    <!--<div class="progress-bar"  id="bar-Javascript" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">-->
                        <span class="sr-only">progress Laravel</span>
                    </div>
                    <span class="progress-type">Laravel</span>
                    <span class="progress-completed">80%</span>
                </div>

                <br/>

                <div class="progress">
                    <div class="progress-bar"  id="bar-UX" role="progressbar">
                    <!--<div class="progress-bar"  id="bar-Javascript" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">-->
                        <span class="sr-only">progress UX</span>
                    </div>
                    <span class="progress-type">UX</span>
                    <span class="progress-completed">80%</span>
                </div>

            </div>
        </div>

    </section>

    <section id="portfolio" class="portfolio p-4">

        <h2 class="mb-4">MY PORTFOLIO</h2>

        <div class="container">

            <div class="row">

                <div class="col-sm-6 col-md-4 my-portfolio-item">
                    <article class="card mb-4">
                    <img class="card-img-top" src="img/counter.jpg" alt="Hipster Coffee">
                    <div class="card-body">
                        <h3 class="card-title">Generic Hipster Coffee</h3>
                        <p class="card-text">A fully-functional 5-page website for Generic Hipster Coffee. Part of a Bootstrap hackathon.</p>
                        <h4>Tech Stack:</h4>
                            <ul class="list-unstyled">
                                <li class="badge badge-secondary">HTML</li>
                                <li class="badge badge-secondary">CSS</li>
                                <li class="badge badge-secondary">Sass</li>
                                <li class="badge badge-secondary">Gulp</li>
                                <li class="badge badge-secondary">Bootstrap</li>
                            </ul>
                            <button type="button" class="btn btn-primary btn-lg btn-block"><a href="http://generic-hipster-coffee.mireilleb.data4you.cz/homepage.html">Check the menu</a></button>
                    </div>
                    </article>
                </div>

                <div class="col-sm-6 col-md-4 my-portfolio-item">
                    <article class="card mb-4">
                        <img class="card-img-top" src="img/drench.png" alt="Drench Board Game">
                        <div class="card-body">
                            <h3 class="card-title">Drench board game</h3>
                            <p>An addictive board game challenging you to drench the board one color within 30 trials.</p>
                            <h4>Tech Stack:</h4>
                            <ul class="list-unstyled">
                                <li class="badge badge-secondary">HTML</li>
                                <li class="badge badge-secondary">CSS</li>
                                <li class="badge badge-secondary">Javascript</li>
                                <li class="badge badge-secondary">jQuery</li>
                            </ul>
                            <button type="button" class="btn btn-primary btn-lg btn-block"><a href="http://mireilleb.data4you.cz/drench/dist/drench.html">Play</a></button>
                        </div>
                    </article>
                </div>

                <div class="col-sm-6 col-md-4 my-portfolio-item">
                    <article class="card mb-4">
                    <img class="card-img-top" src="img/cine-booking.png" alt="cinema booking system">
                        <div class="card-body">
                            <h3 class="card-title">Cine Booking System</h3>
                            <p>A cinema booking system for cinema personnel. Part of a PHP hackathon.</p>
                            <h4>Tech Stack:</h4>
                            <ul class="list-unstyled">
                                <li class="badge badge-secondary">PHP</li>
                                <li class="badge badge-secondary">SQL</li>
                            </ul>
                            <button type="button" class="btn btn-primary btn-lg btn-block"><a href="http://mireilleb.data4you.cz/cinema-booking/dist/">Book seat</a></button>
                        </div>
                    </article>
                </div>

                <div class="col-sm-6 col-md-4 my-portfolio-item">
                    <article class="card mb-4">
                    <img class="card-img-top" src="img/laravelle.png" alt="la ravelle">
                        <div class="card-body">
                            <h3 class="card-title">Final project</h3>
                            <p>La Ravelle aggregates beauty product ratings, cutting the decision time for career women to purchase a face serum.</p>
                            <h4>Tech Stack:</h4>
                            <ul class="list-unstyled">
                                <li class="badge badge-secondary">PHP</li>
                                <li class="badge badge-secondary">Laravel</li>
                            </ul>
                            <button type="button" class="btn btn-primary btn-lg btn-block"><a href="http://beauty-review-aggregator.data4you.cz/home">View website</a></button>
                        </div>
                    </article>
                </div>

            </div>
        </div>

    </section>

    <section id="about-me" class="about-me p-4">

        <h2>ABOUT ME</h2>

        <div class="container">
            <div class="row d-flex flex-row justify-content-center align-items-center">
                <div class="col-md-6 image p-2 d-flex justify-content-center">
                    <img src="img/mireille_profile.jpg" alt="Mireille Bobbert" class="rounded-circle py-50">
                </div>

                <div class="col-md-6 text p-2 align-items-center">
                    <p>
                        Since launching <a href="https://youtu.be/XKTLbsNpTA0" target="_blank" >Whever</a> - a location based app that tells you when your friends will arrive - I'be been fascinated with web and mobile apps. Despite the fact that the iOS app was a <a href="http://www.mireillebobbert.com/2017/11/23/lessons-whever/" target="_blank" >complete failure</a>, my interest in coding and launching new things has only grown.
                    </p>
                    <p>
                        In my spare time, I enjoy <a href="http://www.mireillebobbert.com" target="_blank">blogging about digital products and experiences</a>, running, and garage saling.
                    </p>
                </div>
            </div>
        </div>

    </section>

    <section id="find-me" class="find-me p-4">

        <h2>FIND ME HERE</h2>
        <div class="find-me">
            <div class="row d-flex justify-content-around">
                <div class="col d-flex justify-content-around">
                    <p>
                        <a href="https://github.com/mbobbert" target="_blank"><i class="fa fa-github fa-4x" aria-hidden="true"></i></a>
                    </p>
                </div>
                <div class="col d-flex justify-content-around">
                    <p>
                        <a href="http://www.linkedin.com/in/mireillebobbert" target="_blank"><i class="fa fa-linkedin fa-4x" aria-hidden="true"></i></a>
                    </p>
                </div>
                <div class="col d-flex justify-content-around">
                    <p>
                        <a href="http://www.mireillebobbert.com" target="_blank"><i class="fa fa-wordpress fa-4x" aria-hidden="true"></i></a>
                    </p>
                </div>
            </div>
        </div>

    </section>

    <section id="contact" class="contact p-4">

    <div class="container">

        <h2 class="mb-4">CONTACT ME</h2>


        <form method="post" action="">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputFirstname">First name <span class="error">* <?php echo $firstNameErr;?></span></label>
                    <input type="text" class="form-control" name="first_name" id="inputFirstname">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputLastname">Last name <span class="error">* <?php echo $lastNameErr;?></span></label>
                    <input type="text" class="form-control" name="last_name" id="inputLastname">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail">Email <span class="error">* <?php echo $emailErr;?></span></label>
                    <input type="email" class="form-control" name="email" id="inputEmail">
                </div>
                    <div class="form-group col-md-6">
                    <label for="inputPhone">Phone</label>
                    <input type="tel" class="form-control" name="phone" id="inputPhone" placeholder="+31 67 777 7777">
                </div>
            </div>
            <div class="form-group">
                <label for="inputMessage">Message <span class="error">* <?php echo $messageErr;?></span></label>
                <textarea class="form-control" rows="5" name="message" id="inputMessage" placeholder="What's up?"></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block" name="submit">Send message  <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
        </form>
        <span class="required">* required field.</span>
    </div>
    </section>

    <section id="hello" class="hello p-4">

        <h2>NICE TO MEET YOU!</h2>
        <div class="find-me">
            <div class="row d-flex justify-content-around align-items-center">
                <div class="col d-flex justify-content-around">
                    <p>
                        <a href="https://github.com/mbobbert" target="_blank"><i class="fa fa-github fa-2x" aria-hidden="true"></i></a>
                    </p>
                </div>
                <div class="col d-flex justify-content-around">
                    <p>
                        <a href="http://www.linkedin.com/in/mireillebobbert" target="_blank"><i class="fa fa-linkedin fa-2x" aria-hidden="true"></i></a>
                    </p>
                </div>
                <div class="col d-flex justify-content-around">
                    <p>
                        <a href="http://www.mireillebobbert.com" target="_blank"><i class="fa fa-wordpress fa-2x" aria-hidden="true"></i></a>
                    </p>
                </div>
            </div>
        </div>


    </section>

    <footer>
        <div class="copyright">
            <p>
                Copyright Mireille Bobbert 2018
            </p>
        </div>

    </footer>


    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery.appear.js"></script>
    <script src="js/main.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
</body>

</html>
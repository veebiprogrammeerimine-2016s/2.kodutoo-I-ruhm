<?php

// Võtab ja kopeerib faili sisu
    require ("functions.php");

// Kas kasutaja on sisse logitud
    if(isset($_SESSION["userID"])) {

        header("Location: data.php");
        exit();

}

    $signupEmailError = "";
    $signupPasswordError = "";
    $signupPhoneError = "";
    $signupSuguError = "";
    $signupEmail = "";
    $error = "";
    $loginSalvestatudEmail = "";

//***********
//***SIGNUP**
//***********


// Kas epost oli olemas
    if ( isset($_POST["signupEmail"]) ) {

      if ( empty($_POST["signupEmail"]) ) {

//oli email, kuid tühi
        $signupEmailError = "See väli on kohustuslik";

      } else {
//email on, salvestan väärtuse muutujasse
        $signupEmail = $_POST["signupEmail"];

      }

  }
// Kas parool oli olemas
    if ( isset($_POST["signupPassword"]) ) {

      if ( empty($_POST["signupPassword"]) ) {

        $signupPasswordError = "See väli on kohustuslik";

      } else {

//tean et parool ja ei olnud tühi

          if ( strlen($_POST["signupPassword"]) < 8 )

            $signupPasswordError = "Parool peab olema vähemalt 8 tähemärki";

      }

  }

// Kas telefon oli olemas
    if ( isset($_POST["signupPhone"]) ) {

      if ( empty($_POST["signupPhone"]) ) {

//Telefoni kontroll
        $signupPhoneError = "See väli on kohustuslik";

      }

    }

// Kas sugu on valitud
$gender = "male";

if ( isset ( $_POST["gender"] ) ) {
    if ( empty ( $_POST["gender"] ) ) {
        $signupSuguError = "See väli on kohustuslik!";
    } else {
        $gender = $_POST["gender"];
    }
}

//Kus tean et ühtegi viga ei olnud ja saan kasutaja andmed salvestada
    if ( empty($signupEmailError) &&
        empty($signupPasswordError) &&
        isset($_POST["signupPassword"]) &&
        isset($_POST["signupEmail"])) {

        echo "salvestan...<br>";
        echo "email " . $signupEmail . "<br>";

        $password = hash("sha512", $_POST["signupPassword"]);

        echo "parool " . $_POST["signupPassword"] . "<br>";
        echo "räsi " . $password . "<br>";

        $signupEmail = cleanInput($signupEmail);
        $password = cleanInput($password);
        signup($signupEmail, $password);

    }

//*********
//**LOGIN**
//*********

//kontrollin et kasutaja täitis väljad ja võib sisselogida
    if (isset($_POST["loginEmail"]) &&
        isset($_POST["loginPassword"]) &&
        !empty($_POST["loginPassword"]) &&
        !empty($_POST["loginEmail"])
        ){
//Salvestan emaili muutujasse
        $loginSalvestatudEmail = $_POST["loginEmail"];

//login sisse + cleanInput
        $_POST["loginEmail"] = cleanInput($_POST["loginEmail"]);
        $_POST["loginPassword"] = cleanInput($_POST["loginPassword"]);

        $error = login($_POST["loginEmail"], $_POST["loginPassword"]);

    }

?>

<!-- HTML Algus   -->

<!DOCTYPE html>
<html>
  <head>
      <title>Sisselogmise lehekülg</title>
    </head>
<body>

<!-- LOGIN FORM   -->


  <h1>Logi sisse</h1>

  <form method="POST">
      <p style="color:red"><?=$error;?></p>

    <label>E-post</label><br>
    <input name="loginEmail" type="email" placeholder="Sisestage e-mail" value="<?=$loginSalvestatudEmail; ?>">
    <br>
    <label>Parool</label><br>
    <input name="loginPassword" type="password" placeholder="Sisestage parool">
    <br><br>
    <input type="submit" value="Logis sisse">

  </form>

<!-- SIGNUP FORM   -->

  <h1>Loo kasutaja</h1>
  <form method="POST">

    <label>E-post</label><br>
    <input name="signupEmail" type="email" placeholder="Sisestage e-mail" value="<?=$signupEmail; ?>"> <?php echo $signupEmailError; ?>
    <br>
    <label>Parool</label><br>
    <input name="signupPassword" type="password" placeholder="Sisestage parool"> <?php echo $signupPasswordError; ?>
    <br>
    <label>Telefon</label><br>
    <input name="signupPhone" type="number" placeholder="Sisestage telefon"> <?php echo $signupPhoneError; ?>
    <br>
    <label>Sugu</label><br>
      <?php if($gender == "male") { ?>
          <input type="radio" name="gender" value="male" checked> Mees<br>
      <?php } else { ?>
          <input type="radio" name="gender" value="male" > Mees<br>
      <?php } ?>

      <?php if($gender == "female") { ?>
          <input type="radio" name="gender" value="female" checked> Naine<br>
      <?php } else { ?>
          <input type="radio" name="gender" value="female" > Naine<br>
      <?php } ?>

      <?php if($gender == "other") { ?>
          <input type="radio" name="gender" value="other" checked> Muu<br>
      <?php } else { ?>
          <input type="radio" name="gender" value="other" > Muu<br>
      <?php } ?>
    <br>
    <input type="submit" value="Loo kasutaja">

  </form>
  <p>
    Ülikooli kursuse tarbeks tunniplaan, kus kirjas kodused tööd, tunnikontrollid ja eksamid.

  </p>


</body>
</html>

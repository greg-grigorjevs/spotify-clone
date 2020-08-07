<?php
    include("includes/classes/Account.php");
    $account = new Account();

    include("includes/handlers/register-handler.php");

?>

<!DOCTYPE html>
<html>

<head>
  <title>Welcome to Slotify</title>
</head>

<body>
  <div id="inputContainer">
    <form action="register.php" method="POST" id="loginForm">
      <h2>Login to your account</h2>
      <p>
        <label for="loginUsername">Username: </label>
        <input type="text" id="loginUsername" name="loginUsername" placeholder="e.g. rickSanchez" required>
      </p>
      <p>
        <label for="loginPassword">Password:</label>
        <input type="password" id="loginPassword" name="loginPassword" placeholder="e.g. Sanchez123" required>
      </p>

      <button type="submit" name="loginButton">LOG IN</button>
    </form>

    <!-- Register form -->
    <form action="register.php" method="POST" id="registerForm">
      <h2>Create your free account</h2>
      <p>
        <label for="registerUsername">Username: </label>
        <input type="text" id="registerUsername" name="registerUsername" placeholder="e.g. rickSanchez" required>
      </p>
      <p>
        <label for="firstName">First Name: </label>
        <input type="text" id="firstName" name="firstName" placeholder="e.g. Rick" required>
      </p>
      <p>
        <label for="lastName">Last Name: </label>
        <input type="text" id="lastName" name="lastName" placeholder="e.g. Sanchez" required>
      </p>
      <p>
        <label for="email">Email: </label>
        <input type="email" id="email" name="email" placeholder="e.g. rick@gmail.com" required>
      </p>
      <p>
        <label for="email2">Confirm Email: </label>
        <input type="email" id="email2" name="email2" required>
      </p>
      <p>
        <label for="registerPassword">Password:</label>
        <input type="password" id="registerPassword" name="registerPassword" placeholder="e.g. stupidMorty123" required>
      </p>
      <p>
        <label for="registerPassword2">Confirm Password: </label>
        <input type="text" id="registerPassword2" name="registerPassword2" required>
      </p>

      <button type="submit" name="registerButton">Register</button>
    </form>
  </div>
</body>

</html>
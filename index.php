<?php

session_start();

$errors = [
  'login' => $_SESSION['login_error'] ?? '',
  'register' => $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset();

function showError($error)
{
  return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm)
{
  return $formName === $activeForm ? 'active' : '';
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login & Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="container <?= isActiveForm('register', $activeForm) ? 'show-register' : '' ?>" id="authContainer">

    <div class="overlay-panel">
      <div class="blob"></div>
      <div class="blob blob2"></div>
      <div id="overlayContent"></div>
    </div>

    <div class="forms-wrap">

      <!-- LOGIN FORM -->
      <div class="form-box login-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
        <form action="login_register.php" method="post">
          <h1>Login</h1>
          <?= showError($errors['login']); ?>
          <p class="subtitle">Sign in to your account</p>
          <div class="input-group">
            <input type="email" name="email" placeholder="Email" required />
          </div>
          <div class="input-group">
            <input type="password" name="password" placeholder="Password" required />
          </div>
          <div class="forgot"><a href="#">Forgot password?</a></div>
          <button type="submit" name="login" class="btn-primary">Login</button>
          <div class="divider">or login with social platforms</div>
          <div class="socials">
            <button type="button" class="social-btn" title="Google">
              <svg viewBox="0 0 24 24">
                <path
                  d="M21.805 10.023H12v3.977h5.618c-.242 1.242-1 2.305-2.132 3.013v2.505h3.453c2.02-1.86 3.186-4.6 3.186-7.855 0-.527-.047-1.04-.132-1.54h-.188z"
                  fill="#4285F4" />
                <path
                  d="M12 22c2.7 0 4.964-.896 6.618-2.43l-3.453-2.504c-.896.6-2.042.955-3.165.955-2.433 0-4.493-1.644-5.23-3.853H3.197v2.587C4.843 19.857 8.18 22 12 22z"
                  fill="#34A853" />
                <path
                  d="M6.77 14.168A5.9 5.9 0 016.41 12c0-.75.13-1.477.36-2.168V7.245H3.197A9.982 9.982 0 002 12c0 1.617.387 3.145 1.197 4.755l3.573-2.587z"
                  fill="#FBBC05" />
                <path
                  d="M12 6.136c1.37 0 2.6.47 3.567 1.394l2.67-2.67C16.96 3.29 14.698 2 12 2 8.18 2 4.843 4.143 3.197 7.245l3.573 2.587C7.507 7.78 9.567 6.136 12 6.136z"
                  fill="#EA4335" />
              </svg>
            </button>
            <button type="button" class="social-btn" title="Facebook">
              <svg viewBox="0 0 24 24" fill="#1877F2">
                <path
                  d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.885v2.27h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z" />
              </svg>
            </button>
          </div>
        </form>
      </div>

      <!-- REGISTER FORM -->
      <div class="form-box register-box <?= isActiveForm('register', $activeForm); ?>" id="register-form">
        <form action="login_register.php" method="post">
          <h1>Registration</h1>
          <?= showError($errors['register']); ?>
          <p class="subtitle">Create your account</p>
          <div class="input-group">
            <input type="text" name="name" placeholder="Username" required />
          </div>
          <div class="input-group">
            <input type="email" name="email" placeholder="Email" required />
          </div>
          <div class="input-group">
            <input type="password" name="password" placeholder="Password" required />
          </div>
          <div class="input-group">
            <select name="role" required>
              <option value="">-- Select Role --</option>
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          <button type="submit" name="register" class="btn-primary">Register</button>
          <div class="divider">or register with social platforms</div>
          <div class="socials">
            <button type="button" class="social-btn" title="Google">
              <svg viewBox="0 0 24 24">
                <path
                  d="M21.805 10.023H12v3.977h5.618c-.242 1.242-1 2.305-2.132 3.013v2.505h3.453c2.02-1.86 3.186-4.6 3.186-7.855 0-.527-.047-1.04-.132-1.54h-.188z"
                  fill="#4285F4" />
                <path
                  d="M12 22c2.7 0 4.964-.896 6.618-2.43l-3.453-2.504c-.896.6-2.042.955-3.165.955-2.433 0-4.493-1.644-5.23-3.853H3.197v2.587C4.843 19.857 8.18 22 12 22z"
                  fill="#34A853" />
                <path
                  d="M6.77 14.168A5.9 5.9 0 016.41 12c0-.75.13-1.477.36-2.168V7.245H3.197A9.982 9.982 0 002 12c0 1.617.387 3.145 1.197 4.755l3.573-2.587z"
                  fill="#FBBC05" />
                <path
                  d="M12 6.136c1.37 0 2.6.47 3.567 1.394l2.67-2.67C16.96 3.29 14.698 2 12 2 8.18 2 4.843 4.143 3.197 7.245l3.573 2.587C7.507 7.78 9.567 6.136 12 6.136z"
                  fill="#EA4335" />
              </svg>
            </button>
            <button type="button" class="social-btn" title="Facebook">
              <svg viewBox="0 0 24 24" fill="#1877F2">
                <path
                  d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.885v2.27h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z" />
              </svg>
            </button>
          </div>
        </form>
      </div>

    </div>
  </div>
  <script src="script.js"></script>
</body>

</html>
 const container = document.getElementById('authContainer');
  const overlayContent = document.getElementById('overlayContent');

  function switchToRegister() {
    container.classList.add('show-register');
    overlayContent.innerHTML = `
      <h2>Welcome Back!</h2>
      <p>Already have an account?<br>Sign in to continue.</p>
      <button class="btn-ghost" onclick="switchToLogin()">Login</button>
    `;
  }

  function switchToLogin() {
    container.classList.remove('show-register');
    overlayContent.innerHTML = `
      <h2>Hello, Welcome!</h2>
      <p>Don't have an account?<br>Register to get started.</p>
      <button class="btn-ghost" onclick="switchToRegister()">Register</button>
    `;
  }

  overlayContent.innerHTML = `
    <h2>Hello, Welcome!</h2>
    <p>Don't have an account?<br>Register to get started.</p>
    <button class="btn-ghost" onclick="switchToRegister()">Register</button>
  `;
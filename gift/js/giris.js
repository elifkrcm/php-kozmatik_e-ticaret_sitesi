// Giriş Yap ve Kayıt Ol Formları arasında geçiş yapma
function showRegisterForm() {
  document.getElementById('login-form').classList.remove('active');
  document.getElementById('register-form').classList.add('active');
}

function showLoginForm() {
  document.getElementById('register-form').classList.remove('active');
  document.getElementById('login-form').classList.add('active');
}

// Basit Giriş Kontrolü
function login() {
  const email = document.getElementById('login-email').value;
  const password = document.getElementById('login-password').value;

  if (email === "" || password === "") {
    alert("Lütfen tüm alanları doldurun.");
  } else {
    alert(`Giriş başarılı!\nE-posta: ${email}`);
  }
}

// Basit Kayıt Kontrolü
function register() {
  const name = document.getElementById('register-name').value;
  const email = document.getElementById('register-email').value;
  const password = document.getElementById('register-password').value;

  if (name === "" || email === "" || password === "") {
    alert("Lütfen tüm alanları doldurun.");
  } else {
    alert(`Kayıt başarılı!\nAd: ${name}\nE-posta: ${email}`);
    showLoginForm();
  }
}

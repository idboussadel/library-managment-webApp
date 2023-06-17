const signupBtn = document.querySelector(".SignUp-btn");
const loginBtn = document.querySelector(".login-btn");
const errorText = document.querySelector(".error-text");

function eyetoggle() {
  const passwdText = document.querySelector(".passwd-input input");
  if (passwdText.type === "password") {
    document
      .querySelector(".eye-passwd[name='eye-off']")
      .classList.remove("close");
    document
      .querySelector(".eye-passwd[name='eye-outline']")
      .classList.add("close");
    passwdText.type = "text";
  } else {
    document
      .querySelector(".eye-passwd[name='eye-outline']")
      .classList.remove("close");
    document
      .querySelector(".eye-passwd[name='eye-off']")
      .classList.add("close");
    passwdText.type = "password";
  }
}

function checkInputsingUp(event) {
  event.preventDefault(); // Prevent the form from submitting
  const firstNameInput = document.querySelector(".first-name");
  const lastNameInput = document.querySelector(".last-name");
  const emailInput = document.querySelector(".email-text input");
  const addressInput = document.querySelector(".signUp .address-text input");
  const statutInput = document.querySelector(".statut select");
  const form = document.querySelector(".signUp form");
  const errorText = document.querySelector(".error-text");

  if (!firstNameInput.value || !lastNameInput.value || !addressInput.value || !statutInput.value || !emailInput.value) {
    errorText.classList.remove("success");
    errorText.classList.remove("close");
    errorText.textContent = "All input fields are required.";
    return;
  }

  // Send AJAX request to PHP script
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "signup.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = xhr.responseText;
      if (response === "success") {
        errorText.classList.add("success");
        errorText.classList.remove("close");
        errorText.textContent = "Vous êtes enregistré.";
        form.reset();
      } else {
        errorText.classList.remove("success");
        errorText.classList.remove("close");
        errorText.textContent = response;
      }
    }
  };
  const data =
    "first-name=" +
    encodeURIComponent(firstNameInput.value) +
    "&last-name=" +
    encodeURIComponent(lastNameInput.value) +
    "&address=" +
    encodeURIComponent(addressInput.value) +
    "&statut=" +
    encodeURIComponent(statutInput.value) +
    "&email=" +
    encodeURIComponent(emailInput.value);
  xhr.send(data);
}



function checkInputlogin(event) {
  event.preventDefault(); // Prevent the form from submitting
  const emailInput = document.querySelector(".login .email-input input");
  const passwdText = document.querySelector(".login .passwd-input input");
  const errorText = document.querySelector(".error-text");

  if (!emailInput.value || !passwdText.value) {
    errorText.classList.remove("close");
    errorText.textContent = "All inputs fields are required.";
    return;
  }
  // Send AJAX request to PHP script
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "login.php");
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = xhr.responseText;
      if (response === "admin") {
        window.location.href = "dashboardAdmin.html";
      } else {
        errorText.classList.remove("close");
        errorText.textContent = response;
      }
    } else {
      errorText.classList.remove("close");
      errorText.textContent = "Invalid email or password. Please try again.";
    }
  };
  const data =
    "email=" +
    encodeURIComponent(emailInput.value) +
    "&password=" +
    encodeURIComponent(passwdText.value);
  xhr.send(data);
}

document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const loginBtn = form.querySelector("a");

  loginBtn.addEventListener("click", function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    fetch("auth/login.php", {
      method: "POST",
      body: formData
    })
      .then(res => res.text())
      .then(data => {
        if (data === "success") {
          window.location.href = "index.html";
        } else {
          alert("Invalid email or password");
        }
      })
      .catch(() => {
        alert("Login failed");
      });
  });
});

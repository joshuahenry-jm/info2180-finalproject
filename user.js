document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("userForm");
  const messageDiv = document.getElementById("formMessage");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    try {
      const res = await fetch("add_user.php", {
        method: "POST",
        body: formData,
      });
      const data = await res.json();

      messageDiv.textContent = data.message;
      messageDiv.className = "message " + (data.success ? "success" : "error");

      if (data.success) form.reset();
    } catch (err) {
      messageDiv.textContent = "Something went wrong";
      messageDiv.className = "message error";
    }
  });
});

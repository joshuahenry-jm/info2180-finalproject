document.addEventListener("DOMContentLoaded", function () {
  const table = document.querySelector("table");

  fetch("users/get_users.php")
    .then(res => res.json())
    .then(users => {
      table.querySelectorAll("tr:not(:first-child)").forEach(r => r.remove());

      users.forEach(user => {
        const row = document.createElement("tr");

        row.innerHTML = `
          <td>${user.firstname} ${user.lastname}</td>
          <td>${user.email}</td>
          <td>${user.role}</td>
          <td>${user.created_at}</td>
        `;

        table.appendChild(row);
      });
    });
});

document.addEventListener("DOMContentLoaded", function () {
  const table = document.querySelector("table");
  const filterButtons = document.querySelectorAll(".dash-info-head button");

  function loadContacts(filter = "All") {
    fetch("contacts/get_contacts.php")
      .then(res => res.json())
      .then(data => {
        // Remove old rows
        table.querySelectorAll("tr:not(:first-child)").forEach(r => r.remove());

        data.forEach(contact => {
          if (
            filter !== "All" &&
            filter !== "Assigned" &&
            contact.type !== filter
          ) return;

          const row = document.createElement("tr");

          row.innerHTML = `
            <td>${contact.title || ""} ${contact.firstname} ${contact.lastname}</td>
            <td>${contact.email || ""}</td>
            <td>${contact.company || ""}</td>
            <td class="type">
              <strong class="${contact.type === "Support" ? "sup" : "sale"}">
                ${contact.type}
              </strong>
            </td>
            <td><a href="contact-d.html?id=${contact.id}">View</a></td>
          `;

          table.appendChild(row);
        });
      });
  }

  loadContacts();

  filterButtons.forEach(btn => {
    btn.addEventListener("click", function () {
      filterButtons.forEach(b => b.classList.remove("fil-on"));
      this.classList.add("fil-on");

      const text = this.textContent;
      if (text === "Sales Leads") loadContacts("Sales Lead");
      else if (text === "Support") loadContacts("Support");
      else loadContacts("All");
    });
  });
});

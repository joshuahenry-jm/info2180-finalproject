const form = document.getElementById("noteForm");
const notes = document.getElementById("notesContainer");

form.addEventListener("submit", async (e) => {
  e.preventDefault();

  const formData = new FormData(form);

  const res = await fetch("add_note.php", {
    method: "POST",
    body: formData,
  });

  const data = await res.json();

  if (!data.success) {
    alert("Failed to add note");
    return;
  }

  const note = document.createElement("div");
  note.className = "note";
  note.innerHTML = `
        <strong>${data.author}</strong>
        <p class="text">${data.comment.replace(/\n/g, "<br>")}</p>
        <p class="date">${data.date}</p>
    `;

  notes.prepend(note);
  form.reset();
});

const switchBtn = document.getElementById("switchTypeBtn");

if (switchBtn) {
  switchBtn.addEventListener("click", async () => {
    const contactId = switchBtn.dataset.id;

    const res = await fetch("switch_type.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `contact_id=${contactId}`,
    });

    const data = await res.json();

    if (!data.success) {
      alert("Failed to switch contact type");
      return;
    }
    switchBtn.dataset.type = data.newType;
    switchBtn.innerHTML = `
            <img src="assets/arrow.png" />
            Switch to ${data.newType === "Support" ? "Sales Lead" : "Support"}
        `;

    const typeBadge = document.querySelector(".type strong");
    if (typeBadge) {
      typeBadge.textContent = data.newType;
      typeBadge.className = data.newType === "Support" ? "sup" : "sale";
    }
  });
}

const assignBtn = document.getElementById("assignBtn");
const assignedTo = document.getElementById("assignedTo");

if (assignBtn) {
  assignBtn.addEventListener("click", async () => {
    const contactId = assignBtn.dataset.contact;

    const res = await fetch("assign_contact.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `contact_id=${contactId}`,
    });

    const data = await res.json();

    if (!data.success) {
      alert("Failed to assign contact");
      return;
    }

    assignedTo.textContent = data.name;

    assignBtn.disabled = true;
    assignBtn.innerHTML = `<img src="assets/hand.png" />Assigned`;
  });
}

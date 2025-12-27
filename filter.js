const rows = document.querySelectorAll("table tr[data-type]");

const buttons = document.querySelectorAll("ul.dash-info-head button");

document.getElementById("filter-all").addEventListener("click", () => {
    rows.forEach(row => row.style.display = "");
});

document.getElementById("filter-sales").addEventListener("click", () => {
    rows.forEach(row => {
        row.style.display = row.dataset.type === "Sales Lead" ? "" : "none";
    });
});

document.getElementById("filter-support").addEventListener("click", () => {
    rows.forEach(row => {
        row.style.display = row.dataset.type === "Support" ? "" : "none";
    });
});

document.getElementById("filter-assigned").addEventListener("click", () => {
    const myId = parseInt(document.querySelector("table").dataset.myId, 10);
    rows.forEach(row => {
        row.style.display = parseInt(row.dataset.assigned, 10) === myId ? "" : "none";
    });
});

buttons.forEach(btn => {
    btn.addEventListener("click", () => {
        buttons.forEach(b => b.classList.remove("fil-on"));
        btn.classList.add("fil-on");
    });
});

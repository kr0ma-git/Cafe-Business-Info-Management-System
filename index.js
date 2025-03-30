const adminBtn = document.getElementById("admin-button");
const adminCloseBtn = document.getElementById("admin-close-btn");
const adminPanel = document.getElementById("admin-panel");

adminBtn.style.display === "block"
    adminBtn.addEventListener("click", (e) => {
        adminBtn.style.display = "none";
        adminPanel.style.display = "block";
});

adminCloseBtn.addEventListener("click", (e) => {
    adminBtn.style.display = "block";
    adminPanel.style.display = "none";
});
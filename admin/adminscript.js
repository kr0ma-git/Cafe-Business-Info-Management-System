const btn = document.getElementById("btn");

if (document.getElementById("status").value === "disabled") {
    btn.style.backgroundColor = "red";
}

if (document.getElementById("status").value === "active") {
    btn.style.backgroundColor = "green";
}
const sidebar = document.getElementById("sidebar");
const arrow = document.getElementById("sidebarArrow");

arrow.addEventListener("click", () => {
    sidebar.classList.toggle("expanded");
    arrow.classList.toggle("expanded");
});

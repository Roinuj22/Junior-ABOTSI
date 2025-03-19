document.addEventListener("DOMContentLoaded", function () {
    const buttons = document.querySelectorAll("nav a");
    buttons.forEach(btn => {
        btn.addEventListener("mouseover", function () {
            btn.style.transform = "scale(1.1)";
        });
        btn.addEventListener("mouseout", function () {
            btn.style.transform = "scale(1)";
        });
    });

    const logout = document.querySelector(".logout-btn");
    logout.addEventListener("click", function () {
        if (!confirm("Voulez-vous vraiment vous déconnecter ?")) {
            event.preventDefault();
        }
    });
});
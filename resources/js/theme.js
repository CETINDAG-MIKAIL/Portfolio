const root = document.documentElement;
const toggle = document.querySelector(".theme-toggle");

function updateThemeButton() {
    const isLight = root.dataset.theme === "light";
    const label = `Activer le thème ${isLight ? "sombre" : "clair"}`;

    toggle.setAttribute("aria-label", label);
    toggle.title = label;
    toggle.querySelector(".theme-toggle-label").textContent = isLight
        ? "Sombre"
        : "Clair";
}

if (toggle) {
    updateThemeButton();

    toggle.addEventListener("click", () => {
        const theme = root.dataset.theme === "light" ? "dark" : "light";
        root.dataset.theme = theme;
        updateThemeButton();

        try {
            localStorage.setItem("portfolio-theme", theme);
        } catch {
            // Le bouton fonctionne aussi sans stockage local.
        }
    });
}

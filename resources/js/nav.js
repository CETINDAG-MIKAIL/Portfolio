// Met en évidence le lien du menu correspondant à la section visible,
// avec une pastille qui glisse d'un lien à l'autre.
const header = document.querySelector(".header");
const menu = document.querySelector(".header-center-menu");
const indicator = document.querySelector(".header-center-menu-indicator");

// L'accueil occupe la hauteur de l'écran restante sous le header.
if (header) {
    const updateHeaderHeight = () => {
        document.documentElement.style.setProperty(
            "--header-height",
            `${header.getBoundingClientRect().height}px`,
        );
    };

    updateHeaderHeight();
    new ResizeObserver(updateHeaderHeight).observe(header);
}

// Chaque lien "#id" est associé à la section qui porte cet id
const items = [...document.querySelectorAll(".header-center-menu-item-link")]
    .map((link) => ({
        link,
        section: document.getElementById(link.hash.slice(1)),
    }))
    .filter((item) => item.section);

let activeLink = null;

function moveIndicator(link) {
    indicator.style.width = `${link.offsetWidth}px`;
    indicator.style.height = `${link.offsetHeight}px`;
    indicator.style.transform = `translate(${link.offsetLeft}px, ${link.offsetTop}px)`;
}

function setActive(link) {
    if (link === activeLink) {
        return;
    }

    activeLink?.classList.remove("is-active");
    activeLink?.removeAttribute("aria-current");

    link.classList.add("is-active");
    link.setAttribute("aria-current", "location");

    activeLink = link;
    moveIndicator(link);
}

function update() {
    // Une section devient active quand son haut passe juste sous le header
    const line = header.offsetHeight + 48;

    let current = items[0];

    items.forEach((item) => {
        if (item.section.getBoundingClientRect().top <= line) {
            current = item;
        }
    });

    // En bas de page, la dernière section (souvent courte) doit être active
    const atBottom =
        window.innerHeight + window.scrollY >=
        document.documentElement.scrollHeight - 2;

    if (atBottom) {
        current = items[items.length - 1];
    }

    setActive(current.link);
}

if (header && menu && indicator && items.length > 0) {
    update();

    // Premier placement sans animation, puis on active les transitions
    indicator.getBoundingClientRect();
    menu.classList.add("is-ready");

    let ticking = false;

    window.addEventListener(
        "scroll",
        () => {
            if (ticking) {
                return;
            }

            ticking = true;

            requestAnimationFrame(() => {
                update();
                ticking = false;
            });
        },
        { passive: true },
    );

    // Le menu peut changer de taille (ou passer sur deux lignes sur mobile)
    window.addEventListener("resize", () => moveIndicator(activeLink));
}

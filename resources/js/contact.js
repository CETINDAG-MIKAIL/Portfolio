export function createContactMailto(recipient, name, email, message) {
    const subject = `Message de ${name.trim()} — Portfolio`;
    const body = `Nom : ${name.trim()}\nE-mail : ${email.trim()}\n\n${message.trim()}`;

    return `mailto:${recipient}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
}

const copyButton = document.querySelector("[data-copy-email]");
const copyStatus = document.querySelector("[data-copy-status]");
let copyReset;

copyButton?.addEventListener("click", async () => {
    try {
        await navigator.clipboard.writeText(copyButton.dataset.copyEmail);
        clearTimeout(copyReset);
        copyButton.classList.add("is-copied");
        copyButton.setAttribute("aria-label", "Adresse e-mail copiée");
        copyButton.title = "Adresse e-mail copiée";
        copyStatus.textContent = "Adresse e-mail copiée.";

        copyReset = setTimeout(() => {
            copyButton.classList.remove("is-copied");
            copyButton.setAttribute("aria-label", "Copier l'adresse e-mail");
            copyButton.title = "Copier l'adresse e-mail";
            copyStatus.textContent = "";
        }, 2500);
    } catch {
        copyStatus.textContent = "Vous pouvez sélectionner l'adresse e-mail pour la copier.";
    }
});

const form = document.querySelector("[data-contact-form]");

form?.addEventListener("submit", (event) => {
    event.preventDefault();

    if (!form.reportValidity()) {
        return;
    }

    const status = form.querySelector("[data-form-status]");
    const recipient = form.dataset.recipient;
    const data = new FormData(form);
    const name = data.get("name").trim();
    const email = data.get("email").trim();
    const message = data.get("message").trim();

    if (!name || !message) {
        status.textContent = "Merci de renseigner votre nom et votre message.";
        form.querySelector(!name ? "[name=name]" : "[name=message]").focus();
        return;
    }

    if (!recipient) {
        status.textContent = "L'adresse de contact est actuellement indisponible.";
        return;
    }

    window.location.href = createContactMailto(recipient, name, email, message);
    status.textContent = "Finalisez l'envoi dans votre messagerie. Si elle ne s'ouvre pas, utilisez l'adresse e-mail ci-contre.";
});

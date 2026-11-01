@props(['contact'])

<section class="contact" id="contact" aria-label="Contact">
    <div class="contact-layout">
        <div class="contact-panel">
            <h2 class="contact-panel-title">Contact direct</h2>
            <p class="contact-panel-description">
                Échangeons par e-mail ou sur les réseaux.
            </p>

            <div class="contact-email">
                <span class="contact-email-icon"><x-contact-icon name="email" /></span>
                <div class="contact-email-details">
                    <span class="contact-email-label">E-mail</span>
                    @if(!empty($contact['email']))
                        <a class="contact-email-value" href="mailto:{{ $contact['email'] }}">{{ $contact['email'] }}</a>
                    @else
                        <span class="contact-email-value">Adresse indisponible</span>
                    @endif
                </div>
                <button
                    class="contact-email-copy"
                    type="button"
                    data-copy-email="{{ $contact['email'] ?? '' }}"
                    aria-label="Copier l'adresse e-mail"
                    title="Copier l'adresse e-mail"
                    @disabled(empty($contact['email']))
                >
                    <x-contact-icon name="copy" class="contact-copy-icon" />
                    <x-contact-icon name="check" class="contact-check-icon" />
                </button>
            </div>

            <div class="contact-socials">
                @if(!empty($contact['github']))
                    <a class="contact-social" href="{{ $contact['github'] }}" target="_blank" rel="noopener noreferrer" aria-label="GitHub (nouvel onglet)">
                        <x-contact-icon name="github" />
                        <span>GitHub</span>
                        <x-contact-icon name="arrow" class="contact-social-arrow" />
                    </a>
                @endif
                @if(!empty($contact['linkedin']))
                    <a class="contact-social contact-social--linkedin" href="{{ $contact['linkedin'] }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn (nouvel onglet)">
                        <x-contact-icon name="linkedin" />
                        <span>LinkedIn</span>
                        <x-contact-icon name="arrow" class="contact-social-arrow" />
                    </a>
                @endif
            </div>
            <p class="contact-feedback" data-copy-status role="status"></p>
        </div>

        <form
            class="contact-form"
            action="{{ !empty($contact['email']) ? 'mailto:' . $contact['email'] : '' }}"
            method="post"
            enctype="text/plain"
            data-contact-form
            data-recipient="{{ $contact['email'] ?? '' }}"
            aria-label="Envoyer un message"
        >
            <div class="contact-form-grid">
                <div class="contact-field">
                    <label for="contact-name">Votre nom</label>
                    <input id="contact-name" name="name" type="text" placeholder="Jean Dupond" autocomplete="name" maxlength="100" required>
                </div>
                <div class="contact-field">
                    <label for="contact-email">Adresse e-mail</label>
                    <input id="contact-email" name="email" type="email" placeholder="JeanDupond@example.com" autocomplete="email" maxlength="254" required>
                </div>
            </div>

            <div class="contact-field contact-field--message">
                <label for="contact-message">Votre message</label>
                <textarea id="contact-message" name="message" rows="5" placeholder="Parlez-moi de votre projet ou de ce dont vous souhaitez discuter…" maxlength="5000" required></textarea>
            </div>

            <button class="contact-submit" type="submit" @disabled(empty($contact['email']))>
                <x-contact-icon name="send" />
                Envoyer le message
            </button>
            <p class="contact-form-note">Votre messagerie s’ouvrira pour finaliser l’envoi.</p>
            <p class="contact-feedback" data-form-status role="status"></p>
        </form>
    </div>
</section>

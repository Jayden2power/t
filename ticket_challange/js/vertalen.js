let translations = {};

document.addEventListener('DOMContentLoaded', function() {
    fetch('translations.json/lang.json')
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            translations = data.translations;
            console.log('Translations loaded:', translations);
            initTranslation();
            
            // Stel initiële taal in
            const initialLang = document.documentElement.lang || 'nl';
            translatePage(initialLang);
        })
        .catch(error => {
            console.error('Error loading translations:', error);
        });
});

function initTranslation() {
    const languageSelect = document.getElementById('language-select');
    
    if (!languageSelect) {
        console.error('Language select element not found!');
        return;
    }
    
    // Event listener voor taalwijziging
    languageSelect.addEventListener('change', function(e) {
        const selectedLang = e.target.value;
        console.log('Language changed to:', selectedLang);
        document.documentElement.lang = selectedLang;
        translatePage(selectedLang);
    });
}

function translatePage(lang) {
    if (!translations[lang]) {
        console.error(`Translation for language ${lang} not found!`);
        return;
    }
    
    const langData = translations[lang];
    
    // Update alle vertaalbare elementen
    try {
        // Titel
        document.title = langData.site_title;
        
        // Ingelogd tekst
        const loggedInText = document.querySelector('.top-right');
        if (loggedInText) {
            const email = loggedInText.textContent.split(' ').slice(-1)[0];
            loggedInText.textContent = `${langData.logged_in_as} ${email}`;
        }
        
        // Menu items
        const menuItems = {
            '.menu-logout': langData.menu.logout,
            '.menu-login': langData.menu.login,
            '.menu-contact': langData.menu.contact
        };
        
        Object.entries(menuItems).forEach(([selector, text]) => {
            const element = document.querySelector(selector);
            if (element) element.textContent = text;
        });
        
        // Banner
        document.querySelector('.banner-text').textContent = langData.banner.text;
        document.querySelector('.main-heading').textContent = langData.banner.heading;
        
        // Tickets - Volwassenen
        translateTicket('.left-ticket', langData.tickets.adults);
        
        // Tickets - Kinderen
        translateTicket('.right-ticket', langData.tickets.children);
        
        console.log(`Successfully translated to ${lang}`);
    } catch (error) {
        console.error('Error during translation:', error);
    }
}

function translateTicket(selector, ticketData) {
    const ticket = document.querySelector(selector);
    if (!ticket) return;
    
    ticket.querySelector('.ticket-title').textContent = ticketData.title;
    ticket.querySelector('.order-btn').textContent = ticketData.button;
    
    const features = ticket.querySelectorAll('.ticket-details li');
    ticketData.features.forEach((feature, i) => {
        if (features[i]) features[i].textContent = feature;
    });
}
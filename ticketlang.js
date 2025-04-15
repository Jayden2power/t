let translations = {};

document.addEventListener('DOMContentLoaded', function() {
    fetch('ticketlang.json')
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

        // Formuliervelden vertalen
        translateForm(langData.form);
        
        console.log(`Successfully translated to ${lang}`);
    } catch (error) {
        console.error('Error during translation:', error);
    }
}

function translateForm(formData) {
    // Labels vertalen
    const labels = {
        'first_name': formData.first_name,
        'last_name': formData.last_name,
        'email': formData.email,
        'phone_number': formData.phone,
        'address': formData.address,
        'bsn': formData.bsn
    };

    Object.entries(labels).forEach(([id, text]) => {
        const label = document.querySelector(`label[for="${id}"]`);
        if (label) label.textContent = text;
    });

    // Geboortedatum label
    const birthDateLabel = document.querySelector('label[for="day"]').previousSibling;
    if (birthDateLabel) {
        birthDateLabel.textContent = formData.birth_date;
    }

    // Placeholders voor datum dropdowns
    const daySelect = document.getElementById('day');
    const monthSelect = document.getElementById('month');
    const yearSelect = document.getElementById('year');
    
    if (daySelect) daySelect.querySelector('option[value=""]').textContent = formData.day;
    if (yearSelect) yearSelect.querySelector('option[value=""]').textContent = formData.year;

    // Maanden in de dropdown vervangen
    if (monthSelect) {
        const placeholderOption = monthSelect.querySelector('option[value=""]');
        placeholderOption.textContent = formData.month;
        
        // Verwijder bestaande maandopties (behalve placeholder)
        while (monthSelect.options.length > 1) {
            monthSelect.remove(1);
        }
        
        // Voeg nieuwe maandopties toe
        formData.months.forEach((month, index) => {
            const option = document.createElement('option');
            option.value = String(index + 1).padStart(2, '0');
            option.textContent = month;
            monthSelect.add(option);
        });
    }

    // Knoppen vertalen
    const submitBtn = document.getElementById('submit_knop');
    const resetBtn = document.getElementById('reset_knop');
    
    if (submitBtn) submitBtn.value = formData.submit;
    if (resetBtn) resetBtn.value = formData.reset;
}
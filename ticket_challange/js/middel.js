let translations = {};

document.addEventListener('DOMContentLoaded', function() {
    fetch('translations.json/middel.json')
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
            
            // Update jaar in footer
            document.getElementById('year').textContent = new Date().getFullYear();
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
    
    const langData = translations[lang].privacy;
    
    try {
        // Titel
        document.title = langData.title;
        
        // Menu items
        const menuItems = {
            '.menu a[href="ticket.php"]': langData.menu.home,
            '.language-selector select option[value="nl"]': langData.menu.languages.nl,
            '.language-selector select option[value="en"]': langData.menu.languages.en
        };
        
        Object.entries(menuItems).forEach(([selector, text]) => {
            const element = document.querySelector(selector);
            if (element) element.textContent = text;
        });
        
        // Hoofd secties
        document.querySelector('main h2').textContent = langData.title.split(' - ')[0];
        
        // Navigatie links
        const navLinks = document.querySelectorAll('.privacy-nav a');
        if (navLinks.length > 0) {
            navLinks[0].textContent = langData.sections.introduction.title.split(' ').slice(1).join(' ');
            navLinks[1].textContent = langData.sections.data_collected.title.split(' ').slice(1).join(' ');
            navLinks[2].textContent = langData.sections.data_purpose.title.split(' ').slice(1).join(' ');
            navLinks[3].textContent = langData.sections.data_retention.title.split(' ').slice(1).join(' ');
            navLinks[4].textContent = langData.sections.data_sharing.title.split(' ').slice(1).join(' ');
            navLinks[5].textContent = langData.sections.user_rights.title.split(' ').slice(1).join(' ');
            navLinks[6].textContent = langData.sections.contact.title.split(' ').slice(1).join(' ');
        }
        
        // Sectie inhoud
        translateSection('introduction', langData.sections.introduction);
        translateSection('data-collected', langData.sections.data_collected);
        translateSection('data-purpose', langData.sections.data_purpose);
        translateSection('data-retention', langData.sections.data_retention);
        translateSection('data-sharing', langData.sections.data_sharing);
        translateSection('user-rights', langData.sections.user_rights);
        translateSection('contact', langData.sections.contact);
        
        // Footer
        document.querySelector('footer p').textContent = langData.footer.replace('{year}', new Date().getFullYear());
        
        console.log(`Successfully translated to ${lang}`);
    } catch (error) {
        console.error('Error during translation:', error);
    }
}

function translateSection(sectionId, sectionData) {
    const section = document.getElementById(sectionId);
    if (!section) return;
    
    // Titel
    const title = section.querySelector('h3');
    if (title) title.textContent = sectionData.title;
    
    // Inhoud
    const content = section.querySelector('p, address');
    if (content) {
        if (Array.isArray(sectionData.content)) {
            // Voor secties met meerdere paragrafen
            section.querySelectorAll('p').forEach((p, i) => {
                if (sectionData.content[i]) p.textContent = sectionData.content[i];
            });
        } else {
            // Voor enkele paragrafen
            content.textContent = sectionData.content;
        }
    }
    
    // Lijst items (voor data_collected sectie)
    if (sectionId === 'data-collected') {
        const items = section.querySelectorAll('ul li');
        sectionData.items.forEach((item, i) => {
            if (items[i]) items[i].textContent = item;
        });
    }
    
    // Contact details (speciale behandeling)
    if (sectionId === 'contact') {
        const address = section.querySelector('address');
        if (address) {
            address.innerHTML = `
                E-mail: <a href="mailto:info@spikspan.nl">info@spikspan.nl</a><br>
                ${sectionData.details.phone}<br>
                <small>${sectionData.details.availability}</small><br>
                <small>${sectionData.details.whatsapp}</small><br>
                <small>${sectionData.details.response_time}</small>
            `;
        }
    }
}
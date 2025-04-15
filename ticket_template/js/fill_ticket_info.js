fetch('php/db_read_ticket.php')
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            console.error(data.error); // Log error if no data is found
        } else {
            // Update the HP and ID in the HTML
            document.getElementById('name').textContent = 'NAAM: ' + data.firstname + ' ' + data.lastname;
            document.getElementById('date_of_birth').textContent = 'GEBOORTEDATUM: ' + data.date_of_birth;
            document.getElementById('email').textContent = 'E-MAIL: ' + data.email;
            document.getElementById('phone_number').textContent = 'TEL #: ' + data.phone_number;
            document.getElementById('address').textContent = 'ADRES: ' + data.address;
            document.getElementById('bsn').textContent = 'BSN: ' + data.bsn;
            document.getElementById('date_of_issue').textContent = 'UITGIFTEDATUM: ' + data.date_of_issue;
        }
    })
    .catch(error => console.error('Error fetching data:', error));
function downloadPDF() {
    const element = document.getElementById('ticket');
    const ticket = document.getElementById('ticket');
    
    // Get the ticket's natural width/height
    const ticketWidth = ticket.offsetWidth;
    const ticketHeight = ticket.offsetHeight;
    
      // Configuration
      const opt = {
        margin:       10,
        filename:     'ticket.pdf',
        image:        { type: 'jpeg', quality: 1.0 },
        html2canvas:  { scale: 4, width: ticketWidth, height: ticketHeight },
        jsPDF:        { unit: 'px', format: [ticketWidth+20, ticketHeight+20], orientation: 'portrait' }
      };
      // Generate PDF
      html2pdf().from(element).set(opt).save();
  }
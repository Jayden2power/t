function downloadPDF() {
    const element = document.getElementById('ticket');
    
    // Configuration
    const opt = {
      margin:       10,
      filename:     'ticket.pdf',
      image:        { type: 'jpeg', quality: 1.0 },
      html2canvas:  { scale: 4 },
      jsPDF:        { unit: 'mm', format: [96.5, 180], orientation: 'portrait' }
    };
  
    // Generate PDF
    html2pdf().from(element).set(opt).save();
  }
/* Usato ChatGPT per il codice di base di Modal, riadattato da me   */
document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImg");
    const caption = document.getElementById("caption");
    const closeBtn = document.getElementsByClassName("close")[0];
    const downloadBtn = document.getElementById("downloadBtn");
  
    // Seleziona tutte le immagini nella sezione
    const immagini = document.querySelectorAll("#lP_right img"); // Seleziona tutte le immagini della sezione
  
    immagini.forEach(img => {
      img.addEventListener("click", () => { // Aggiunge evento click
        modal.style.display = "block";
        modalImg.src = img.src;
        caption.textContent = img.src.split("/").pop(); // Prende il nome del file
        downloadBtn.setAttribute("data-url", img.src); // Dà al download come url l'src diretta dell'immagine
      });
    });
  
    // Chiude il modal quando clicchi la X
    closeBtn.addEventListener("click", () => { // () => CALLBACk: invece di ????
      modal.style.display = "none";
    });
  
    // Chiude cliccando fuori dall'immagine
    modal.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.style.display = "none";
      }
    });




    // Download dell'Immagine
    downloadBtn.addEventListener("click", () => {
      const url = downloadBtn.getAttribute("data-url");
      const a = document.createElement("a");
      a.href = url;
      a.download = url.split("/").pop(); // Nome file automatico
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);
    });
  });
  

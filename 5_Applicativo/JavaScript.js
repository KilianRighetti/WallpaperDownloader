// Usato ChatGPT per il codice di base di Modal, riadattato da me
document.addEventListener("DOMContentLoaded", function() {
  const modal = document.getElementById("imageModal");
  const modalImg = document.getElementById("modalImg");
  // [ Pagina home ]
  const caption = document.getElementById("caption");
  const closeBtn = document.getElementsByClassName("close")[0];

  // Seleziona tutte le immagini nella sezione
  const immagini = document.querySelectorAll("img[data-categoria]"); // Seleziona TUTTE le immagini CON i tag "data-categoria" e "data-tag"

  immagini.forEach(img => {
    img.addEventListener("click", () => { // Aggiunge evento click
      
      if (document.URL.includes("index.php") ) {
        modal.style.display = "block";
        modalImg.src = img.src;
        caption.textContent = img.src.split("/").pop(); // Prende il nome del file
        downloadBtn.setAttribute("data-url", img.src); // Dà al download come url l'src diretta dell'immagine

      } else if(document.URL.includes("account.php") ) {
        const fileName = img.src.split("/").pop();
        window.location.href = "infoimage.php?nome_file=" + encodeURIComponent(fileName); // Si sposta su pagina
      }
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
});
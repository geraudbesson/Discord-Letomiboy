// Charger le chemin de l'image à partir du fichier texte et mettre à jour la balise img
fetch('chemin.txt')
    .then(response => response.text())
    .then(data => {
        var image = new Image();
        image.src = data;
        image.onload = function() {
            var imageImportee = document.getElementById('imageImportee');
            var texteImporte = document.getElementById('texteImporte');

            // Mettre à jour la source de l'image
            imageImportee.src = data;
            
            // Masquer le texte après le chargement complet de l'image
            texteImporte.classList.add('hidden');
        };
    })
    .catch(error => console.error(error));

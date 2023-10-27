const express = require('express');
const path = require('path');
const fs = require('fs');

const app = express();
const port = 3000;

app.use(express.static(path.join(__dirname, '..')));

app.get('/latest-image', (req, res) => {
  const imgPath = path.join(__dirname, '..', 'img-thème');
  fs.readdir(imgPath, (err, files) => {
    if (err) {
      console.error(err);
      res.status(500).send('Erreur serveur');
      return;
    }
    console.log('Liste des fichiers dans le dossier "img-thème":', files);
    const latestImage = files.sort((a, b) => {
      return fs.statSync(path.join(imgPath, b)).mtime.getTime() -
             fs.statSync(path.join(imgPath, a)).mtime.getTime();
    })[0];
    console.log('Dernière image trouvée:', latestImage);
    res.json({ imageName: latestImage });
  });
});

app.listen(port, () => {
  console.log(`Serveur en cours d'exécution sur le port ${port}`);
});

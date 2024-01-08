const express = require('express');
const bodyParser = require('body-parser');

// Création de l'application Express
const app = express();

// Utilisation de bodyParser pour parser les corps de requêtes en JSON
app.use(bodyParser.json());

// Définition d'un port d'écoute
const PORT = process.env.PORT || 3000;

// Route de test pour vérifier que le serveur fonctionne
app.get('/', (req, res) => {
  res.send('Weather Station API is running');
});

// Démarrage du serveur
app.listen(PORT, () => {
  console.log(`Server is running on port ${PORT}`);
});

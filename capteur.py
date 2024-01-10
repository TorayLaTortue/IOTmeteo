import requests
import bme280

# Lecture des données du BME280
(chip_id, chip_version) = bme280.readBME280ID()
print("Chip ID :", chip_id)
print("Version :", chip_version)

temperature, pressure, humidity = bme280.readBME280All()

# Création du payload avec les données à envoyer au serveur PHP
payload = {
    'temperature': temperature,
    'humidite': humidity,
    'p_atmospherique': pressure,
    'date': 'date_value',  # Remplacez par la valeur réelle de la date
    'heure': 'heure_value'  # Remplacez par la valeur réelle de l'heure
} # Je crois que sur la raspberry on peut recupérer l'heure ^

# lien du script de la bdd sur la raspberry
url = 'http://votre_domaine.com/chemin/vers/votre_script.php'

# Envoi de la requête POST avec le payload
response = requests.post(url, data=payload)

# Affichage de la réponse du serveur
print(response.text)

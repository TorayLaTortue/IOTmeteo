import requests
import bme280
import serial
import time

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
}

# Lien du script de la BDD sur la Raspberry
url = 'votre_script.php'

# Envoi de la requête POST avec le payload
response = requests.post(url, data=payload)

# Affichage de la réponse du serveur
print(response.text)

# Configuration de la connexion série avec l'écran Nextion
ser = serial.Serial('/dev/ttyS0', 9600, timeout=1)  # Assurez-vous de spécifier le bon port série

# Attendez un court moment pour que l'écran Nextion soit prêt
time.sleep(1)

# Envoi de texte à l'écran Nextion
ser.write(b't0.txt="Hello Nextion!"\xFF\xFF\xFF')

# Fermeture de la connexion série
ser.close()

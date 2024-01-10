import requests
import bme280
import serial
import time

# Lecture des données du BME280
(chip_id, chip_version) = bme280.readBME280ID()
print("Chip ID :", chip_id)
print("Version :", chip_version)

# Création du payload avec les données à envoyer au serveur PHP
payload = {
    'temperature': 0,
    'humidite': 0,
    'p_atmospherique': 0,
}

total_temperature = 0
total_humidite = 0
total_pression = 0
values_received = 0

# Lien du script de la BDD sur la Raspberry
url = 'votre_script.php'

# Configuration de la connexion série avec l'écran Nextion
ser = serial.Serial('/dev/ttyS0', 9600, timeout=1)  # Assurez-vous de spécifier le bon port série

# Attendez un court moment pour que l'écran Nextion soit prêt
time.sleep(1)

for i in range(5):
    # Lecture des données du BME280
    temperature, pression, humidite = bme280.readBME280All()

    # Ajouter les valeurs aux totaux
    total_temperature += temperature
    total_humidite += humidite
    total_pression += pression

    # Incrémenter le nombre de valeurs reçues
    values_received += 1

    # Création du payload avec les données à envoyer au serveur PHP
    payload['temperature'] = temperature
    payload['humidite'] = humidite
    payload['p_atmospherique'] = pression

    # Envoi de la requête POST avec le payload
    response = requests.post(url, data=payload)

    # Affichage de la réponse du serveur
    print(response.text)

# Calcul de la moyenne
if values_received == 5:
    # Calcul de la moyenne
    moyenne_temperature = total_temperature / 5
    moyenne_humidite = total_humidite / 5
    moyenne_pression = total_pression / 5

# Affichage de la moyenne
print("Moyenne Température: {} °C".format(moyenne_temperature))
print("Moyenne Humidité: {} %".format(moyenne_humidite))
print("Moyenne Pression: {} hPa".format(moyenne_pression))

# Envoi de texte à l'écran Nextion avec la moyenne
ser.write("t0.txt=\"Température: {:.2f} °C\"\xFF\xFF\xFF".format(temperature))
ser.write("t1.txt=\"Humidité: {:.2f} %\"\xFF\xFF\xFF".format(humidite))
ser.write("t2.txt=\"Pression: {:.2f} hPa\"\xFF\xFF\xFF".format(pression))

# Fermeture de la connexion série
ser.close()


import bme280

(chip_id, chip_version) = bme280.readBME280ID()
print ("Chip ID :", chip_id)
print ("Version :", chip_version)

temperature,pressure,humidity = bme280.readBME280All()

# A modifier pour renvoyer les donnée a la page web plutot que de les prints
print("Température: {} °C".format(temperature))
print("Humidité: {} %".format(humidity))
print("Pression: {} hPa".format(pressure))
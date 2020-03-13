<p align="center">
    <h1 align="center">mini Project</h1>
    <br>
</p>

### Consultation des commandes enregistrées qui sont en cours -- GET https://{{url}}/orders?status=2

### Pouvoir gérer un stock de voitures décliné par marque, par modèle et par type de moteur (l'année peut suffire) -- GET https://{{url}}/vehicles?search=hy

### Pouvoir gérer une liste de clients avec lesquels j'ai traité ou pas encore traité -- GET https://{{url}}/clients?is_new=1

### Pouvoir consulter les statistiques des commandes par jour, par semaine et par mois -- GET https://{{url}}/orders?start_date=2020-03-12&period=day&duration=2

### Les clients sont majeurs, ils ne peuvent pas avoir moins de 18 ans -- test POST a client with the date of birth less than 18 yo

### Les clients doivent avoir obligatoirement une adresse e-mail de contact -- in rules

### Le stock de voitures ne peut dépasser 100 voitures -- while creating the vehicle or increase/minus the stock 

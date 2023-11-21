<h1>Test JWT</h1>

<fieldset>
    <legend>Boutons</legend>
    <!-- Simuler une connection -> les données sont écrites en dur dans la méthode authenticate() -->
    <button onclick="authenticate()">Demander JWT</button>
    <!-- Effacer le JWT stocké dans le local storage -->
    <button onclick="clearJWT()">Effacer JWT</button>
    <!-- Récupérer la date depuis l'api -->
    <button onclick="getDateTimeFromApi()">Récupérer la date depuis l'api</button>
</fieldset>

<p>Réponse : <span id="test"></span></p>

<script src="app.js"></script>
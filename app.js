// Récupère le token JWT depuis la page d'authentification
function authenticate() {
    const url = 'authenticate.php';

    // Effectuez une requête fetch vers l'URL
    fetch(url)
        .then(response => {
            // Vérifiez si la requête a réussi (statut 200 OK)
            if (!response.ok) {
                throw new Error(`Erreur de requête: ${response.status}`);
            }

            // Récupérez le corps de la réponse en tant que texte
            return response.text();
        })
        .then(body => {
            // On stocke le token dans le local storage
            localStorage.setItem('jwt', body);

            // On affiche le token dans la page
            setReponse(body)
        })
        .catch(error => {
            console.error('Erreur de récupération du corps de la page:', error);
        });
}

// Effacer le token JWT du stockage local
function clearJWT() {
    localStorage.removeItem('jwt');
    setReponse(localStorage.getItem('jwt'));
}

// Récupérer la date ssi l'utilisateur est authentifié avec un jeton JWT valide
function getDateTimeFromApi() {
    // Récupérez le token JWT depuis le stockage local
    const jwtToken = localStorage.getItem('jwt');

    // Remplacez l'URL par celle de la page que vous souhaitez récupérer
    const url = 'api.php';

    // Effectuez une requête fetch vers l'URL avec l'en-tête Authorization
    fetch(url, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${jwtToken}`
        },
    })
        .then(response => {
            // Vérifiez si la requête a réussi (statut 200 OK)
            if (!response.ok) {
                throw new Error(`Erreur de requête: ${response.status}`);
            }

            // Récupérez le corps de la réponse en tant que texte
            return response.text();
        })
        .then(body => {
            // On affiche le résultat dans la page
            setReponse(body)
        })
        .catch(error => {
            console.error('Erreur de récupération du corps de la page:', error);
        });
}

function setReponse($reponse) {
    let test = document.getElementById('test');
    test.innerHTML = $reponse;
}
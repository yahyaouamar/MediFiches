<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Fiche santé individuelle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    body {
        font-family: 'Arial', sans-serif;
        line-height: 1.4; 
        margin: 0;
        padding: 0;
        color: #333;
        font-size: 12px; 
    }

    .container {
        max-width: 850px; 
        margin: 10px auto; 
        background: #fff;
        padding: 10px; 
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1, h2 {
        color: #0056b3;
        margin-bottom: 5px; 
    }

    h1 {
        font-size: 20px; 
        text-align: center;
    }

    h2 {
        font-size: 18px; 
        border-bottom: 1px solid #0056b3;
        padding-bottom: 3px;
        margin-top: 10px;
    }

    .info-section {
        background: #e7f1ff;
        padding: 10px; 
        margin-bottom: 10px; 
        border-left: 3px solid #007bff;
        border-radius: 4px;
    }
</style>

</head>

<body>

    <div class="container">
        <h1>Fiche santé individuelle</h1>
        <p>Cette fiche contient des informations importantes concernant la santé du participant. Elle doit être complète
            et mise à jour pour garantir une prise en charge adaptée en cas d'urgence.</p>
        <div class="info-section">
            <h2>Informations sur l'enfant</h2>
            <p>Nom: {{ $data->last_name}}</p>
            <p>Prénom: {{ $data->first_name}}</p>
            <p>Date de naissance: {{ $data->birth_date}}</p>
            <h2>Adresse</h2>
            <p>Rue: {{ $data->street }}</p>
            <p>Numéro: {{ $data->no }}</p>
            <p>Boite Postale: {{ $data->mail_box }}</p>
            <p>Ville: {{ $data->city}}</p>
            <p>Code Postal: {{ $data->postal_code }}</p>
        </div>
        <div class="info-section">
            <h2>Contacts en cas d'urgence</h2>
            @if ($parent1Details)
            <p>Parent 1:
            <p>Nom: {{ $parent1Details->first_name }}</p>
            <p>Prénom: {{ $parent1Details->last_name }}</p>
            <p>Email: {{ $parent1Details->email }}</p>
            </p>
            @endif
            @if ($parent2Details)
            <p>Parent 2:
            <p>Nom: {{ $parent2Details->first_name }}</p>
            <p>Prénom: {{ $parent2Details->last_name }}</p>
            <p>Email: {{ $parent2Details->email }}</p>
            </p>
            @else
            <p>Parent 2:</p>
            <p>Pas de deuxième parent.</p>
            @endif
        </div>

        <!-- Section Médecin traitant -->
        <div class="info-section">
            <h2>Médecin traitant</h2>
            <p>Nom et prénom du medecin traitant : {{ $data->doctor }}</p>
            <p>Numéro de téléphone du medecin traitant: {{$data->emergency_contact_doctor}}</p>
        </div>

        <!-- Section Informations de santé -->
        <div class="info-section">
            <h2>Informations sur la santé</h2>
            <p>Des détails spécifiques : {{ $data->additional_infos}}</p>
            <p>L'enfant peut participer à toute les activités? {{ $data->can_participate ? 'Oui' : 'Non' }} </p>
            <p>L'enfant est vacciné contre le tétanos ? {{ $data->tetanons_protected ? 'Non' : 'Oui' }} </p>
            <p>Date du dernier rappel: {{$data->tetanos_update}}</p>
        </div>

        <!-- Section Allergies -->
        <div class="info-section">
            <h2>Allergies et réactions</h2>
            <p>Allergies connues : {{ $data->allergies}}</p>
        </div>

        <!-- Section Médicaments -->
        <div class="info-section">
            <h2>Médicaments</h2>
            <p>Médicament à prendre: {{ $data->medecins }}</p>
        </div>
    </div>

</body>
</html>
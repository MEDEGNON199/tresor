<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Œuvres d'Art</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">🎨 Trésor Artistique</a>
        </div>
    </nav>

    <div class="container mt-5">
        <?php
        require_once 'connexion.php';

        $query = "
            SELECT oeuvre.*, artiste.nomArtiste, artiste.prenom AS prenomArtiste, categorie.nom_categorie
            FROM oeuvre
            LEFT JOIN artiste ON oeuvre.id_artiste = artiste.id_artiste
            JOIN categorie ON oeuvre.id_categorie = categorie.id_categorie
        ";
        $result = mysqli_query($connexion, $query);
        $oeuvres = mysqli_fetch_all($result, MYSQLI_ASSOC);
        ?>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Liste des Œuvres</h2>
            <a href="create.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Ajouter une œuvre
            </a>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Œuvre</th>
                            <th>Auteur</th>
                            <th>Année</th>
                            <th>Catégorie</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($oeuvres as $o): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($o['nom']) ?></strong></td>
                            <td><?= htmlspecialchars($o['prenomArtiste'] . ' ' . $o['nomArtiste']) ?></td>
                            <td><?= $o['annee'] ? date('Y', strtotime($o['annee'])) : 'N/A' ?></td>
                            <td><span class="badge bg-info"><?= htmlspecialchars($o['nom_categorie']) ?></span></td>
                            <td>
                                <a href="modifier.php?id=<?= $o['id_oeuvre'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                <a href="supprimer.php?id=<?= $o['id_oeuvre'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette œuvre ?')">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

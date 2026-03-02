<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Œuvre</title>
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

        $resultArtistes = mysqli_query($connexion, "SELECT * FROM artiste");
        $artistes = mysqli_fetch_all($resultArtistes, MYSQLI_ASSOC);

        $resultCategories = mysqli_query($connexion, "SELECT * FROM categorie");
        $categories = mysqli_fetch_all($resultCategories, MYSQLI_ASSOC);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = mysqli_real_escape_string($connexion, $_POST['nom']);
            $description = mysqli_real_escape_string($connexion, $_POST['description']);
            $annee = !empty($_POST['annee']) ? $_POST['annee'] . '-01-01' : null;
            $idArtiste = !empty($_POST['idArtiste']) ? (int)$_POST['idArtiste'] : null;
            $idCategorie = (int)$_POST['idCategorie'];

            $query = "INSERT INTO oeuvre (nom, descrition, annee, id_artiste, id_categorie) VALUES ('$nom', '$description', " . ($annee ? "'$annee'" : "NULL") . ", " . ($idArtiste ? $idArtiste : "NULL") . ", $idCategorie)";
            mysqli_query($connexion, $query);

            header('Location: index.php');
            exit;
        }
        ?>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h2 class="mb-0">Ajouter une œuvre</h2>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Nom de l'œuvre</label>
                                <input type="text" name="nom" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Année</label>
                                <input type="number" name="annee" class="form-control" placeholder="Ex: 1889">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Artiste</label>
                                <select name="idArtiste" class="form-select">
                                    <option value="">-- Inconnu --</option>
                                    <?php foreach ($artistes as $a): ?>
                                        <option value="<?= $a['id_artiste'] ?>"><?= $a['prenom'] . ' ' . $a['nomArtiste'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catégorie</label>
                                <select name="idCategorie" class="form-select" required>
                                    <?php foreach ($categories as $c): ?>
                                        <option value="<?= $c['id_categorie'] ?>"><?= $c['nom_categorie'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">Enregistrer</button>
                                <a href="index.php" class="btn btn-secondary">Annuler</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

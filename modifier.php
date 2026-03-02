<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une Œuvre</title>
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

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: index.php');
            exit;
        }

        $id = (int)$id;
        $queryOeuvre = "SELECT * FROM oeuvre WHERE id_oeuvre = $id";
        $resultOeuvre = mysqli_query($connexion, $queryOeuvre);
        $oeuvre = mysqli_fetch_assoc($resultOeuvre);

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

            $query = "UPDATE oeuvre SET nom='$nom', descrition='$description', annee=" . ($annee ? "'$annee'" : "NULL") . ", id_artiste=" . ($idArtiste ? $idArtiste : "NULL") . ", id_categorie=$idCategorie WHERE id_oeuvre=$id";
            mysqli_query($connexion, $query);

            header('Location: index.php');
            exit;
        }
        ?>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h2 class="mb-0">Modifier l'œuvre</h2>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="mb-3">
                                <label class="form-label">Nom de l'œuvre</label>
                                <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($oeuvre['nom']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($oeuvre['descrition']) ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Année</label>
                                <input type="number" name="annee" class="form-control" value="<?= $oeuvre['annee'] ? date('Y', strtotime($oeuvre['annee'])) : '' ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Artiste</label>
                                <select name="idArtiste" class="form-select">
                                    <option value="">-- Inconnu --</option>
                                    <?php foreach ($artistes as $a): ?>
                                        <option value="<?= $a['id_artiste'] ?>" <?= $a['id_artiste'] == $oeuvre['id_artiste'] ? 'selected' : '' ?>>
                                            <?= $a['prenom'] . ' ' . $a['nomArtiste'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catégorie</label>
                                <select name="idCategorie" class="form-select" required>
                                    <?php foreach ($categories as $c): ?>
                                        <option value="<?= $c['id_categorie'] ?>" <?= $c['id_categorie'] == $oeuvre['id_categorie'] ? 'selected' : '' ?>>
                                            <?= $c['nom_categorie'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">Mettre à jour</button>
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
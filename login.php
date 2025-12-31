<?php
session_start();
require_once 'db.php'; // connexion PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['login'] ?? '';
    $pass = sha1($_POST['mdp'] ?? '');

    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE login = ?");
    $stmt->execute([$user]);
    $data = $stmt->fetch();

    if (!$data) {
        $error = "Login incorrect !";
    } else if ($data['mdp'] !== $pass) {
        $error = "Mot de passe incorrect !";
    } else {
        // Stocke les infos en session
        $_SESSION['id'] = $data['id'];
        $_SESSION['login'] = $data['login'];
        $_SESSION['nom'] = $data['nom'];
        $_SESSION['profil'] = $data['profil']; // colonne en base

        // Redirection selon le profil
        if ($data['profil'] === 'admin') {
            header("Location: utilisateurs.php");
        } else {
            header("Location: index.php");
        }
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card shadow">
        <div class="card-header bg-dark text-white text-center">
          <h3>Connexion</h3>
        </div>
        <div class="card-body">
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>
          <form method="post" action="">
            <div class="mb-3">
              <label for="login" class="form-label">Login</label>
              <input type="text" class="form-control" id="login" name="login" required>
            </div>
            <div class="mb-3">
              <label for="mdp" class="form-label">Mot de passe</label>
              <input type="password" class="form-control" id="mdp" name="mdp" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Se connecter</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

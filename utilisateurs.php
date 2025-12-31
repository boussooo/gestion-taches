<?php
require_once 'db.php'; // connexion PDO
include 'includes/header.php';

// Vérification accès admin
if (!isset($_SESSION['profil']) || $_SESSION['profil'] !== 'admin') {
    echo "<div class='container mt-5 alert alert-danger'>Accès interdit : Admin uniquement.</div>";
    exit;
}

// Récupérer tous les utilisateurs
$stmt = $pdo->query("SELECT * FROM utilisateur ORDER BY id DESC");
$users = $stmt->fetchAll();

// Pour la modification
$user_a_modifier = null;
if (isset($_GET['modifier'])) {
    $id = $_GET['modifier'];
    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE id=?");
    $stmt->execute([$id]);
    $user_a_modifier = $stmt->fetch();
}

// Statistiques pour le tableau de bord
$totalUsers = count($users);
$totalTasks = $pdo->query("SELECT COUNT(*) FROM tache")->fetchColumn();
$doneTasks = $pdo->query("SELECT COUNT(*) FROM tache WHERE statut='terminee'")->fetchColumn();
$pendingTasks = $pdo->query("SELECT COUNT(*) FROM tache WHERE statut='en_cours'")->fetchColumn();
?>

<div class="container mt-4">

  <!-- Tableau de bord -->
  <h2 class="mb-4 text-center">Tableau de bord Admin</h2>
  <div class="row mb-5">
    <div class="col-md-3">
      <div class="card text-white bg-primary shadow">
        <div class="card-body text-center">
          <h5 class="card-title">Utilisateurs</h5>
          <p class="fs-3"><?= $totalUsers ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-success shadow">
        <div class="card-body text-center">
          <h5 class="card-title">Tâches totales</h5>
          <p class="fs-3"><?= $totalTasks ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-info shadow">
        <div class="card-body text-center">
          <h5 class="card-title">Tâches terminées</h5>
          <p class="fs-3"><?= $doneTasks ?></p>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-white bg-warning shadow">
        <div class="card-body text-center">
          <h5 class="card-title">Tâches en cours</h5>
          <p class="fs-3"><?= $pendingTasks ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Formulaire -->
  <h2 class="mb-3 text-center"><?= $user_a_modifier ? "Modifier un utilisateur" : "Ajouter un utilisateur" ?></h2>
  <div class="card mb-4 col-md-6 offset-md-3 shadow">
    <div class="card-header bg-primary text-white"><?= $user_a_modifier ? "Modification" : "Nouveau" ?></div>
    <div class="card-body">
      <form method="POST" action="actions.php">
        <input type="hidden" name="action" value="<?= $user_a_modifier ? "modifier_user" : "ajouter_user" ?>">
        <?php if ($user_a_modifier): ?>
          <input type="hidden" name="id" value="<?= $user_a_modifier['id'] ?>">
        <?php endif; ?>
        <input type="text" name="prenom" class="form-control mb-2" placeholder="Prénom" required value="<?= $user_a_modifier['prenom'] ?? '' ?>">
        <input type="text" name="nom" class="form-control mb-2" placeholder="Nom" required value="<?= $user_a_modifier['nom'] ?? '' ?>">
        <input type="text" name="login" class="form-control mb-2" placeholder="Login" required value="<?= $user_a_modifier['login'] ?? '' ?>">
        <input type="password" name="mdp" class="form-control mb-2" placeholder="<?= $user_a_modifier ? 'Laisser vide pour ne pas changer' : 'Mot de passe' ?>">
        <select name="profil" class="form-select mb-3">
          <option value="user" <?= ($user_a_modifier['profil'] ?? '') == 'user' ? 'selected' : '' ?>>User</option>
          <option value="admin" <?= ($user_a_modifier['profil'] ?? '') == 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
        <button class="btn btn-success"><?= $user_a_modifier ? "Modifier" : "Ajouter" ?></button>
        <?php if ($user_a_modifier): ?><a href="utilisateurs.php" class="btn btn-secondary">Annuler</a><?php endif; ?>
      </form>
    </div>
  </div>

  <!-- Liste des utilisateurs -->
  <h2 class="mb-3 text-center">Liste des utilisateurs</h2>
  <table class="table table-striped table-hover col-md-10 offset-1 shadow">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Login</th>
        <th>Profil</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($users as $u): ?>
        <tr>
          <td><?= $u['id'] ?></td>
          <td><?= htmlspecialchars($u['prenom']) ?></td>
          <td><?= htmlspecialchars($u['nom']) ?></td>
          <td><?= htmlspecialchars($u['login']) ?></td>
          <td>
            <span class="badge bg-<?= $u['profil']=='admin'?'danger':'secondary' ?>">
              <?= $u['profil'] ?>
            </span>
          </td>
          <td>
            <a href="utilisateurs.php?modifier=<?= $u['id'] ?>" class="btn btn-sm btn-primary">Modifier</a>
            <a href="actions.php?supprimer_user=<?= $u['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet utilisateur ?');">Supprimer</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js">
window.onload = function() {
  document.querySelector("input[name='login']").value = "";
  document.querySelector("input[name='mdp']").value = "";
};
</script>

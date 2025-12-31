<?php include 'includes/header.php'; ?>
<?php include 'actions.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>Mes Tâches</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
<h2 class="mb-3 text-center">Tableau de bord</h2>

<!-- FORMULAIRE -->
<div class="card mb-4 col-md-6 offset-3">
  <div class="card-header bg-primary text-white"><?= $tache_a_modifier ? "Modifier" : "Nouvelle tâche" ?></div>
  <div class="card-body">
    <form method="POST" action="actions.php">
      <input type="hidden" name="action" value="<?= $tache_a_modifier ? "modifier" : "ajouter" ?>">
      <?php if ($tache_a_modifier): ?>
        <input type="hidden" name="id_tache" value="<?= $tache_a_modifier['id_tache'] ?>">
      <?php endif; ?>
      <input type="text" name="titre" class="form-control mb-2" placeholder="Titre" required value="<?= $tache_a_modifier['titre'] ?? '' ?>">
      <textarea name="description" class="form-control mb-2" rows="3" placeholder="Description"><?= $tache_a_modifier['description'] ?? '' ?></textarea>
      <select name="statut" class="form-select mb-3">
        <option value="en cours" <?= ($tache_a_modifier['statut'] ?? '') == "en cours" ? "selected" : "" ?>>En cours</option>
        <option value="terminée" <?= ($tache_a_modifier['statut'] ?? '') == "terminée" ? "selected" : "" ?>>Terminée</option>
      </select>
      <button class="btn btn-success"><?= $tache_a_modifier ? "Modifier" : "Ajouter" ?></button>
      <?php if ($tache_a_modifier): ?><a href="index.php" class="btn btn-secondary">Annuler</a><?php endif; ?>
    </form>
  </div>
</div>

<!-- LISTE -->
<div class="row">
<?php foreach ($taches as $tache): ?>
  <div class="col-md-4">
    <div class="card mb-3 shadow-sm">
      <div class="card-body">
        <h5><?= htmlspecialchars($tache['titre']) ?></h5>
        <p><?= htmlspecialchars($tache['description']) ?></p>
        <p class="text-muted small">Créée le : <?= date('d/m/Y à H:i', strtotime($tache['date_creation'])) ?></p>
        <span class="badge bg-<?= $tache['statut']=="terminée"?"success":"warning" ?>"><?= $tache['statut'] ?></span>
        <hr>
        <a href="index.php?modifier=<?= $tache['id_tache'] ?>" class="btn btn-sm btn-primary">Modifier</a>
        <a href="actions.php?supprimer=<?= $tache['id_tache'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette tâche ?');">Supprimer</a>
        <?php if ($tache['statut']=="en cours"): ?>
          <a href="actions.php?terminer=<?= $tache['id_tache'] ?>" class="btn btn-sm btn-success">Terminer</a>
        <?php else: ?>
          <a href="actions.php?reprendre=<?= $tache['id_tache'] ?>" class="btn btn-sm btn-warning">Reprendre</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

</div>
</body>
</html>

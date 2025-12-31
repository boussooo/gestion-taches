<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gestion</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
  <span class="navbar-brand">bienvenue</span>
  <div class="ms-auto d-flex align-items-center">
    <span class="text-white me-3">
      <?= htmlspecialchars($_SESSION['nom']) ?> (<?= htmlspecialchars($_SESSION['profil']) ?>)
    </span>
    <a href="logout.php" class="btn btn-danger btn-sm">Déconnexion</a>
  </div>
</nav>

<?php
// session_start();
include 'db.php';

// --- GESTION DES TÂCHES ---

// Ajouter une tâche
if(isset($_POST['action']) && $_POST['action'] == 'ajouter'){
    $titre = $_POST['titre'];
    $desc = $_POST['description'];
    $statut = $_POST['statut'];
    $id_user = $_SESSION['id'];

    $stmt = $pdo->prepare("INSERT INTO tache (titre, description, statut, id_utilisateur) VALUES (?,?,?,?)");
    $stmt->execute([$titre, $desc, $statut, $id_user]);
    header("Location: index.php");
    exit;
}

// Modifier une tâche
if(isset($_POST['action']) && $_POST['action'] == 'modifier'){
    $id_tache = $_POST['id_tache'];
    $titre = $_POST['titre'];
    $desc = $_POST['description'];
    $statut = $_POST['statut'];

    $stmt = $pdo->prepare("UPDATE tache SET titre=?, description=?, statut=? WHERE id_tache=?");
    $stmt->execute([$titre, $desc, $statut, $id_tache]);
    header("Location: index.php");
    exit;
}

// Supprimer une tâche
if(isset($_GET['supprimer'])){
    $id_tache = $_GET['supprimer'];
    $stmt = $pdo->prepare("DELETE FROM tache WHERE id_tache=?");
    $stmt->execute([$id_tache]);
    header("Location: index.php");
    exit;
}

// Terminer une tâche
if(isset($_GET['terminer'])){
    $id_tache = $_GET['terminer'];
    $stmt = $pdo->prepare("UPDATE tache SET statut='terminée' WHERE id_tache=?");
    $stmt->execute([$id_tache]);
    header("Location: index.php");
    exit;
}

// Reprendre une tâche
if(isset($_GET['reprendre'])){
    $id_tache = $_GET['reprendre'];
    $stmt = $pdo->prepare("UPDATE tache SET statut='en cours' WHERE id_tache=?");
    $stmt->execute([$id_tache]);
    header("Location: index.php");
    exit;
}

// ---  GESTION DES UTILISATEURS (ADMIN UNIQUEMENT) ---

// Ajouter un utilisateur
if(isset($_POST['action']) && $_POST['action'] == 'ajouter_user'){
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $login = $_POST['login'];
    $mdp = sha1($_POST['mdp']);
    $profil = $_POST['profil'];

    $stmt = $pdo->prepare("INSERT INTO utilisateur (prenom, nom, login, mdp, profil) VALUES (?,?,?,?,?)");
    $stmt->execute([$prenom, $nom, $login, $mdp, $profil]);
    header("Location: utilisateurs.php");
    exit;
}

// Modifier un utilisateur
if(isset($_POST['action']) && $_POST['action'] == 'modifier_user'){
    $id = $_POST['id'];
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $login = $_POST['login'];
    $profil = $_POST['profil'];

    if(!empty($_POST['mdp'])){
        $mdp = sha1($_POST['mdp']);
        $stmt = $pdo->prepare("UPDATE utilisateur SET prenom=?, nom=?, login=?, mdp=?, profil=? WHERE id=?");
        $stmt->execute([$prenom, $nom, $login, $mdp, $profil, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE utilisateur SET prenom=?, nom=?, login=?, profil=? WHERE id=?");
        $stmt->execute([$prenom, $nom, $login, $profil, $id]);
    }
    header("Location: utilisateurs.php");
    exit;
}

// Supprimer un utilisateur
if(isset($_GET['supprimer_user'])){
    $id = $_GET['supprimer_user'];
    $stmt = $pdo->prepare("DELETE FROM utilisateur WHERE id=?");
    $stmt->execute([$id]);
    header("Location: utilisateurs.php");
    exit;
}

// --- RECUPÉRATION DES TÂCHES ) ---
$stmt = $pdo->prepare("SELECT * FROM tache ORDER BY date_creation DESC");
$stmt->execute();
$taches = $stmt->fetchAll();

// ---  MODIFICATION D'UNE TÂCHE ) ---
$tache_a_modifier = null;
if(isset($_GET['modifier'])){
    $id_tache = $_GET['modifier'];
    $stmt = $pdo->prepare("SELECT * FROM tache WHERE id_tache=?");
    $stmt->execute([$id_tache]);
    $tache_a_modifier = $stmt->fetch();
}
?>


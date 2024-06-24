<?php
require_once 'connec.php';

$pdo = new \PDO(DSN, USER, PASS);
$query2 = "SELECT * FROM PDO_quest";
$statement = $pdo->query($query2);
$infosArray = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty(htmlentities(trim($_POST['firstname']))) && strlen(htmlentities(trim($_POST['firstname']))) < 45) {
        $firstname = htmlentities(trim($_POST['firstname']));
    } elseif (empty(htmlentities(trim($_POST['firstname'])))) {
        $errors[] = 'Le champ "Prenom" doit être rempli.';
    } else {
        $errors[] = 'Le champ "Prenom" doit être rempli avec moins de 45 caractères.';
    }

    if (!empty(htmlentities(trim($_POST['lastname']))) && strlen(htmlentities(trim($_POST['lastname']))) < 45) {
        $lastname = htmlentities(trim($_POST['lastname']));
    } elseif (empty(htmlentities(trim($_POST['lastname'])))) {
        $errors[] = 'Le champ "Nom" doit être rempli.';
    } else {
        $errors[] = 'Le champ "Nom" doit être rempli avec moins de 45 caractères.';
    }

    if (empty($errors)) {

        $pdo = new PDO(DSN, USER, PASS);
        $query = "INSERT INTO PDO_quest  (firstname,lastname) VALUES (:firstname, :lastname)";
        $statement = $pdo->prepare($query);
        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);
        $statement->execute();

        header('Location: validation.php');
        die();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php if (!empty($errors)) : ?>
        <h1>Erreurs :</h1>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>


    <h1>Formulaire</h1>
    <form action="index.php" method="post">

        <label for="firstname">Prenom</label>
        <input type="text" id="firstname" name="firstname" required>

        <label for="lastname">Nom</label>
        <input type="text" id="lastname" name="lastname" required>

        <input type="submit" value="Envoyer">

    </form>

    <h1>Liste</h1>
    <?php
    foreach ($infosArray as $infos) {
        echo $infos['firstname'] . ' ' . $infos['lastname'] . "<br>";
    }
    ?>


</body>

</html>
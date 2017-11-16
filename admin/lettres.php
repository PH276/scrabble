<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>gestion des lettres</title>
</head>
<body>
    <?php
    $pdo = new PDO ("mysql:host=localhost;dbname=scrabble", 'root', '');
    if (!empty($_POST)){
        // echo '<pre>';
        // print_r ($_POST);
        // echo '</pre>';
        $req = $pdo -> prepare ("UPDATE lettres SET nombre = :nombre, points = :points where id = :id");
        $req -> execute(array(
            ':id' => $_POST['id'],
            ':nombre' => $_POST['nombre'],
            ':points' => $_POST['points']
        ));

    }
    $req = $pdo -> query ("SELECT * FROM lettres");
    $lettres = $req -> fetchAll(PDO::FETCH_ASSOC);
    ?>
    <table>
        <tr style="text-align:center">
            <td></td>
            <td>Lettres</td>
            <td>nombre</td>
            <td>Point</td>
        </tr>
        <?php foreach ($lettres as $lettre) : ?>
            <tr>

                <form action="" method="post">
                    <td><input type="hidden" name="id" value="<?= $lettre['id'] ?>"></td>
                    <td><label width="20"><?= $lettre['lettre'] ?> : </label></td>
                    <td><input type="text" name="nombre" value="<?= $lettre['nombre'] ?>"></td>
                    <td><input type="text" name="points" value="<?= $lettre['points'] ?>"></td>
                    <td><input type="submit" value="Valider"></td>
                </form>
            </tr>






        <?php endforeach; ?>
    </table>



</body>
</html>

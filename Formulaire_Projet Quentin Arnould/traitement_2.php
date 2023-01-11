<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inventaire</title>
</head>
<body>
    <?php
        $fichiercsv = fopen("inventaire.csv", "r");
        $ligne = fgets($fichiercsv);
        $id = 0;
        while($ligne !="")
        {
            $id= $id + 1;
            $ligne = fgets($fichiercsv);
        }
        fclose($fichiercsv);
        $fichiercsv=fopen("inventaire.csv", "a");
        $nom = $_GET["article"];
        $quantite = $_GET["quantité"];
        $reference = $_GET["référence"];
        $prixdevente = $_GET["prix"];
        $tab_ligne= array($id, $nom, $quantite, $reference, $prixdevente);
        fputcsv($fichiercsv, $tab_ligne, $delimiter=";");
        fclose($fichiercsv);
        printf("<h1> Une ligne a bien été ajoutée dans le fichier invantaire.csv </h1>");
    ?>
    <a href="./formulaire_1.php"><button>Retour dans le Formulaire</button></a>
</body>
</html>
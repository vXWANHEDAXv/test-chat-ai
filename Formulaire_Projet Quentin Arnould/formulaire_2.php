<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inventaire</title>
</head>
<body>
<?php

// Fonction de tri à bulles
function triBulle($tab) {
    $longueur = count($tab);
    for ($i = 0; $i < $longueur; $i++) {
        for ($j = 0; $j < $longueur - $i - 1; $j++) {
            if ($tab[$j]['designation'] > $tab[$j + 1]['designation']) {
                $temp = $tab[$j + 1];
                $tab[$j + 1] = $tab[$j];
                $tab[$j] = $temp;
            }
        }
    }
    return $tab;
}

// Lire toutes les lignes du fichier inventaire.csv pour les stocker dans un tableau
if (file_exists("inventaire.csv")){
    $fichiercsv=fopen("inventaire.csv","r");
    // ignorer la ligne d'entête
    fgets($fichiercsv);
    while(!feof($fichiercsv)){
        $ligne = fgets($fichiercsv);
        $tab_ligne = str_getcsv($ligne,";");
        if(count($tab_ligne)==4)
            $articles[] = array("designation" => $tab_ligne[0], "quantite" => $tab_ligne[1], "reference" => $tab_ligne[2], "prix" => $tab_ligne[3]);
    }
    fclose($fichiercsv);
} else {
    printf("Le fichier inventaire.csv n'existe pas");
}

// trier le tableau d'articles
$articles = triBulle($articles);

// filtrer les articles en fonction de la désignation choisie

if (isset($_GET['article']) && $_GET['article']!="default") {
    $designation = $_GET['article'];
    $articles_filtered = array();
    // filtrer les articles qui ne correspondent pas à la désignation choisie
    foreach ($articles as $article) {
        if ($article['designation'] == $designation) {
            $articles_filtered[] = $article;
        }
    }
    // si il y a des articles qui correspondent à la désignation choisie
    if (count($articles_filtered) > 0) {
        $articles = $articles_filtered;
    } else {
        echo "Aucun article ne correspond à la désignation choisie";
    }
}

// afficher le tableau d'articles
echo "<table>";
echo "<tr><th>Désignation</th><th>Quantité</th><th>Référence</th><th>Prix</th></tr>";
foreach ($articles as $article) {
    echo "<tr><td>".$article['designation']."</td><td>".$article['quantite']."</td><td>".$article['reference']."</td><td>".$article['prix']."</td></tr>";
}
echo "</table>";

// afficher le formulaire pour choisir la désignation
echo '<h1>Formulaire de filtrage :</h1>';
echo '<form method="get">';
echo '<label for="article">Désignation de l\'article :</label>';
echo '<select name="article" id="article">';
echo '<option value="default">Veuillez saisir l\'article</option>';
// Lire toutes les lignes du fichier articles.txt pour les ajouter au menu déroulant
$file = fopen("./articles.txt", "r");
while (!feof($file)) {
    $line = fgets($file);
    if(trim($line)!="")
        echo "<option value='".trim($line)."'>".trim($line)."</option>";
}
fclose($file);
echo '</select>';
echo '<input type="submit" value="Filtrer">';
echo '</form>';
?>
</body>
</html>



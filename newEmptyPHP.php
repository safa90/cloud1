<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        
<?php

require_once ('YouTube.php');
require_once ('ClientLogin.php');// on charge la librairie YouTube


// configuration et identifiants
$authenticationURL = 'https://www.google.com/youtube/accounts/ClientLogin';
$developerKey = 'AI39si6xe2EeUSkg1'; // Clé développeur
$applicationId = 'tQlU50lowGkYEO4ymSbA73ur4WKmyQbIfJfeIx5J4xe8RSbH0Z4kli7CI8'; // Identifiant de l'application
$clientId = 'tt94z18Fx5p7TLsgJuVwQ'; // Identifiant Client
$username = "safa90"; // Login de votre compte YouTube
$password = "ramzi270590"; // Mot de passe de votre compte YouTube

// authentification via la méthode HTTP
$httpClient = Zend_Gdata_ClientLogin::getHttpClient(
    $username,$password,'youtube',null,'MonSiteWeb',null,null,$authenticationURL
);

$yt = new Zend_Gdata_YouTube($httpClient, $applicationId, $clientId, $developerKey);
// fonction permettant d'afficher les informations sur une vidéo
function printVideoEntry($videoEntry)
{
    echo 'Titre : ' . $videoEntry->getVideoTitle() . "<br />\n";  
    echo 'Description: ' . $videoEntry->getVideoDescription() . "<br />\n";
    echo 'Tags: ' . implode(", ", $videoEntry->getVideoTags()) . "<br />\n";
    echo 'URL du player Flash: <a href="'. $videoEntry->getFlashPlayerUrl() .'">' 
    . $videoEntry->getFlashPlayerUrl() . "</a>\n";
}

// fonction permettant d'afficher les vidéos provenant d'un flux
function printVideoFeed($videoFeed)
{
    $count = 1;
    foreach ($videoFeed as $videoEntry) {
        echo "<p>Vidéo n°" . $count . "<br />\n";
        printVideoEntry($videoEntry);
        echo "</p> \n";
        $count++;
    }
}

// on lance la recherche sur le mot-clé "sport"
$yt = new Zend_Gdata_YouTube(); // on crée une nouvelle instance YouTube
$yt->setMajorProtocolVersion(2);
$query = $yt->newVideoQuery();
$query->setOrderBy('viewCount'); // on souhaite classer les vidéos par le nombre de lecture
$query->setTime('this_week'); // on souhaite afficher seulement les vidéos de la semaine passée
$query->setVideoQuery('sport'); // on définit le mot-clé

// on récupère un flux XML avec la liste des vidéos
$videoFeed = $yt->getVideoFeed($query->getQueryUrl(2));

// on affiche les vidéos 
printVideoFeed($videoFeed); 

?>
    </body>
</html>

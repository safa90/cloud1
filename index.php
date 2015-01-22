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
       <form action="" method="post">
                
                <input id=bt_submit type=submit value=sinscrire name=bt_submit>
             
            
        </form>
        
<?php

require_once 'Zend/Gdata/YouTube.php'; // on charge la librairie YouTube

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

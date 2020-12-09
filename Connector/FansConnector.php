<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($listPath->trackList);

    $mID=$_REQUEST["pageMID"];

    $trackList=new TrackList();
    $trackList->getTrackCountFromMember($mID);

    echo($trackList->trackCount);
?>
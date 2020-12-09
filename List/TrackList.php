<?php
    require_once(dirname(__FILE__)."/../Path.php");
    require_once($objectPath->sql);
    require_once($objectPath->track);

    class TrackList{

        public $trackCount;

        public function getTrackCountFromMember($mID){
            $mysqli=(new DBConnetor())->getMysqli();
            
            $sql = "SELECT COUNT(mID) AS trackCount
            FROM track
            WHERE trackID=?";

            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $mID);
            $stmt->execute();

            $result=$stmt->get_result();

            $row=$result->fetch_assoc();

            $this->trackCount=$row['trackCount'];
        }


    }
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
 
include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();
 
$method = $_SERVER['REQUEST_METHOD'];
switch($method) {
    case "GET":
        $sql = "SELECT * FROM emploiea";
        $path = explode('/', $_SERVER['REQUEST_URI']);
        if(isset($path[3]) && is_numeric($path[3])) {
            $sql .= " WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $path[3]);
            $stmt->execute();
            $users = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
 
        echo json_encode($users);
        break;

    case "POST":
        $user = json_decode( file_get_contents('php://input') );
        $sql = "INSERT INTO emploiea (id ,Nom,NomMatiere,	Nomclasse,	Niveau,	Specialisation	,Nomsalle	,JourSemaine,	HeureDebut	,HeureFin	) VALUES(null, :Nom, :NomMatiere, :Nomclasse, :Niveau, :Specialisation, :Nomsalle, :JourSemaine, :HeureDebut, :HeureFin)";
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':Nom', $user->Nom);
        $stmt->bindParam(':NomMatiere', $user->NomMatiere);
        $stmt->bindParam(':Nomclasse', $user->Nomclasse);
        $stmt->bindParam(':Niveau', $user->Niveau);
        $stmt->bindParam(':Specialisation', $user->Specialisation);
        $stmt->bindParam(':Nomsalle', $user->Nomsalle); 
        $stmt->bindParam(':JourSemaine', $user->JourSemaine);   
        $stmt->bindParam(':HeureDebut', $user->HeureDebut);
        $stmt->bindParam(':HeureFin', $user->HeureFin);

  
 
        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record created successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to create record.'];
        }
        echo json_encode($response);
        break;

        
    case "PUT":
        $user = json_decode( file_get_contents('php://input') );
        $sql = "UPDATE emploiea SET Nom= :Nom, NomMatiere =:NomMatiere, Nomclasse =:Nomclasse, Niveau =:Niveau , Specialisation =:Specialisation, Nomsalle =:Nomsalle , JourSemaine =:JourSemaine , HeureDebut =:HeureDebut, HeureFin =:HeureFin  WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $user->id);
        $stmt->bindParam(':Nom', $user->Nom);
        $stmt->bindParam(':NomMatiere', $user->NomMatiere);
        $stmt->bindParam(':Nomclasse', $user->Nomclasse);
        $stmt->bindParam(':Niveau', $user->Niveau);
        $stmt->bindParam(':Specialisation', $user->Specialisation);
        $stmt->bindParam(':Nomsalle', $user->Nomsalle); 
        $stmt->bindParam(':JourSemaine', $user->JourSemaine);   
        $stmt->bindParam(':HeureDebut', $user->HeureDebut);
        $stmt->bindParam(':HeureFin', $user->HeureFin);

 
        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record updated successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to update record.'];
        }
        echo json_encode($response);
        break;
 


        case "DELETE":
            $sql = "DELETE FROM emploiea WHERE id = :id";
            $path = explode('/', $_SERVER['REQUEST_URI']);
     
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $path[3]);
     
            if($stmt->execute()) {
                $response = ['status' => 1, 'message' => 'Record deleted successfully.'];
            } else {
                $response = ['status' => 0, 'message' => 'Failed to delete record.'];
            }
            echo json_encode($response);
            break;
 
   

 
    }
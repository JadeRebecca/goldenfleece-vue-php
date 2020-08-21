<?php
    //connexion à la base de données
	try
	{
        $db = new PDO('mysql:host=localhost;dbname=goldenfleece;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e)
	{
		die('Erreur : ' . $e->getMessage());
    }
    
    $result = array('error' => false);
    $action = '';

    if(isset($_GET['action'])){
        $action = $_GET['action'];
    }
	
    //récupération de la liste des membres
    if($action == 'read'){
        $members =array();
        $reponse = $db->query('SELECT * FROM argonauts');
        while ($donnees = $reponse->fetch()){
            array_push($members, $donnees); //chaque résultat est insère dans le tableau $members
        }
        $reponse->closeCursor();  //fin du traitement de la requête

        $result['members'] = $members;
    }

    if($action == 'create'){
        $name = strip_tags($_POST['name']);
        $reqInsert = $db->prepare("INSERT INTO argonauts (name) VALUES (:name)");
        $reqInsert->execute(array('name'=> $name));	
        
        if($reqInsert){
            $result['message'] = "Le membre a été ajouté!";
        }
        else{
            $result['error'] = true;
            $result['message'] = 'Echec de l\'ajout';
        }
    }

    if($action == 'delete'){
        $id = $_POST['id'];
        $reqDelete = $db->prepare("DELETE FROM argonauts WHERE id='$id'");
        $reqDelete->execute();	
        
        if($reqDelete){
            $result['message'] = "Le membre a bien été supprimé!";
        }
        else{
            $result['error'] = true;
            $result['message'] = 'Echec de la suppression du membre';
        }
    }

    echo json_encode($result);
	
?>
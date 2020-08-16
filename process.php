<?php
    //connexion à la base de données
	try
	{
		$db = new PDO('mysql:host=localhost;dbname=goldenfleece;charset=utf8', 'root', '');
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
	
	//ajout d'un nouveau membre
	/*if(isset($_POST['add'])) {
		$name = strip_tags($_POST['name']);
		$reqInsert = $db->prepare("INSERT INTO argonauts (name) VALUES (:name)");
		$reqInsert->execute(array('name'=> $name));	
	}*/
	
    //récupération de la liste des membres
    if($action == 'read'){
        $members =array();
        $reqSelect="SELECT * FROM argonauts";
        $reponse = $db->query('SELECT * FROM argonauts');
        while ($donnees = $reponse->fetch()){
            //$liste.="<div class=\"member-item\">".$donnees['name']."</div>";
            array_push($members, $donnees);
        }
        $result['members'] = $members;
    }

    if($action == 'create'){
        $name = strip_tags($_POST['name']);
        $reqInsert = $db->prepare("INSERT INTO argonauts (name) VALUES (:name)");
        $reqInsert->execute(array('name'=> $name));	
        
        if($sql){
            $result['message'] = "User added successfully!";
        }
        else{
            $result['error'] = true;
            $result['message'] = 'Failed to add';
        }
    }

    echo json_encode($result);
	//$reponse->closeCursor(); 
?>
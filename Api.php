<?php

//api url =  "http://localhost/REST/Api.php?action=";

class API
{
	private $connect = '';

	function __construct()
	{
		$this->database_connection();
	}

	function database_connection()
	{
		$this->connect = new PDO("mysql:host=localhost;dbname=Ticketing", "root", "");
	}

	function fetch_all()
	{
		$query = "SELECT * FROM Ticket_table ORDER BY id";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$data[] = $row;
			}
			return $data;
		}
	}

	function insert()
	{
		if(isset($_POST["Add"]))
		{
			$form_data = array(
				':Ticketet_name'		=>	$_POST["Ticket_name"],
				':Ticket_type'		=>	$_POST["Ticket_type"],
                ':Ticket_description'		=>	$_POST["Ticket_description"]
			);
			$query = "
			INSERT INTO Ticket_table 
			(Ticket_name, Ticket_type,Ticket_descriptions) VALUES 
			(:Ticketet_name, :Ticket_type,:Ticket_description)
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}

	function fetch_single($id)
	{
		$query = "SELECT * FROM Ticket_table WHERE id='".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			foreach($statement->fetchAll() as $row)
			{
				$data['Ticket_name'] = $row['Ticket_name'];
				$data['Ticket_type'] = $row['Ticket_type'];
                $data['Ticket_description'] = $row['Ticket_description'];
              
			}
			return $data;
		}
	}

	function update()
	{
		if(isset($_POST["Ticket_name"]))
		{
			$form_data = array(
				':Ticket_name'	=>	$_POST['Ticket_name'],
				':Ticket_type'	=>	$_POST['Ticket_type'],
                	':Ticket_descriptions'	=>	$_POST['Ticket_descriptions'],
				':id'			=>	$_POST['id']
			);
			$query = "
			UPDATE Ticket_table 
			SET Ticket_name = :Ticket_name, Ticket_type = :Ticket_type,Ticket_description = :Ticket_description
			WHERE id = :id
			";
			$statement = $this->connect->prepare($query);
			if($statement->execute($form_data))
			{
				$data[] = array(
					'success'	=>	'1'
				);
			}
			else
			{
				$data[] = array(
					'success'	=>	'0'
				);
			}
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
	function delete($id)
	{
		$query = "DELETE FROM Ticket_table WHERE id = '".$id."'";
		$statement = $this->connect->prepare($query);
		if($statement->execute())
		{
			$data[] = array(
				'success'	=>	'1'
			);
		}
		else
		{
			$data[] = array(
				'success'	=>	'0'
			);
		}
		return $data;
	}
}

?>
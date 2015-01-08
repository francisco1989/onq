<?php
/*
 *  Project : OnQ
 *  File : QAdvertisementsController.php
 *  Author : Francis Kurevija	 
 *  Created : February 16, 2014
 *  Last Modiied : February 17, 2014
 *  Description : QAdvertisementsController handles CRUD operations for the QAdvertisement model
 *					and allows an administrative user to target users with advertisements
 */

	class QadvertisementsController extends AppController 
	{
		public $helpers = array('Html', 'Form');
		
		public $uses = array('Qadvertisement'); //Uses QAdvertisement model

		/* ---------------------------------------------------------------------------------------
		*	Name	:   QAdvertisementsController -- index
		*
		*	Purpose :   Displays all advertisements in the database
		*	Inputs	:	None
		*	Outputs	:	All advertisements displayed to index.ctp
		*	Returns	:	None
		----------------------------------------------------------------------------------------*/
		public function index() 
		{
			$this->set('Qadvertisements', $this->Qadvertisement->find('all'));
		}
		
		/* ---------------------------------------------------------------------------------------
		*	Name	:   QAdvertisementsController -- view
		*
		*	Purpose :   Displays the advertisement with the ID that was passed in
		*	Inputs	:	$id - ID of the advertisement to be viewed
		*	Outputs	:	Advertisement with corresponding ID displayed in view.ctp
		*	Returns	:	None
		----------------------------------------------------------------------------------------*/
		public function view($id = null) 
		{
			//If an ID wasn't passed in
			if (!$id) {
				throw new NotFoundException(__('Invalid advertisement')); //Notify the user
			}

			//Find the first advertisement in the database that matches the ID that was passed in
			$qadvertisement = $this->Qadvertisement->find('first', array(
					'conditions' => array('Qadvertisement.advertisementID'=> $id),
					'fields' => array('Qadvertisement.advertisementID', 'Qadvertisement.advertisement')));
		
			//If no advertisement was found for the ID that was passed in
			if (!$qadvertisement) {
				throw new NotFoundException(__('Invalid advertisement')); //Notify the user
			}
			
			$this->set('Qadvertisement', $qadvertisement); //Set view model to the found advertisement
		}
		
		/* ---------------------------------------------------------------------------------------
		*	Name	:   QAdvertisementsController -- add
		*
		*	Purpose :   Allows an administrator to add an advertisment to the database
		*	Inputs	:	None
		*	Outputs	:	Displays add.ctp
		*	Returns	:	None
		----------------------------------------------------------------------------------------*/
		public function add() 
		{
			//If the request is a post, the form subitted was not empty, and the image file was successfully uploaded
			if ($this->request->is('post') &&
				!empty($this->request->params['form']['advertisement']) &&
				is_uploaded_file($this->request->params['form']['advertisement']['tmp_name']))
			{
				//Move up from 'webroot' folder (into 'app') then into 'Images' folder
				//$pathInPieces = explode('/', getcwd()); //Break the full file path into an array of strings and remove DOS-format '\'
				//$appRoot = "file:///"; //Prepend "file:///" (necessary for the web browser to reference the file)
				
				/*$appRoot = "file:///FRANCIS-PC/"; -> attempting to use shared folder for images
				for ($x = 3; $x < count($pathInPieces)-1; ++$x) ->cuts off prepended "C:\xampp\etc..." to prepend with location of shared folder*/
				
				//For each piece of the file path
				//for ($x = 0; $x < count($pathInPieces)-1; ++$x)
				//{
				//	$appRoot .= $pathInPieces[$x].'/'; //Rebuild file path with '/'s (web browsers won't read DOS-format paths)
				//}
				$appRoot = '../Images/'; //Append final piece of file path
				
				// Strip path information
				$filename = basename($this->request->params['form']['advertisement']['name']);
				
				$maxPath = 255; //Set the max length of file path to size of the column in QAdvertisements
				$allowedNameLength = $maxPath - strlen($appRoot); //Allowed length of the file name including its extension
				
				//If the file name is within the allowed number of characters
				if (strlen($filename) <= $allowedNameLength)
				{
					$buffer = $filename; //Make a copy of the file name to preserve the original
					$filenamePieces = explode('.', $buffer);
					
					//If the file name only broke into 2 pieces (2 < indicates no extension, 2 > indicates hidden extension)
					//and if no special characters are found in the file name/extension (same allowable characters as in Windows)
					if (count($filenamePieces) == 2 && !strpbrk($filenamePieces[0], '\\/:*?"<>|.'))
					{
						//Store file path and name to the request data that will be saved to the database
						$this->request->data['QAdvertisement']['advertisement'] = $appRoot.$filename;
						
						//If the save is successful
						if ($this->Qadvertisement->save($this->request->data['QAdvertisement'])) 
						{
							//Move file to OnQ Images folder
							move_uploaded_file(
								$this->request->params['form']['advertisement']['tmp_name'],
								$appRoot.$filename
							);
						
							$this->Session->setFlash(__('Your advertisement has been saved.'));
							return $this->redirect(array('action' => 'index')); //Return the user to index.ctp
						}
						else //Save failed
						{
							$this->Session->setFlash(__('Unable to save your advertisment.'));
						}
					}
					else //No file extension or more than one found/Special characters found in file name
					{
						$this->Session->setFlash(__('The file name contains unallowable characters, remove all special characters --> \\/:*?"<>|. <--
													except for the "." before the file extension (yourfile.jpeg) and try again.'));
					}
				}
				else //File path is too large for the database
				{
						$this->Session->setFlash(__('The file name entered is too long, it can be no longer than %d characters with the extension.', 
													$allowedNameLength));
				}
			}
		}
		
		/* ---------------------------------------------------------------------------------------
		*	Name	:   QAdvertisementsController -- edit
		*
		*	Purpose :   Allows an administrator to change an advertisement in the database
		*	Inputs	:	$id - ID of the advertisement to be edited
		*	Outputs	:	Advertisement with corresponding ID displayed in edit.ctp
		*	Returns	:	None
		----------------------------------------------------------------------------------------*/
		public function edit($id = null) 
		{
			//If no ID was passed in
			if (!$id) 
			{
				throw new NotFoundException(__('Invalid advertisement')); //Notify the user
			}
			
			//Find the first advertisement in the database with the passed in ID
			$qadvertisement = $this->Qadvertisement->find('first', array(
					'conditions' => array('Qadvertisement.advertisementID'=> $id),
					'fields' => array('Qadvertisement.advertisementID', 'Qadvertisement.advertisement')));
					
			//If no advertisement was found
			if (!$qadvertisement)
			{
				throw new NotFoundException(__('Invalid advertisement')); //Notify the user
			}
			
			//If the request is a post, the form subitted was not empty, and the image file was successfully uploaded
			if ($this->request->is(array('post', 'put')) &&
				!empty($this->request->params['form']['advertisement']) &&
				is_uploaded_file($this->request->params['form']['advertisement']['tmp_name']))
			{	
			
				//Move up from 'webroot' folder (into 'app') then into 'Images' folder
				//$pathInPieces = explode('\\', getcwd()); //Break the full file path into an array of strings and remove DOS-format '\'
				//$appRoot = "file:///"; //Prepend "file:///" (necessary for the web browser to reference the file)
				
				//$appRoot = "file:///FRANCIS-PC/"; -> attempting to use shared folder for images
				//for ($x = 3; $x < count($pathInPieces)-1; ++$x) ->cuts off prepended "C:\xampp\etc..." to prepend with location of shared folder
				
				//For each piece of the file path
				//for ($x = 0; $x < count($pathInPieces)-1; ++$x)
				//{
				//	$appRoot .= $pathInPieces[$x].'/'; //Rebuild file path with '/'s (web browsers won't read DOS-format paths)
				//}
				$appRoot = '../Images/'; //Append final piece of file path
				
				// Strip path information
				$filename = basename($this->request->params['form']['advertisement']['name']);
				
				$maxPath = 255; //Max characters allowed in column in Qadvertisements table
				$allowedNameLength = $maxPath - strlen($appRoot); //Max allowed characters for file name (including extension)
				
				//If the file name is within the allowed number of characters
				if (strlen($filename) <= $allowedNameLength)
				{
					$buffer = $filename; //Make a copy of the file name to preserve the original
					$filenamePieces = explode('.', $buffer);
					
					//If the file name only broke into 2 pieces (2 < indicates no extension, 2 > indicates hidden extension)
					//and if no special characters are found in the file name/extension (same allowable characters as in Windows)
					if (count($filenamePieces) == 2 && !strpbrk($filenamePieces[0], '\\/:*?"<>|.'))
					{
						$file = "'".$appRoot.$filename."'"; //Format path string to be passed in SQL query
						
						//Perform an UPDATE query
						$this->Qadvertisement->query("UPDATE `studywithonq_db`.`Qadvertisements` 
													SET `Qadvertisements`.`advertisement` = ".$file. 
													" WHERE `Qadvertisements`.`advertisementID` <= ".$id.";");
						
						//If the update succeeds
						if ($this->Qadvertisement->find('first', array('conditions' =>
														array('Qadvertisement.advertisementID'=> $id,
														'Qadvertisement.advertisement'=> $appRoot.$filename))) != NULL)
						{
							//Move file to OnQ Images folder
							move_uploaded_file(
								$this->request->params['form']['advertisement']['tmp_name'],
								$appRoot.$filename
							);
							
							//If the file exists
							if (file_exists($qadvertisement['Qadvertisement']['advertisement']))
							{
								//If the ad is not referenced in another row
								if (!$this->Qadvertisement->find(
										'first', array('conditions' => array('Qadvertisement.advertisement'=> 
										$qadvertisement['Qadvertisement']['advertisement']))))
								{
									//Reformat file path to DOS-format
									//$pathPieces = explode('file:///', $qadvertisement['Qadvertisement']['advertisement']);
									//$path = str_replace("/", "\\", $pathPieces[1]);
									//Delete the ad image
									unlink($qadvertisement['Qadvertisement']['advertisement']);
								}
							}
							$this->Session->setFlash(__('Your advertisment has been updated.'));
							return $this->redirect(array('action' => 'index')); //Return the user to index.ctp
						}
						else //Update failed
						{
							$this->Session->setFlash(__('Unable to update your advertisment.'));
						}
					}
					else  //No file extension or more than one found/Special characters found in file name
					{
						$this->Session->setFlash(__('The file name contains unallowable characters, remove all special characters --> \\/:*?"<>|. <--
													except for the "." before the file extension (yourfile.jpeg) and try again.'));
					}
				}
				else //File path is too large for the database
				{
						$this->Session->setFlash(__('The file name entered is too long, it can be no longer than %d characters with the extension.', 
													$allowedPathLength));
				}
			}

			//If there is no request data
			if (!$this->request->data) 
			{
				//Set the current advertisement to request data
				$this->request->data = $qadvertisement;
			}
		}
		
		/* ---------------------------------------------------------------------------------------
		*	Name	:   QAdvertisementsController -- delete
		*
		*	Purpose :   Deletes an advertisement from the database
		*	Inputs	:	$id - ID of the advertisement to be deleted
		*	Outputs	:	None
		*	Returns	:	None
		----------------------------------------------------------------------------------------*/
		public function delete($id) 
		{
			//If the request is a GET
			if ($this->request->is('get'))
			{
				throw new MethodNotAllowedException(); //Only POST requests are allowed to delete
			}
			
			//Find the first advertisement that matches the ID that was passed in
			$qadvertisement = $this->Qadvertisement->find('first', array(
					'conditions' => array('Qadvertisement.advertisementID'=> $id),
					'fields' => array('Qadvertisement.advertisementID', 'Qadvertisement.advertisement')));
			
			//If the delete succeeds
			if ($this->Qadvertisement->deleteAll(array('Qadvertisement.advertisementID' => $id), false)) 
			{	
				//If the file exists
				if (file_exists($qadvertisement['Qadvertisement']['advertisement']))
				{
					//If the ad is not referenced in another row
					if (!$this->Qadvertisement->find(
							'first', array('conditions' => array('Qadvertisement.advertisement'=> 
							$qadvertisement['Qadvertisement']['advertisement']))))
					{
						//Reformat file path to DOS-format
						//$pathPieces = explode('file:///', $qadvertisement['Qadvertisement']['advertisement']);
						//$path = str_replace("/", "\\", $pathPieces[1]);
						//Delete the ad image
						unlink($qadvertisement['Qadvertisement']['advertisement']);
					}
				}
				$this->Session->setFlash(__('The advertisement with id: %s has been deleted.', h($id)));
				return $this->redirect(array('action' => 'index')); //Return the user to index.ctp
			}
		}
		
		/* ---------------------------------------------------------------------------------------
		*	Name	:   QAdvertisementsController -- target
		*
		*	Purpose :   Allows an administrator to target users with an advertisement in the database
		*	Inputs	:	$id - ID of the advertisement
		*	Outputs	:	Adds target users to the advertisement
		*	Returns	:	None
		----------------------------------------------------------------------------------------*/
		/* public function target($id = null) 
		{
			//If no ID was passed in
			if (!$id) 
			{
				throw new NotFoundException(__('Invalid advertisement')); //Notify the user
			}
			
			//Find the first advertisement in the database with the passed in ID
			$qadvertisement = $this->Qadvertisement->find('first', array(
					'conditions' => array('Qadvertisement.advertisementID'=> $id),
					'fields' => array('Qadvertisement.advertisementID', 'Qadvertisement.advertisement')));
					
			//If no advertisement was found
			if (!$qadvertisement)
			{
				throw new NotFoundException(__('Invalid advertisement')); //Notify the user
			}
			
			//If the request is a post, the form subitted was not empty, and the image file was successfully uploaded
			if ($this->request->is(array('post', 'put')))// && !empty($this->request->params['form']['advertisement']))
			{	
				
			}

			//If there is no request data
			if (!$this->request->data) 
			{
				//Set the current advertisement to request data
				$this->request->data = $qadvertisement;
			}
		} */
	}
?>
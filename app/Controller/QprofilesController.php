<?php 
class QProfilesController extends AppController {

	public $helpers = array('Form');
	public $uses = array(
        'Qprofile','Qaddress'
    );
	
    public function beforeFilter() 
	{
		parent::beforeFilter();
		//debug("in filter");
		
		$this->loadModel('Qprofile','Qaddress');
		if($this->Auth->user('role')=='user' || $this->Auth->user('role')=='admin')
		{
			$this->set('role', $this->Auth->user('role')); 
			$this->Auth->allow('index','logout','view','edit');//add this line for normal users
		}
		else
		{
			$this->Auth->allow('register','login','logout');
		}
		 // Basic setup
		$this->Auth->authenticate = array('Form');

		// Pass settings in
		$this->Auth->authenticate = array(
									'Basic' => array('userModel' => 'Qprofile'),
									'Form' => array('userModel' => 'Qprofile')
		);
    }
	
	public function logout() 
	{
		debug("in logout");
		$this->Session->destroy();
		return $this->redirect($this->Auth->logout());
	}

	public function login() {
		
		if ($this->request->is('post')) 
		{
			pr(AuthComponent::password('password'));
			
			if ($this->Auth->login()) 
			{
				if (AuthComponent::user('isActive') == false)  
				{
					$this->Session->destroy();
					$this->Session->setFlash(__('Your account has been de-activated....Please contact administration'), 'error');
					return $this->redirect($this->Auth->logout());
				}
				if (isset($Qprofile['role']) && $Qprofile['role'] === 'user') 
				{
					debug("in user role");
					$this->Auth->allow('register','login','index','logout');//add this line for normal users
				}
				return $this->redirect($this->Auth->redirect());
				debug("loggedin");
			}
			
			$this->Session->setFlash(__('Invalid username or password, try again'));
		}
	}
	
	public function index() 
	{
		//debug($theName);
		//print_r(scandir("../../"));
		//logout button
		if ($this->request->is('post')) 
		{
			return $this->redirect($this->Auth->logout());
		}
	}
	
	public function add() 
	{
        if ($this->request->is('post')) 
		{
            $this->Qprofile->create();
			debug($this->Qprofile->create());
			$timezone = date_default_timezone_get();
			date_default_timezone_set($timezone);
			$date = date('Y-m-d H:i:s');
			$this->request->data['Qprofile']['dateCreated'] = $date;
			$addressID=$this->Qaddress->getLastInsertId();
			$this->request->data['Qprofile']['addressID'] = $addressID;
			
            if ($this->Qprofile->save($this->request->data)) 
			{
                $this->Session->setFlash(__('The user has been saved'));
                return $this->redirect(array('action' => 'login'));
            }
			else
			{
				debug($this->Qprofile->save($this->request->data));
				debug($this->Stock->validationErrors);
			}
				
			$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
        }
    }
	
	public function register()
	{
		if ($this->request->is('post')) 
		{
			$profiles = $this->Qprofile->find('all');
			debug($profiles);
			foreach ($profiles as $profile)
			{
				if($profile['Qprofile']['userName'] == $this->request->data['Qprofile']['userName'])
				{
					$this->Session->setFlash(__('Sorry User Name Taken!'));
					return $this->redirect(array('action' => 'register'));
				}
			}
			
			//Move up from 'webroot' folder (into 'app') then into 'Images' folder
			//$pathInPieces = explode('\\', getcwd());
			//$appRoot = "file:///";
			//for ($x = 0; $x < count($pathInPieces)-1; ++$x)
			//{
			//	$appRoot .= $pathInPieces[$x].'/';
			//}
			$appRoot = '../Images/';
			
			// Strip path information
			$filename = basename($this->request->params['form']['profilePic']['name']);
			if($filename == '')
			{
				$filename = 'nophoto.jpg';
			}
			$maxPath = 255;
			$allowedPathLength = $maxPath - strlen($appRoot);
			debug("in register");
            $this->Qprofile->create();
			$this->Qaddress->create();
			
			debug($this->Qprofile->create());
			//set role to user for general user
			//$this->request->data['Qprofile']['role'] = 'user';
			//set time created and timezone
			$timezone = date_default_timezone_get();
			date_default_timezone_set($timezone);
			$date = date('Y-m-d H:i:s');
			$this->request->data['Qprofile']['dateCreated'] = $date;
			
			$timestamp = strtotime($_POST['datepicker']);
			debug($timestamp);
			$date = date('Y-m-d', $timestamp);
			debug($date);
			$this->request->data['Qprofile']['dateOfBirth'] = $date;
			//set up isActivated field
			$activated = true;
			$this->request->data['Qprofile']['isActive'] = $activated;
			if($this->Qaddress->save($this->request->data))
			{
				$addressID=$this->Qaddress->getLastInsertId();
				$this->request->data['Qprofile']['addressID'] = $addressID;
				if (strlen($filename) <= $allowedPathLength)
				{
					$buffer = $filename;
					$filenamePieces = explode('.', $buffer);
					
					if (count($filenamePieces) == 2 && !strpbrk($filenamePieces[0], '\\/:*?"<>|.'))
					{
						//Only store path to app\Images\[image.*] in database
						$this->request->data['Qprofile']['profilePic'] = $appRoot.$filename;
						debug($this->request->data);
						if ($this->Qprofile->save($this->request->data['Qprofile'])) 
						{
							move_uploaded_file(
								$this->request->params['form']['profilePic']['tmp_name'],
								$appRoot.$filename
							);
							
							$this->Session->setFlash(__('The user has been saved'));
							return $this->redirect(array('action' => 'login'));
						}
						else
						{
							$this->Session->setFlash(__('Unable to save your profile.'));
						}
					}
					else
					{
						$this->Session->setFlash(__('The file name contains unallowable characters, remove all special characters --> \\/:*?"<>|. <--
													except for the "." before the file extension (yourfile.jpeg) and try again.'));
					}
				}
				else
				{
						$this->Session->setFlash(__('The file name entered is too long, it can be no longer than %d characters with the extension.', 
													$allowedPathLength));
				}
				
			}
			else
			{
				debug($this->Qprofile->save($this->request->data));
				debug($this->Stock->validationErrors);
			}
					
			$this->Session->setFlash(__('The user could not be saved. Please, try again.'));
		}
	}
	
    public function view($id = null) {
	
		$this->Qprofile->recursive = -1;
		$id = $this->Auth->user('profileID');
		$qprofile = $this->Qprofile->find('first',array(
		'joins' => array(
		array(
			'table' => 'Qaddresses',
			'alias' => 'QaddressJoin',
			'type' => 'INNER',
			'conditions' => array(
				'QaddressJoin.addressID = Qprofile.addressID'
			)
		),
		 array(
			'table' => 'Qprofiles',
			'alias' => 'QprofileJoin',
			'type' => 'INNER',
			'conditions' => array(
				'QprofileJoin.addressID = QaddressJoin.addressID'
			)
		)
		),
		'conditions' => array(
			'QprofileJoin.profileID'=> $id
		),
		'fields' => array('QaddressJoin.*','QprofileJoin.*')
		));
	
		$this->set('qprofile', $qprofile);
	
    }
	
	 public function edit($id = null) 
	{
		if (!$id) 
		{
			throw new NotFoundException(__('Invalid group'));
		}
		
		$qprofile =$this->Qprofile->find('first',array(
		'joins' => array(
        array(
            'table' => 'Qaddresses',
            'alias' => 'QaddressJoin',
            'type' => 'INNER',
            'conditions' => array(
                'QaddressJoin.addressID = Qprofile.addressID'
            )
        ),
		 array(
            'table' => 'Qprofiles',
            'alias' => 'QprofileJoin',
            'type' => 'INNER',
            'conditions' => array(
                'QprofileJoin.addressID = QaddressJoin.addressID'
				)
			)
		),
		'conditions' => array(
			'QprofileJoin.profileID'=> $id
		),
		'fields' => array('QaddressJoin.*','QprofileJoin.*')
		));
		debug($qprofile);
		if (!$qprofile) 
		{
			throw new NotFoundException(__('Invalid group'));
		}
		
		if ($this->request->is(array('post', 'put'))) 
		{
			$uploadedFile = $this->request->params['form']['picture']['name'];
			$tmp = $this->request->params['form']['picture']['tmp_name'];
			
			$emailAddress = $this->request->data['QprofileJoin']['emailAddress'];
			$phoneNumber = $this->request->data['QprofileJoin']['phoneNumber'];
			$firstName = $this->request->data['QprofileJoin']['firstName'];
			$lastName = $this->request->data['QprofileJoin']['lastName'];
			$unit = $this->request->data['QaddressJoin']['unit'];
			$streetNumber = $this->request->data['QaddressJoin']['streetNumber'];
			$streetName = $this->request->data['QaddressJoin']['streetName'];
			$city = $this->request->data['QaddressJoin']['city'];
			$provinceState = $this->request->data['QaddressJoin']['stateProvince'];
			$postalCode = $this->request->data['QaddressJoin']['postalCode'];
			$this->editImage($uploadedFile, $tmp,$this->data['QprofileJoin']['profileID'],$qprofile);
			
			if ($this->Qprofile->updateAll(array('Qprofile.firstName'=>"'$firstName'",'Qprofile.lastname'=>"'$lastName'",'Qprofile.emailAddress'=>"'$emailAddress'",'Qprofile.phoneNumber'=>"'$phoneNumber'"),
			array('Qprofile.profileID' => $this->data['QprofileJoin']['profileID'])))
			{
				if($this->Qaddress->updateAll(array('Qaddress.unit'=>"'$unit'",'Qaddress.streetNumber'=>"'$streetNumber'",'Qaddress.streetName'=>"'$streetName'",'Qaddress.city'=>"'$city'",	'Qaddress.stateProvince'=>"'$provinceState'",'Qaddress.postalCode'=>"'$postalCode'"),
				array('Qaddress.addressID' => $this->data['QprofileJoin']['addressID'])))
				{
					$this->Session->setFlash(__('Your group has been updated.'));
					return $this->redirect(array('action' => 'index'));
				}
			}
			else
			{
				$this->Session->setFlash(__('Unable to update your group.'));
			}
			
		}

		
		if (!$this->request->data) 
		{
			$this->request->data = $qprofile;
		}
		$this->set('qprofile', $qprofile);
    }
	
	public function viewall($id = null) {
	
			$this->set('profiles', $this->Qprofile->find('all'));
    }
	
	public function activate($id = null)
	{
		$this->Qprofile->recursive = -1;
		if (!$id) 
		{
			throw new NotFoundException(__('invalid id'));
		}

		$profile = $this->Qprofile->find('first', array(
		'conditions' => array('Qprofile.profileID'=> $id)));
		
		if (!$profile) 
		{
			throw new NotFoundException(__('Invalid profile'));
		}
		
		if ($this->request->is(array('post', 'put'))) 
		{
			if ($this->Qprofile->updateAll(array('Qprofile.isActive'=>true), array('Qprofile.profileID'=>$id)))
				{
				debug("second if");
					$this->Session->setFlash(__('The user has been activated!'));
					return $this->redirect(array('action' => 'viewall'));
				}
				else
				{
					$this->Session->setFlash(__('Unable to activate user.'));
				}
			if (!$this->request->data) 
			{
				$this->request->data = $profile;
			}
		}
	}
	
	public function deactivate($id = null) 
	{
		$this->Qprofile->recursive = -1;
		if (!$id) 
		{
			throw new NotFoundException(__('invalid id'));
		}

		$profile = $this->Qprofile->find('first', array(
		'conditions' => array('Qprofile.profileID'=> $id)));
		
		if (!$profile) 
		{
			throw new NotFoundException(__('Invalid profile'));
		}
		
		if ($this->request->is(array('post', 'put'))) 
		{
			if ($this->Qprofile->updateAll(array('Qprofile.isActive'=>false), array('Qprofile.profileID'=>$id)))
				{
				debug("second if");
					$this->Session->setFlash(__('The user has been de-activated!'));
					return $this->redirect(array('action' => 'viewall'));
				}
				else
				{
					$this->Session->setFlash(__('Unable to de-activate user.'));
				}
			if (!$this->request->data) 
			{
				$this->request->data = $profile;
			}
		}
		
    }
	
   
   public function editImage($image = null, $tmp,$pid,$qprofile)
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
		$filename = basename($image);
		
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
				$this->Qprofile->query("UPDATE `studywithonq_db`.`Qprofiles` 
											SET `Qprofiles`.`profilePic` = ".$file. 
											" WHERE `Qprofiles`.`profileID` = ".$pid.";");
				
				//If the update succeeds
				if ($this->Qprofile->find('first', array('conditions' =>
												array('Qprofile.profileID'=> $pid,
												'Qprofile.profilePic'=> $appRoot.$filename))) != NULL)
				{
					//Move file to OnQ Images folder
					move_uploaded_file(
						$tmp,
						$appRoot.$filename
					);
					
					//If the file exists
					if (file_exists($qprofile['QprofileJoin']['profilePic']))
					{
						//If the ad is not referenced in another row
						if (!$this->Qprofile->find(
								'first', array('conditions' => array('Qprofile.profilePic'=> 
								$qprofile['QprofileJoin']['profilePic']))))
						{
							//Reformat file path to DOS-format
							//$pathPieces = explode('file:///', $qprofile['QprofileJoin']['profilePic']);
							//$path = str_replace("/", "\\", $pathPieces[1]);
							//Delete the ad image
							unlink($qprofile['QprofileJoin']['profilePic']);
						}
					}
					$this->Session->setFlash(__('Your profile picture has been updated.'));
					//return $this->redirect(array('action' => 'index')); //Return the user to index.ctp
				}
				else //Update failed
				{
					$this->Session->setFlash(__('Unable to update your profile picture.'));
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
	

		//If there is no request data
		if (!$this->request->data) 
		{
			//Set the current advertisement to request data
			$this->request->data = $Qprofile;
		}
	
   }
   
	
}
?>
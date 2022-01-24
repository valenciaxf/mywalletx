<?php
//make sure rb.php is placed alongside this file. The following code will automatically create a
// table for you. All you need to do is first create a database,then provide the correct user credentials in your localhost.

	//we start by loading rb.php
    require 'rb.php';

    class Constants{
		//We specify table name. NB/= No special characters, no CamelCase letters
        static $TB_PAINTINGS = 'famouspaintings';
        //Admins are stored in a different predefined table, but in the same database. We access that table for login only.
        static $TB_USER = 'umstb';
    }

    //TYPES OF DATABASE
    //1. REMOTE DB - Hosted online. Demo app uses our hosted demo database.
	//R::setup( 'mysql:host=localhost;dbname=camposha_demos_db', 'camposha_demo_user', '9AmaFn6jpmNe8DN6' );

    //2. LOCALHOST - Hosted locally in your machine e.g XAMPP, WAMP
     R::setup( 'mysql:host=localhost;dbname=camposha_demos_db', 'walletuser', 'passPass32#.' );

    class Repository{
		        /**
         * When user attempts to login, we first check if the email is in our table or not
         */
		 
        public function doesUserExist($email){
            $sql="SELECT * FROM ".Constants::$TB_USER." WHERE email='$email'";
            $user=R::getAll($sql);
            if(count($user) > 0){
                return true;
            }else{
                return false;
            }
        }
		
        /**
         * Register User in database using the following method.
         
		*/ 
        public function registerUser($name,$email,$password,$bio,$country,$image_url){
            if($this->doesUserExist($email)){
                print(json_encode(array("code" => 2, "message"=>"This admin already Exists")));
                return;
            }
            $admin = R::dispense(Constants::$TB_USER);
            $admin->name = $name;
            $admin->country = $country;
            $admin->email = $email;
            $admin->password = $password;
            $admin->bio = $bio;
            $admin->imageUrl = $image_url;

            $id = R::store( $admin );

            if($id > 0){
                print(json_encode(array("code" => 1, "message"=>"Admin Successfully Registered.",
                 //'admin'=>$user)));
				 'admin'=>$email)));
            }else{
                print(json_encode(array("code" => 2, "message"=>"Not Registered")));
            }


        }
	

        /**
         * We now login
         */
		 
        public function login($email,$password){
            if(!$this->doesUserExist($email)){
                print(json_encode(array("code" => 2, "message"=>"This admin is not registered in the system")));
                return;
            }
            //We proceed to check password only if email is valid
            $sql="SELECT * FROM ".Constants::$TB_USER." WHERE email='$email' AND password='$password' LIMIT 1";
            $admins=R::getAll($sql);
            if(count($admins) > 0){
                print(json_encode(array("code" => 1, "message"=>"Admin Successfully Logged In.",
                 'admin'=>$admins[0])));
            }else{
                print(json_encode(array("code" => 2, "message"=>"Invalid Login Credentials.")));
            }
        }
        /**
         * The following method will allow us to upload both images and text
         */
		
        public function upload($name,$description,$author,$medium,$period,$date,$image_url){
            $p = R::dispense(Constants::$TB_PAINTINGS);
            $p->name = $name;
            $p->description = $description;
            $p->author = $author;
            $p->medium = $medium;
            $p->period = $period;
            $p->date = $date;
            $p->imageUrl = $image_url;
            $id = R::store( $p );

            if($id > 0){
                $target = "images/".basename($image_url);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    print(json_encode(array("code" => 1, "message"=>"Painting Successfully Uploaded.")));
                }else{

                    print(json_encode(array("code" => 0,"message"=>"Painting Uploaded But We were Unable to Move Image to Appropriate Folder")));
                }
            }else{
               print(json_encode(array("code" => 2, "message"=>"Not Uploaded  .")));
            }
        }
		
        /**
         * If you want to select a painting by id use the following method
         */
		 
        public function selectById($id){
            $p = R::load( Constants::$TB_PAINTINGS, $id );
            return $p;
        }
		
        /**
         * The following method will allow us to delete both images and text from
         * database and server.
         */
		
        public function update($id,$name,$description,$author,$medium,$period,$date,$image_url){
            $p = R::load( Constants::$TB_PAINTINGS, $id );
            $p->name = $name;
            $p->description = $description;
            $p->author = $author;
            $p->medium = $medium;
            $p->period = $period;
            $p->date = $date;
            $p->imageUrl = $image_url;
            $id = R::store( $p );

            if($id > 0){
                $target = "images/".basename($image_url);
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    print(json_encode(array("code" => 1, "message"=>"Painting Successfully Updated.")));
                }else{
                    print(json_encode(array("code" => 0,"message"=>"Painting Updated But We were Unable to Move Profile Image to Appropriate Folder")));
                }
            }else{
                print(json_encode(array("code" => 2,"message"=>"Painting Not Updated.")));

            }
        }
		
        /**
         * The following method will allow us to update only text data in database
         */
		
        public function updateOnlyText($id,$name,$description,$author,$medium,$period,$date){
            $p = R::load( Constants::$TB_PAINTINGS, $id );
            $p->name = $name;
            $p->description = $description;
            $p->author = $author;
            $p->medium = $medium;
            $p->period = $period;
            $p->date = $date;
            $id = R::store( $p );

            if($id > 0){
                print(json_encode(array("code" => 1, "message"=>"Painting Successfully Updated.")));
            }else{
                print(json_encode(array("code" => 2,"message"=>"Painting Not Updated.")));
            }
        }
		
        /**
         * The following method will allow us to delete both images and text
        */
		
        public function delete($id){
            $p = R::load( Constants::$TB_PAINTINGS, $id );
			
			if($p->imageUrl)
			{
						$image = "images/".$p->imageUrl;
						if (unlink($image)) {
							R::trash( $p);
							print(json_encode(array("code" => 1, "message"=>"Both Image and Text Successfully Deleted.")));
						}else{
							R::trash( $p);
							print(json_encode(array("code" => 1, "message"=>"Text Successfully Deleted.")));

						}
			} else {
					R::trash( $p);
					print(json_encode(array("code" => 1, "message"=>"Text Successfully Deleted (Painting without image).")));
				
			}
        }
		
			
        /**
         * You can use the following method to select everything from the database
         */
        public function selectAll(){
            $paintings=R::getAll( 'SELECT * FROM '.Constants::$TB_PAINTINGS);
             //print(json_encode(array('code' =>1, 'message' => 'Data Successfully Fetched','paintings'=>$paintings)));
			 echo json_encode(array('code' =>1, 'message' => 'Data Successfully Fetched','paintings'=>$paintings));
        }
		
		
		public function selectNEW(){
            $paintings=R::getAll( 'SELECT name FROM '.Constants::$TB_PAINTINGS);
             //print(json_encode(array('code' =>1, 'message' => 'Data Successfully Fetched','paintings'=>$paintings)));
             echo json_encode(array('code' =>1, 'message' => 'Data Successfully Fetched','paintings'=>$paintings));
        }
		
        /**
         * The following method will allow us to select while paginating data
         */
        
		public function selectPaged($limit,$start){
            $paintings=R::getAll( 'SELECT * FROM '.Constants::$TB_PAINTINGS. ' LIMIT '.$limit.' OFFSET '.$start );
            if(count($paintings) > 0){
                print(json_encode(array('code' =>1, 'message' => count($paintings). ' Paintings Successfully Fetched','paintings'=>$paintings)));
            }else{
                print(json_encode(array('code' =>1, 'message' => 'No more Painting Found','paintings'=>$paintings)));
            }
        }
		
        /**
         * The following method will allow us search while paginating data
         */
		
        public function search($query,$limit,$start){
            $sql="SELECT * FROM ".Constants::$TB_PAINTINGS. " WHERE name LIKE '%$query%' OR medium LIKE '%$query%' LIMIT $limit OFFSET $start ";
            $paintings=R::getAll($sql);
            //print(json_encode(array('code' =>1, 'message' => 'Search Operation Performed','paintings'=>$paintings)));
            echo json_encode(array('code' =>1, 'message' => 'Search Operation Performed','paintings'=>$paintings));
        }
		

    }

    /**
     * The below method will handle incoming HTTP requests
     */
    function handleRequest() {
        $sr=new Repository();

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (isset($_POST['action'])) {

                //Obtain the action author the user made
                $action=$_POST['action'];

                if($action == 'FETCH_WITH_PAGINATION'){
                    //To select with pagination
                    $start = $_POST['start'];
                    $limit = $_POST['limit'];
                    $sr->selectPaged($limit,$start);

                }else if ($action == 'FETCH_NEW'){
                    //To select with pagination
                    $start = $_POST['start'];
                    $limit = $_POST['limit'];
                    $sr->selectNEW();
					
                }else if($action == 'SEARCH_WITH_PAGINATION'){
                    //To search with pagination
                    $query = $_POST['query'];
                    $start = $_POST['start'];
                    $limit = $_POST['limit'];

                    $sr->search($query,$limit,$start);

				}else if($action == 'UPLOAD'){
                    //To upload both images and text
                    $name = $_POST['name'];
                    $description = $_POST['description'];
                    $author = $_POST['author'];
                    $medium = $_POST['medium'];
                    $period = $_POST['period'];
                    $date = $_POST['date'];
                    $image_url = $_FILES['image']['name'];

                    $sr->upload($name,$description,$author,$medium,$period,$date,$image_url);

                }else if($action == 'UPDATE_IMAGE_TEXT'){
                    //To update both images and text
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    $description = $_POST['description'];
                    $author = $_POST['author'];
                    $medium = $_POST['medium'];
                    $period = $_POST['period'];
                    $date = $_POST['date'];
                    $image_url = $_FILES['image']['name'];

                    $sr->update($id,$name,$description,$author,$medium,$period,$date,$image_url);

                }else if($action == 'UPDATE_ONLY_TEXT'){
                    // To update only text without images
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    $description = $_POST['description'];
                    $author = $_POST['author'];
                    $medium = $_POST['medium'];
                    $period = $_POST['period'];
                    $date = $_POST['date'];

                    $sr->updateOnlyText($id,$name,$description,$author,$medium,$period,$date);

                }else if($action == 'DELETE'){
                    //To delete we need an id
                    $id = $_POST['id'];
                    $sr->delete($id);

                }else if($action == 'LOGIN'){
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $sr->login($email,$password);

                }else{
                    //if we don't know the request the user made
					print(json_encode(array('code' =>4, 'message' => 'INVALID REQUEST.')));
				}
            }  else{   //post action...
                 //if we haven't accounted for the HTTP METHOD the user made
				print(json_encode(array('code' =>5, 'message' => 'POST TYPE UNKNOWN.')));
            }

		
		} else {	//get...


            /**
             * RedbeanPHP will create a table for you automatically if you attempt to post data from the android
             * app. Just make sure you have place this folder in the root directory of your project as follows:
             *
             * In WAMP: /www/php/art/famouspaintings/index.php
             * In XAMPP: /htdocs/php/art/famouspaintings/index.php
             *
             * In which case your url in the android app will be as follows:
             * http://your_url/php/art/famouspaintings/index.php
             * e.g for demo: https://camposha.info.php/art/famouspaintings/index.php
             *
             * Make sure you test it in browser.
             */

             /**
              * You can also create a table in your database by uncommenting the following line
              * then running in the browser:http://your_url/php/art/famouspaintings/index.php
              * Of course uncomment after the table is created.
              */
		// $sr->upload("Test Painting","The painting presents a woman in half-body portrait, which has as a backdrop a distant landscape.",
           // "Leonardo Da Vinci","Oil Painting","Modern Era","June 1889","test.jpg");

            //CREATING USERS TABLE
            /**
             * If you want to create a user table, uncomment the following line then run in the browser:
             * http://your_url/php/art/famouspaintings/index.php
             */
            //$sr->registerUser("David James","davidjames@gmail.com","123456","bio data...","USA","test.jpg");
			
			//registerUser($name,$email,$password,$bio,$country,$image_url)

            //RETURNING DATA VIA HTTP GET
            /**
             * Our app will be returning paginated data via HTTP POST requests. However you can also return
             * data via http get. For example when you call this file in the browser, that is a HTTP GET request.
             * Returning 10 items when http get is called
             */
        	//return 10 items per page
           // $sr->search('','10','0');

            //if you want to return everything then uncomment below
            $sr->selectAll();

            //$sr->delete(6);
			//$sr->selectPaged(3,1);
		}

	}	//handleRequest...
			
	
	
    handleRequest();
?>

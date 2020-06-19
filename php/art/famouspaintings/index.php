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
	//  R::setup( 'mysql:host=localhost;dbname=camposha_demos_db', 'camposha_demo_user', '9AmaFn6jpmNe8DN6' );

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
            $image = "images/".$p->imageUrl;
            if (unlink($image)) {
                R::trash( $p);
                print(json_encode(array("code" => 1, "message"=>"Both Image and Text Successfully Deleted.")));
            }else{
                R::trash( $p);
                print(json_encode(array("code" => 1, "message"=>"Text Successfully Deleted.")));

            }
        }
        /**
         * You can use the following method to select everything from the database
         */
        public function selectAll(){
            $paintings=R::getAll( 'SELECT * FROM '.Constants::$TB_PAINTINGS);
             print(json_encode(array('code' =>1, 'message' => 'Data Successfully Fetched','paintings'=>$paintings)));
        }
        /**
         * The following method will allow us to select while paginating data
         */
        public function selectPaged($limit,$start){
            $paintings=R::getAll( 'SELECT * FROM '.Constants::$TB_PAINTINGS. ' LIMIT '.$limit.' OFFSET '.$start );
            if(count($paintings) > 0){
                print(json_encode(array('code' =>1, 'message' => count($paintings)+' Planets Successfully Fetched','paintings'=>$paintings)));
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
            print(json_encode(array('code' =>1, 'message' => 'Search Operation Performed','paintings'=>$paintings)));
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
             } else{
                 //if we haven't accounted for the HTTP METHOD the user made
				print(json_encode(array('code' =>5, 'message' => 'POST TYPE UNKNOWN.')));
            }

        } else {
            //you can also create table by running the following command, then comment it
            // $sr->upload("Test Painting","The painting presents a woman in half-body portrait, which has as a backdrop a distant landscape.",
            // "Leonardo Da Vinci","Oil Painting","Modern Era","June 1889","test.jpg");

        	//return 10 items per page
            $sr->search('','10','0');

            //if you want to return everything then uncomment below
           // $sr->selectAll();


        }

    }

    handleRequest();
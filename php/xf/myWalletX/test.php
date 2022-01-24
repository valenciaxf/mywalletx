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
         * You can use the following method to select everything from the database
         */
        public function selectAll(){
            $paintings=R::getAll( 'SELECT * FROM '.Constants::$TB_PAINTINGS);
             //print(json_encode(array('code' =>1, 'message' => 'Data Successfully Fetched','paintings'=>$paintings)));
             //echo "selectAll...";
			 echo json_encode(array('code' =>1, 'message' => 'Data Successfully Fetched','paintings'=>$paintings));
        }
		

    }
    /**
     * The below method will handle incoming HTTP requests
     */
    function handleRequest() {
        $sr=new Repository();

            //if you want to return everything then uncomment below
            $sr->selectAll();
            //$sr->delete(6);
			//$sr->selectPaged(3,1);


        }

   
    handleRequest();
?>
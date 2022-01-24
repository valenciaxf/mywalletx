<?php
//make sure rb.php is placed alongside this file. The following code will automatically create a
// table for you. All you need to do is first create a database,then provide the correct user credentials in your localhost.

    //we start by loading rb.php
    require 'rb.php';

    class Constants{
        //We specify table name. NB/= No special characters, no CamelCase letters
        static $TABLE_BIGTHINKER = 'bigthinkers';
    }

    //TYPES OF DATABASE
    //1. REMOTE DB - Hosted online. Demo app uses our hosted demo database.
    //2. LOCALHOST - Hosted locally in your machine e.g XAMPP, WAMP
   // R::setup( 'mysql:host=localhost;dbname=camposha_demos_db', 'root', '' );
    R::setup( 'mysql:host=localhost;dbname=camposha_demos_db', 'walletuser', 'passPass32#.' );


    class BigThinkersManager{
        /**
         * The following method will allow us to insert a bigthinker in our database.
         */
        public function insert($name,$bio,$country,$category,$registrationDate,$period){
            $thinker = R::dispense(Constants::$TABLE_BIGTHINKER);
            $thinker->name = $name;
            $thinker->bio = $bio;
            $thinker->country = $country;
            $thinker->category = $category;
            $thinker->registrationDate = $registrationDate;
            $thinker->period = $period;

            $id = R::store( $thinker );

            if($id > 0){
                print(json_encode(array("code" => 1, "message"=>"BigThinker Successfully Registered.")));
            }else{
               print(json_encode(array("code" => 2, "message"=>"Not Saved  .")));
            }
        }
        /**
         * This is a helper method we can use to select by id.
         */
        public function selectById($id){
            $thinker = R::load( Constants::$TABLE_BIGTHINKER, $id );
            return $thinker;
        }
        /**
         * The following method will allow us to update a bigthinker
         */
        public function update($id,$name,$bio,$country,$category,$registrationDate,$period){
            $thinker = R::load( Constants::$TABLE_BIGTHINKER, $id );
            $thinker->name = $name;
            $thinker->bio = $bio;
            $thinker->country = $country;
            $thinker->category = $category;
            $thinker->registrationDate = $registrationDate;
            $thinker->period = $period;

            $id = R::store( $thinker );

            if($id > 0){
                print(json_encode(array("code" => 1, "message"=>"BigThinker Successfully Updated.", "id" => $id)));
            }else{
                print(json_encode(array("code" => 2, "message"=>"Not Updated.")));
             }
        }
        /**
         * The following method will allow us delete a bigthinker
         */
        public function delete($id){
            $thinker = R::load( Constants::$TABLE_BIGTHINKER, $id );
            R::trash( $thinker);
            print(json_encode(array('code' =>1, 'message' => 'BigThinker Successfully Deleted')));

        }
        /**
         * The following method will allow us select all our bigthinkers in the database.
         */
        public function selectAll(){
            $result=R::getAll( 'SELECT * FROM '.Constants::$TABLE_BIGTHINKER );
             print(json_encode(array('code' =>1, 'message' => 'All  Successfully Fetched','bigthinkers'=>$result)));
        }
        /**
         * The following method will allow us search and paginate our bigthinkers.
         */
        public function search($query,$start,$limit){
             $sql="SELECT * FROM ".Constants::$TABLE_BIGTHINKER." WHERE name LIKE '%$query%' OR bio LIKE '%$query%' OR country LIKE '%$query%' OR category LIKE '%$query%' LIMIT $limit OFFSET $start ";
             $result=R::getAll($sql);

             print(json_encode(array('code' =>1, 'message' => 'Successfully Fetched','bigthinkers'=>$result)));
        }

    }

    /**
     * The following method will allow us listen to and handle HTTP requestss
     */
    function handleRequest() {
        $bm=new BigThinkersManager();

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (isset($_POST['action'])) {

                //we obtain the action the user performed.
                $action=$_POST['action'];

                if($action == 'GET_BIGTHINKERS'){
                    $bm->selectAll();

				}else if($action == 'REGISTER_BIGTHINKER'){
                    $name = $_POST['name'];
                    $bio = $_POST['bio'];
                    $country = $_POST['country'];
                    $category = $_POST['category'];
                    $registrationDate = $_POST['registration_date'];
                    $period = $_POST['period'];

                    $bm->insert($name,$bio,$country,$category,$registrationDate,$period);

                }else if($action == 'UPDATE_BIGTHINKER'){
                    $id = $_POST['id'];
                    $name = $_POST['name'];
                    $bio = $_POST['bio'];
                    $country = $_POST['country'];
                    $category = $_POST['category'];
                    $registrationDate = $_POST['registration_date'];
                    $period = $_POST['period'];

                    $bm->update($id,$name,$bio,$country,$category,$registrationDate,$period);

                }else if($action == 'DELETE_BIGTHINKER'){
                    $id = $_POST['id'];
                    $bm->delete($id);
                }else if($action == 'SEARCH_BIGTHINKER'){
                    $query = $_POST['query'];
                    $start = $_POST['start'];
                    $limit = $_POST['limit'];
                    $bm->search($query,$start,$limit);
                }else{
                    print(json_encode(array('code' =>4, 'message' => 'INVALID REQUEST.We cannot identify the action you are trying to perform. ReCheck Your PHP code')));
				}
            } else{
				print(json_encode(array('code' =>5, 'message' => 'POST TYPE UNKNOWN.')));
            }
        } else{
            //you can also create table by running the following command, then comment it

            //$bm->insert("Werner Eisenberg","Werner Eisenber was german born scientist","GERMANY","PHYSICIST","2019-09-24","1870-1940");

        	//return 10 items per page
            $bm->search("",0,7);


            //if you want to return everything then uncomment below
            //$bm->selectAll();

        }

    }

    handleRequest();
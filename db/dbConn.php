<?php
date_default_timezone_set('America/Mexico_City');

define('DB_SERVER','localhost');
define('DB_USER','walletuser');
define('DB_PASS' ,'passPass32#.');
//define('DB_USER','id13563311_walletuser');
define('DB_NAME', 'mywalletx');
//define('DB_NAME', 'id13563311_mywalletx');

class dbConn
{
	function __construct()
	{
	$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
	$this->connX=$con;
	// Check connection
	if (mysqli_connect_errno())
	{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	}

	public function insertCategory($catCategory,$catDescription,$catType,$user_id)
	{
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);
		try {
							
					$catDescription=substr($catDescription, 0, 99);

							$ret=mysqli_query($this->connX,"INSERT INTO category (cat_name, cat_desc, cat_type, user_id)
															VALUES ('$catCategory', '$catDescription', '$catType', '$user_id')");
							return $ret;
				} catch (mysqli_sql_exception  $e) {
									//echo "Exception detected!";
									//echo "Error caught: " . $e->getMessage();
									$error_msg = $e->getMessage();
									$error_msg = stripslashes($error_msg);
									$error_msg = mysqli_real_escape_string($this->connX,$error_msg);
									$error_msg = substr($error_msg,0,255);
									$currentURL = substr($currentURL,0,255);

									$ret2=mysqli_query($this->connX,"INSERT INTO error_log_mwx
																										(user_id, error_msg, url, function_code)
																										VALUES ('$user_id', '$error_msg', '$currentURL','Insert Category')");
			//							$this->closeConnX();
									throw $e;
						}
		}

	public function insertSaving($savAmount,$savDescription,$user_id)
	{
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);
		try {
				$savDescription=substr($savDescription, 0, 99);

				$ret = mysqli_query($this->connX, "INSERT INTO saving (sav_amount, sav_desc,user_id)
                                    VALUES ('$savAmount', '$savDescription','$user_id')");
				return $ret;
			} catch (mysqli_sql_exception  $e) {
						//echo "Exception detected!";
						//echo "Error caught: " . $e->getMessage();
						$error_msg = $e->getMessage();
						$error_msg = stripslashes($error_msg);
						$error_msg = mysqli_real_escape_string($this->connX,$error_msg);
						$error_msg = substr($error_msg,0,255);
						$currentURL = substr($currentURL,0,255);

						$ret2=mysqli_query($this->connX,"INSERT INTO error_log_mwx
																							(user_id, error_msg, url, function_code)
																							VALUES ('$user_id', '$error_msg', '$currentURL','Insert Saving')");
//							$this->closeConnX();
						throw $e;
			}
	}

	public function insertItem($iteCategory,$iteTotalAmount,$iteQuantity,$iteDate,$iteComment,$user_id)
	{
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

				mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);
				try {
							$iteComment=substr($iteComment, 0, 99);

							$ret=mysqli_query($this->connX,"INSERT INTO item
						                                     (ite_category, ite_totalAmount, ite_quantity, ite_date, ite_comment,user_id)
			  		                                     VALUES ('$iteCategory', '$iteTotalAmount', '$iteQuantity', '$iteDate', '$iteComment','$user_id')");
							return $ret;
				} catch (mysqli_sql_exception  $e) {
					$this->recordLog  ($e,$currentURL,'Insert Item',$user_id);
				}
	}

	public function getCategory($user_id)
	{
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			mysqli_report(MYSQLI_REPORT_STRICT );
			try {
								$ret=mysqli_query($this->connX, "SELECT cat_ID,cat_name FROM category WHERE user_id='$user_id' order by 2");
							                                
								return $ret;
			} catch (mysqli_sql_exception  $e) {
				$this->recordLog  ($e,$currentURL,'Get Category',$user_id);
			}
	}

	public function authUser($username, $password)
	{
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		// To protect MySQL injection for Security purpose
		$username = stripslashes($username);
		$password = stripslashes($password);

		$username = mysqli_real_escape_string($this->connX, $username);
		$password = mysqli_real_escape_string($this->connX, $password);

		// SQL query to fetch information of registerd users and finds user match.
		$passAx=hash('sha512',$password);
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);
			try {
								$sql = "select username, user_id from login_mwx where password='$passAx' AND username='$username'";
								$ret = mysqli_query($this->connX,$sql);
								return $ret;
			} catch (mysqli_sql_exception  $e) {
				$this->recordLog  ($e,$currentURL,'Auth User',$user_id);
			}
	}

    public function getUserDetails($user_id)
    {
		$user_id = stripslashes($user_id);
		$user_id = mysqli_real_escape_string($this->connX, $user_id);
		
        $query = "SELECT user_id, username, password  FROM login_mwx WHERE user_id = '$user_id'";
        if (!$result = mysqli_query($this->connX, $query)) {
            exit(mysqli_error($this->connX));
        }
        $data = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data = $row;
            }
        }

        return $data;
	}
	
    public function getMail($user_id)
    {
		$user_id = stripslashes($user_id);
		$user_id = mysqli_real_escape_string($this->connX, $user_id);
		
        $query = "SELECT mail FROM contact_det_mwx WHERE user_id = '$user_id'";
        if (!$result = mysqli_query($this->connX, $query)) {
            exit(mysqli_error($this->connX));
        }
        $data = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data = $row;
            }
        }

        return $data;
	}
	
	public function checkCurrentPassword($current_password, $password_hash)
    {
		$current_password=$this->cleanInput($current_password);
		$passHshForUsr = hash('sha512', "$current_password");
	
        if (strcmp($passHshForUsr, $password_hash)==0) {
            return true;
		}
		else {return false; }
		//Devuelve TRUE si la contraseña y el hash coinciden, o FALSE de lo contrario.
    }
	
    public function setNewPass($id_user, $new_password)
    {
        $id_user = $this->cleanInput($id_user);
        $new_password = $this->cleanInput($new_password);
        $passHshForUsr = hash('sha512', "$new_password");

        $query = "UPDATE login_mwx SET password='$passHshForUsr' WHERE user_id = '$id_user'";
        if (!$result = mysqli_query($this->connX, $query)) {
            exit(mysqli_error($this->connX));
        }

        return true;
	}
		
	public function checkPassport($user_id)
	{
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		$isActive = 0;

		// To protect MySQL injection for Security purpose
		$user_id = stripslashes($user_id);
		$user_id = mysqli_real_escape_string($this->connX, $user_id);

					mysqli_report(MYSQLI_REPORT_STRICT);
					try {
											$sql = "select end_date as expiry_date, active from passport_mwx where user_id='$user_id' AND active=1";
											//$sql = "select end_date as expiry_date, active from passport_mwx where user_id='$user_id' AND active=1 and end_date < CURRENT_TIMESTAMP()";

											if ($result = mysqli_query($this->connX,$sql)) {
															$row_cnt = mysqli_num_rows($result);
															if ($row_cnt == 1) {
																			$rowExpiryDate = mysqli_fetch_assoc($result);
																			$expiry_date=$rowExpiryDate['expiry_date'];
																			$activeCheck=$rowExpiryDate['active'];
																			$currentDate=date('Y/m/d');

																			//$isActive = 0;
																			$date1 = new DateTime($expiry_date);
																			$date2 = new DateTime($currentDate);

																			if ($date1 < $date2) {
																				//echo nl2br("Expiry date: ".$expiry_date);
																				//echo nl2br("\r\nCurrent date: ".$currentDate);
																				//echo nl2br("\r\nCuenta expirada, actualiza tu registro.");
																				$isActive = 0;
																				session_destroy();
																			}
																			else {
																				//echo nl2br("Cuenta activa. Bienvenido!!!");
																				$isActive = 1;
																			}
															}
															else {
																//echo nl2br("Actualiza tu registro, cuenta inactiva.");
																$isActive = 0;
																session_destroy();
															}

																							//echo nl2br("\r\nrow_cnt: ".$row_cnt);

															/* close result set */
															mysqli_free_result($result);

											}
											//$this->closeConnX();
											return $isActive;
					} catch (mysqli_sql_exception  $e) {
						$this->recordLog  ($e,$currentURL,'Check Passport',$user_id);
				 }

	}


	public function closeConnX()
	{
		mysqli_close($this->connX);
	}

	public function getAvailableAmountCurrentMonth($user_id)
	{
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
								$sql = "SELECT SUM(ite_totalAmount) FROM item where ite_category in (select cat_id from category where cat_type='IN' and user_id='$user_id')
									and (year(curdate()) = year(ite_date)
									and month(curdate()) = month(ite_date)
									and user_id='$user_id')";
								$res = mysqli_query($this->connX,$sql);
								$row = mysqli_fetch_row($res);
								$sum1 = $row[0];
								$ret = $sum1;

								return $ret;
						} catch (mysqli_sql_exception  $e) {
																						//echo "Exception detected!";
																						//echo "Error caught: " . $e->getMessage();
																						$error_msg = $e->getMessage();
																						$error_msg = stripslashes($error_msg);
																						$error_msg = mysqli_real_escape_string($this->connX,$error_msg);
																						$error_msg = substr($error_msg,0,255);
																						$currentURL = substr($currentURL,0,255);

																						$ret2=mysqli_query($this->connX,"INSERT INTO error_log_mwx
																																							(user_id, error_msg, url, function_code)
																																							VALUES ('$user_id', '$error_msg', '$currentURL','getAvailableAmountCurrentMonth')");
															//							$this->closeConnX();
																						throw $e;
					 }
	}

	public function getSpentCurrentMonth($user_id)
	{
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
								//$user_id=$this->getCurrentUser($login_session);
								$sql = "SELECT SUM(ite_totalAmount) FROM item where ite_category in (select cat_id from category where cat_type='OUT' and user_id='$user_id')
										and (year(curdate()) = year(ite_date)
										and month(curdate()) = month(ite_date)
										and user_id='$user_id')";
								$res = mysqli_query($this->connX,$sql);
								$row = mysqli_fetch_row($res);
								$sum2 = $row[0];
								$ret = $sum2;

								return $ret;
		} catch (mysqli_sql_exception  $e) {
			$this->recordLog  ($e,$currentURL,'getSpentCurrentMonth',$user_id);
		}
	}

	public function getMonthLastDay()
	{
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);
		try {
								$sql = "SELECT DAY(LAST_DAY(CURDATE())) FROM dual";
								$res = mysqli_query($this->connX,$sql);
								$row = mysqli_fetch_row($res);
								$lastDay = $row[0];
								$ret = $lastDay;

								return $ret;
		} catch (mysqli_sql_exception  $e) {
			$this->recordLog  ($e,$currentURL,'getMonthLastDay',$user_id);
		}
	}

	public function getDataChart($axStartDate,$axEndDate,$user_id)
	{
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
								$sql = "SELECT cat_name, sum(ite_totalAmount) sumAx FROM
										(SELECT c.cat_name, c.cat_type, i.ite_category, i.ite_totalAmount FROM item i, category c
											WHERE i.ite_category=c.cat_ID
										AND (i.user_id=c.user_id AND i.user_id='$user_id')
										AND (i.ite_date >= '$axStartDate' AND i.ite_date <= '$axEndDate')
										) axInView
										GROUP BY cat_name
										ORDER BY 2 DESC
										";
								$res = mysqli_query($this->connX,$sql);
								$ret = $res;

								return $ret;
		} catch (mysqli_sql_exception  $e) {
			$this->recordLog  ($e,$currentURL,'Get Data Chart',$user_id);
		}
	}

	public function getDataChartSingleCat($axStartDate,$axEndDate,$axCategory,$user_id)
	{
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
								$sql = "SELECT i.ite_comment item_description,i.ite_totalAmount amount FROM item i, category c
										WHERE i.ite_category=c.cat_ID
										AND (i.user_id=c.user_id AND i.user_id='$user_id')
										AND (i.ite_date >= '$axStartDate' AND i.ite_date <= '$axEndDate')
										AND c.cat_ID='$axCategory'
										ORDER BY 2 DESC
										";
								$res = mysqli_query($this->connX,$sql);
								if (FALSE === $res) die("Select sum failed for data chart: ".mysqli_error);
								$ret = $res;
								return $ret;
		} catch (mysqli_sql_exception  $e) {
			$this->recordLog  ($e,$currentURL,'getDataChartSingleCat',$user_id);
		}
	}

//---->>darkcode for flexigrid...
	public function countRec($whereFilterDates,$whereIteCategory,$user_id) {
		$tables = "item, category";
		$where = " WHERE ite_category=cat_ID AND (item.user_id=category.user_id AND item.user_id='$user_id') $whereFilterDates $whereIteCategory";				//add user_id for multi user...

			$sqlCountSentence="SELECT count(*) FROM  $tables $where ";  //supports multi user directly in the where var...
			$result = mysqli_query($this->connX,$sqlCountSentence);
			while ($row = mysqli_fetch_array($result,MYSQLI_NUM)) {
					return $row[0];

			}
	}

	public function sumRec($sqlSumSentenceAx, $colNameAx) {
			$result = mysqli_query($this->connX,$sqlSumSentenceAx);
			$rowAX = mysqli_fetch_assoc($result);

			return $rowAX["$colNameAx"];
	}

	public function getDataFG($sortname,$sortorder,$whereFilterDates,$whereFilter2,$qtype,$mydate1,$mydate2,$page,$rp,$query,$user_id) //multi user support directly in where var...
	{
		$tables = "item, category";
		$where = " WHERE ite_category=cat_ID AND (item.user_id=category.user_id AND item.user_id='$user_id') $whereFilterDates $whereFilter2";				//add user_id for multi user...
			$sort = "ORDER BY $sortname $sortorder";
			$start = (($page-1) * $rp);

			$limit = "LIMIT $start, $rp";


			$columns = "ite_ID,cat_name,ite_totalAmount,ite_quantity,DATE_FORMAT(ite_date,'%d-%m-%Y') ite_date,ite_comment";
			//se deshabilitó $query en el flexigrid para evitar uso de %LIKE%...
			if ($query) $where = " WHERE $qtype LIKE '%".mysqli_real_escape_string($query)."%' AND ite_category=cat_ID AND ite_date >= '$mydate1' AND  ite_date <= '$mydate2' $whereFilter2";

			$sql = "SELECT $columns FROM $tables $where $sort $limit";//here...

					$result = mysqli_query($this->connX, $sql) or die (mysqli_error($this->connX));
					return $result;
	}

	public function getSumInOrOutTotal($whereFilterDates,$whereFilter2,$qtype,$query,$mydate1,$mydate2,$typeInOut,$user_id) {
		$tables = "item, category";
		$whereInOut = " WHERE cat_type='$typeInOut' AND ite_category=cat_ID AND (item.user_id=category.user_id AND item.user_id='$user_id') $whereFilterDates $whereFilter2";
			if ($query) $whereInOut = " WHERE cat_type='$typeInOut' AND $qtype LIKE '%".mysqli_real_escape_string($query)."%' AND ite_category=cat_ID AND (item.user_id=category.user_id AND item.user_id='$user_id') AND ite_date >= '$mydate1' AND  ite_date <= '$mydate2' $whereFilter2";
			$sqlSumInOut="SELECT sum(IFNULL(ite_totalAmount, 0)) as SumTotal FROM ";
			$sqlSumInOutSentence="$sqlSumInOut $tables $whereInOut";
			$sqlSumInOutTotal = $this->sumRec("$sqlSumInOutSentence", "SumTotal");
			if ($sqlSumInOutTotal==null) $sqlSumInOutTotal=0;

			return $sqlSumInOutTotal;
	}
//---->>darkcode...


	public function fetchData2PdfAndCsv($mydate1,$mydate2,$user_id)
	{
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		mysqli_report(MYSQLI_REPORT_STRICT);
		try {
								$sql="select cat_name,ite_totalAmount,ite_quantity,DATE_FORMAT(ite_date,'%d-%m-%Y') ite_date,ite_comment from (SELECT cat_name,ite_totalAmount,ite_quantity,DATE(ite_date) ite_date,ite_comment FROM category, item WHERE ite_category=cat_ID AND (item.user_id=category.user_id AND item.user_id='$user_id') AND (ite_date >= '$mydate1' AND  ite_date <= '$mydate2')) sq  order by DATE(ite_date) asc";
								$ret=mysqli_query($this->connX, $sql)
						                                or die(mysqli_error($this->connX));
								return $ret;
		} catch (mysqli_sql_exception  $e) {
			$this->recordLog  ($e,$currentURL,'fetchData2PdfAndCsv',$user_id);
		}
	}

	public function getSavingAmount($user_id)
	{
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

				mysqli_report(MYSQLI_REPORT_STRICT);
				try {
		   					$sql = "SELECT SUM(sav_amount) FROM saving USE INDEX(saving_user_id_idx) WHERE user_id='$user_id'";
								$res = mysqli_query($this->connX,$sql);
								$row = mysqli_fetch_row($res);
								$ret = $row[0];
								return $ret;

							} catch (mysqli_sql_exception  $e) {
								$this->recordLog  ($e,$currentURL,'getSavingAmount',$user_id);
							}
		}

	public function catLoader($user_id_reg)
	{
		$sqlInsertCat=$this->insertCategory('Agua','Pago de Agua','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Renta / Hipoteca','Pagos de Renta / Hipoteca','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Despensa / Supermercado','Categoría de Despensa / Supermercado','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Mantenimiento','Costos de Mantenimiento','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Seguros','Pagos de Seguros','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Obsequios / Donaciones','Categoría de Obsequios / Donaciones','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Energía','Facturación de Energía','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Educación','inversiones en Educación','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Vestimenta','Costos de Vestimenta','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Transporte','Categoría de Transporte','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Impuestos','Pagos de Impuestos','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Ingresos','Categoría de Ingresos','IN',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Otros','Otras salidas, gastos, pagos, etc','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Telefonía','Facturación de Telefonía','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Internet','Facturación de Internet','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Salud','Categoría de Salud','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Alimentos','Categoría de Alimentos','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Entretenimiento','Salidas asociadas a Entretenimiento','OUT',$user_id_reg);
		$sqlInsertCat=$this->insertCategory('Comisiones','Comisiones por Servicios','OUT',$user_id_reg);
	}

	public function auditLogon ($user_id,$username,$returncode)
	{
			$ipaddress = '';
						if($_SERVER['HTTP_X_FORWARDED_FOR'])
							$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
						else if($_SERVER['HTTP_X_FORWARDED'])
							$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
						else if($_SERVER['HTTP_FORWARDED_FOR'])
							$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
						else if($_SERVER['HTTP_FORWARDED'])
							$ipaddress = $_SERVER['HTTP_FORWARDED'];
						else if($_SERVER['REMOTE_ADDR'])
							$ipaddress = $_SERVER['REMOTE_ADDR'];
						else
							$ipaddress = 'UNKNOWN';

//echo $ipaddress;
					$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

					mysqli_report(MYSQLI_REPORT_STRICT);
					try {
							$ret = mysqli_query($this->connX, "INSERT INTO login_hist_mwx (user_id, username,host,returncode)
			                                    VALUES ('$user_id', '$username','$ipaddress','$returncode')");
							return $ret;
						} catch (mysqli_sql_exception  $e) {
							$this->recordLog  ($e,$currentURL,'Audit Logon',$user_id);
						}

	}

	public function registerUser($usrnamePrmtr,$prmtrPass,$prmtrcontact_number,$prmtrnames,$prmtrlast1,$prmtrlast2,$prmtrmail,$prmtrfb,$prmtrmonths)
	{
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);
		try {

				$usrnamePrmtr=substr($usrnamePrmtr, 0, 30);
				$fprmtrfbb=substr($prmtrfb, 0, 60);
				$prmtrmail=substr($prmtrmail, 0, 60);
				$prmtrlast1=substr($prmtrlast1, 0, 30);
				$prmtrlast2=substr($prmtrlast2, 0, 30);
				$prmtrnames=substr($prmtrnames, 0, 30);
				$prmtrcontact_number=substr($prmtrcontact_number, 0, 30);

				$usrnamePrmtr=$this->cleanInput($usrnamePrmtr);
				$fprmtrfbb=$this->cleanInput($prmtrfb);
				$prmtrmail=$this->cleanInput($prmtrmail);
				$prmtrlast1=$this->cleanInput($prmtrlast1);
				$prmtrlast2=$this->cleanInput($prmtrlast2);
				$prmtrnames=$this->cleanInput($prmtrnames);
				$prmtrcontact_number=$this->cleanInput($prmtrcontact_number);
				


							$passHshForUsr=hash('sha512',"$prmtrPass");

							$ret=mysqli_query($this->connX,"INSERT INTO login_mwx (username, password) VALUES
															('$usrnamePrmtr', '$passHshForUsr')");

							$usrIdAx=mysqli_insert_id($this->connX);
							//printf ("New Record has id %d.\n", $usrIdAx);


							$insertUsrDets ="INSERT INTO contact_det_mwx (
									  user_id,
									  contact_number,
									  names,
									  last1,
									  last2,
									  mail,
									  fb
									) VALUES ( $usrIdAx,
									  '$prmtrcontact_number',
									  '$prmtrnames',
									  '$prmtrlast1',
									  '$prmtrlast2',
									  '$prmtrmail',
									  '$prmtrfb'
									)";

							$retInsUsrDets=mysqli_query($this->connX,$insertUsrDets);

							//by default starts in current date...
							$insertUsrPssprt="INSERT INTO passport_mwx (end_date, active, user_id) VALUES
							(DATE_ADD(CURDATE(), INTERVAL '$prmtrmonths' MONTH),1, $usrIdAx)";

							$retinsertUsrPssprt=mysqli_query($this->connX,$insertUsrPssprt);

							$this->catLoader($usrIdAx);

							return $retinsertUsrPssprt;

				} catch (mysqli_sql_exception  $e) {
					$this->recordLog  ($e,$currentURL,'Register User',$user_id);
				}
		}

		public function cleanInput($value) { 
			//$bad_chars = array("{", "}", "(", ")", ";", ":", "<", ">", "/", "$"); 
			//$value = str_ireplace($bad_chars,"",$value); 
			$value = htmlentities($value); 
			$value = strip_tags($value); 
			$value = stripslashes($value);
			$value = mysqli_real_escape_string($this->connX,$value);
			return $value; 
		}

		public function recordLog ($e,$currentURL,$fncCode,$user_id) {
									//echo "Exception detected!";
									//echo "Error caught: " . $e->getMessage();
									$error_msg = $e->getMessage();
									$error_msg = stripslashes($error_msg);
									$error_msg = mysqli_real_escape_string($this->connX,$error_msg);
									$error_msg = substr($error_msg,0,255);
									$currentURL = substr($currentURL,0,255);

									$ret=mysqli_query($this->connX,"INSERT INTO error_log_mwx
																										(user_id, error_msg, url, function_code)
																										VALUES ($user_id, '$error_msg', '$currentURL','$fncCode')");
			//							$this->closeConnX();
									throw $e;		
		}
		
	public function checkIsAdmin ($user_id)
	{
		$currentURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

		// To protect MySQL injection for Security purpose
		$user_id=$this->cleanInput($user_id);

		$user_id = mysqli_real_escape_string($this->connX, $user_id);

					mysqli_report(MYSQLI_REPORT_STRICT);
					try {
											$sql = "select enabled from admin_mwx where user_id='$user_id' AND enabled=1";

											$result = mysqli_query($this->connX,$sql);
											$row_cnt = mysqli_num_rows($result);
											mysqli_free_result($result);

											return $row_cnt;
					} catch (mysqli_sql_exception  $e) {
						$this->recordLog  ($e,$currentURL,'Check isAdmin',$user_id);
				 }

	}
	

}

?>

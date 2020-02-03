<?php
date_default_timezone_set('America/Mexico_City');

define('DB_SERVER','localhost');
define('DB_USER','walletuser');
define('DB_PASS' ,'passPass32#.');
define('DB_NAME', 'mywalletx');

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
	$ret=mysqli_query($this->connX,"INSERT INTO category (cat_name, cat_desc, cat_type, user_id)
									VALUES ('$catCategory', '$catDescription', '$catType', '$user_id')");
	if (FALSE === $ret) die(" Insert category failed: ".mysqli_error($this->connX).". Please press back button to continue...");								
	return $ret;
	}

	public function insertSaving($savAmount,$savDescription,$user_id)
	{
	$ret = mysqli_query($this->connX, "INSERT INTO saving (sav_amount, sav_desc,user_id)
                                    VALUES ('$savAmount', '$savDescription','$user_id')")
                                    or die(mysqli_error($this->connX));
	return $ret;
	}

	public function insertItem($iteCategory,$iteTotalAmount,$iteQuantity,$iteDate,$iteComment,$user_id)
	{
	$ret=mysqli_query($this->connX,"INSERT INTO item
                                     (ite_category, ite_totalAmount, ite_quantity, ite_date, ite_comment,user_id)
                                     VALUES ('$iteCategory', '$iteTotalAmount', '$iteQuantity', '$iteDate', '$iteComment','$user_id')");
	return $ret;
	}

	public function getCategory($user_id)
	{
	$ret=mysqli_query($this->connX, "SELECT cat_ID,cat_name FROM category WHERE user_id='$user_id' order by 2")
                                or die(mysqli_error($this->connX));
	return $ret;
	}

	public function authUser($username, $password)
	{
		// To protect MySQL injection for Security purpose
		$username = stripslashes($username);
		$password = stripslashes($password);

		$username = mysqli_real_escape_string($this->connX, $username);
		$password = mysqli_real_escape_string($this->connX, $password);

		// SQL query to fetch information of registerd users and finds user match.
		$passAx=hash('sha512',$password);

		$sql = "select username, user_id from login_mwx where password='$passAx' AND username='$username'";
		$ret = mysqli_query($this->connX,$sql);
		return $ret;
	}
	
	public function closeConnX()
	{
		mysqli_close($this->connX);
	}

	public function getAvailableAmountCurrentMonth($user_id)
	{
		$sql = "SELECT SUM(ite_totalAmount) FROM item where ite_category in (select cat_id from category where cat_type='IN' and user_id='$user_id')
			and (year(curdate()) = year(ite_date)
			and month(curdate()) = month(ite_date) 
			and user_id='$user_id')";
		$res = mysqli_query($this->connX,$sql);
		if (FALSE === $res) die("Select sum failed: ".mysqli_error);
		$row = mysqli_fetch_row($res);
		$sum1 = $row[0];
		$ret = $sum1;

		return $ret;
	}

	public function getSpentCurrentMonth($user_id)
	{
		//$user_id=$this->getCurrentUser($login_session);
		$sql = "SELECT SUM(ite_totalAmount) FROM item where ite_category in (select cat_id from category where cat_type='OUT' and user_id='$user_id')
				and (year(curdate()) = year(ite_date)
				and month(curdate()) = month(ite_date) 
				and user_id='$user_id')";
		$res = mysqli_query($this->connX,$sql);
		if (FALSE === $res) die("Select sum failed: ".mysqli_error);
		$row = mysqli_fetch_row($res);
		$sum2 = $row[0];
		$ret = $sum2;

		return $ret;
	}

	public function getMonthLastDay()
	{
		$sql = "SELECT DAY(LAST_DAY(CURDATE())) FROM dual";
		$res = mysqli_query($this->connX,$sql);
		if (FALSE === $res) die("Getting last day failed: ".mysqli_error);
		$row = mysqli_fetch_row($res);
		$lastDay = $row[0];
		$ret = $lastDay;

		return $ret;
	}

	public function getDataChart($axStartDate,$axEndDate,$user_id)
	{
		$sql = "SELECT cat_name, sum(ite_totalAmount) sumAx FROM
				(SELECT c.cat_name, c.cat_type, i.ite_category, i.ite_totalAmount FROM item i, category c
				WHERE i.ite_category=c.cat_ID
				AND c.cat_type='OUT'
				AND (i.user_id=c.user_id AND i.user_id='$user_id')
				AND (i.ite_date >= '$axStartDate' AND i.ite_date <= '$axEndDate') 
				) axInView
				GROUP BY cat_name
				ORDER BY 2 DESC
				";
		$res = mysqli_query($this->connX,$sql);
		if (FALSE === $res) die("Select sum failed for data chart: ".mysqli_error);
		$ret = $res;

		return $ret;
	}

	public function getDataChartSingleCat($axStartDate,$axEndDate,$axCategory,$user_id)
	{
		$sql = "SELECT i.ite_comment item_description,i.ite_totalAmount amount FROM item i, category c
				WHERE i.ite_category=c.cat_ID
				AND c.cat_type='OUT'
				AND (i.user_id=c.user_id AND i.user_id='$user_id')
				AND (i.ite_date >= '$axStartDate' AND i.ite_date <= '$axEndDate')
				AND c.cat_ID='$axCategory' 
				ORDER BY 2 DESC
				";
		$res = mysqli_query($this->connX,$sql);
		if (FALSE === $res) die("Select sum failed for data chart: ".mysqli_error);
		$ret = $res;

		return $ret;
	}

	public function countRec($tables,$where) {
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

	public function getDataFG($sortname,$sortorder,$whereFilterDates,$whereFilter2,$qtype,$mydate1,$mydate2,$tables,$where,$page,$rp,$query) //multi user support directly in where var...
	{
			$sort = "ORDER BY $sortname $sortorder";
			$start = (($page-1) * $rp);

			$limit = "LIMIT $start, $rp";


			$columns = "ite_ID,cat_name,ite_totalAmount,ite_quantity,DATE_FORMAT(ite_date,'%d-%m-%Y') ite_date,ite_comment";
			if ($query) $where = " WHERE $qtype LIKE '%".mysqli_real_escape_string($query)."%' AND ite_category=cat_ID AND ite_date >= '$mydate1' AND  ite_date <= '$mydate2' $whereFilter2";

			$sql = "SELECT $columns FROM $tables $where $sort $limit";//here...

					$result = mysqli_query($this->connX, $sql) or die (mysqli_error($this->connX));
					return $result;
	}

	public function getSumINTotal($tables,$whereFilterDates,$whereFilter2,$qtype,$query,$mydate1,$mydate2,$typeInOut,$user_id) {
			$whereInOut = " WHERE cat_type='$typeInOut' AND ite_category=cat_ID AND (item.user_id=category.user_id AND item.user_id='$user_id') $whereFilterDates $whereFilter2";
			if ($query) $whereInOut = " WHERE cat_type='$typeInOut' AND $qtype LIKE '%".mysqli_real_escape_string($query)."%' AND ite_category=cat_ID AND (item.user_id=category.user_id AND item.user_id='$user_id') AND ite_date >= '$mydate1' AND  ite_date <= '$mydate2' $whereFilter2";
			$sqlSumInOut="SELECT sum(IFNULL(ite_totalAmount, 0)) as SumTotal FROM ";
			$sqlSumInOutSentence="$sqlSumInOut $tables $whereInOut"; 
			$sqlSumInOutTotal = $this->sumRec("$sqlSumInOutSentence", "SumTotal");
			if ($sqlSumInOutTotal==null) $sqlSumInOutTotal=0;

			return $sqlSumInOutTotal;
	}

	public function fetchData2PdfAndCsv($mydate1,$mydate2,$user_id)
	{
		$sql="select cat_name,ite_totalAmount,ite_quantity,DATE_FORMAT(ite_date,'%d-%m-%Y') ite_date,ite_comment from (SELECT cat_name,ite_totalAmount,ite_quantity,DATE(ite_date) ite_date,ite_comment FROM category, item WHERE ite_category=cat_ID AND (item.user_id=category.user_id AND item.user_id='$user_id') AND (ite_date >= '$mydate1' AND  ite_date <= '$mydate2')) sq  order by DATE(ite_date) asc";
		$ret=mysqli_query($this->connX, $sql)
                                or die(mysqli_error($this->connX));
		return $ret;
	}
	
	public function getSavingAmount($user_id) 
	{
		$sql = "SELECT SUM(sav_amount) FROM saving WHERE user_id='$user_id'";
		$res = mysqli_query($this->connX,$sql);
		if (FALSE === $res) die("Select sum (savings) failed: ".mysqli_error);
		$row = mysqli_fetch_row($res);
		$ret = $row[0];
		
		return $ret;
	}
	
}

?>
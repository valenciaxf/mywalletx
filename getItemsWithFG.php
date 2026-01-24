<?php
require_once('session.php');
?>
<?php
require_once('datePicker/calendar/calendar/classes/tc_calendar.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>
  <link rel="stylesheet" type="text/css" href="css/flexigrid.css">
  <script type="text/javascript" src="jquery/jquery-1.5.2.min.js"></script>
  <script type="text/javascript" src="js/flexigrid.js"></script>

  <link rel="stylesheet" type="text/css" href="css/homeFG.css">

  <script language="javascript" src="datePicker/calendar/calendar/calendar.js"></script>
  <link href="datePicker/calendar/calendar/calendar.css" rel="stylesheet" type="text/css" />
  <link href="css/styleFgResume.css" rel="stylesheet" type="text/css">

  <title>Get Items...</title>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">


  <div class="formdata">
    <div class="formtitle"> <a href='myWalletX.php'> Actualizar </a> </div>
    <div class="formbody">

      <!--<form id="sform" name="calendarform" method="post" action="getItemsWithFGFeeder.php"> -->
      <form id="calendarform" action="getItemsWithFGFeeder.php" method="post">

        <p class="largetxt"><b>Fechas de consulta </b></p>
        <div style="float: left;">
          <div style="float: left; padding-right: 3px; line-height: 18px;">Desde: </div>
          <div style="float: left;">
            <?php
            $startYearCal = date("Y") - 50;
            $endYearCal = date("Y") + 50;

            $thisweek = date('W');
            $thisyear = date('Y');

            $dayTimes = getDaysInWeek($thisweek, $thisyear);
            //----------------------------------------
            
            //$date1 = date('Y-m-d', $dayTimes[0]);
            //$date2 = date('Y-m-d', $dayTimes[(sizeof($dayTimes)-1)]);
            

            $date1 = date('d-m-Y', $dayTimes[0]);
            $date2 = date('d-m-Y', $dayTimes[(sizeof($dayTimes) - 1)]);

            function getDaysInWeek($weekNumber, $year, $dayStart = 1)
            {
              // Count from '0104' because January 4th is always in week 1
              // (according to ISO 8601).
              $time = strtotime($year . '0104 +' . ($weekNumber - 1) . ' weeks');
              // Get the time of the first day of the week
              $dayTime = strtotime('-' . (date('w', $time) - $dayStart) . ' days', $time);
              // Get the times of days 0 -> 6
              $dayTimes = array();
              for ($i = 0; $i < 7; ++$i) {
                $dayTimes[] = strtotime('+' . $i . ' days', $dayTime);
              }
              // Return timestamps for mon-sun.
              return $dayTimes;
            }


            $myCalendar = new tc_calendar("date1", true, false);
            $myCalendar->setIcon("datePicker/calendar/calendar/images/iconCalendar.gif");
            $myCalendar->setDate(date('d', strtotime($date1)), date('m', strtotime($date1)), date('Y', strtotime($date1)));
            $myCalendar->setPath("datePicker/calendar/calendar/");
            $myCalendar->setYearInterval($startYearCal, $endYearCal);
            $myCalendar->setAlignment('left', 'bottom');
            $myCalendar->setDatePair('date1', 'date2', $date2);
            $myCalendar->writeScript();
            ?>
          </div>
        </div>
        <div style="float: left;">
          <div style="float: left; padding-left: 3px; padding-right: 3px; line-height: 18px;"> Hasta: </div>
          <div style="float: left;">
            <?php
            $myCalendar = new tc_calendar("date2", true, false);
            $myCalendar->setIcon("datePicker/calendar/calendar/images/iconCalendar.gif");
            $myCalendar->setDate(date('d', strtotime($date2)), date('m', strtotime($date2)), date('Y', strtotime($date2)));
            $myCalendar->setPath("datePicker/calendar/calendar/");
            $myCalendar->setYearInterval($startYearCal, $endYearCal);
            $myCalendar->setAlignment('left', 'bottom');
            $myCalendar->setDatePair('date1', 'date2', $date1);
            $myCalendar->writeScript();

            ?>
          </div>
        </div>
        <br><br>
        <input type="submit" name="Submit1" value="Consultar" />

        <input type="hidden" name="Language" value="English">
        <input type="hidden" name="Language" value="English">

      </form>

    </div>
  </div>

  <?php
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
  if (isset($_GET['cat_ID']) && $_GET['cat_name']) {
    $cat_ID = $_GET['cat_ID'];
    $category = $_GET['cat_name'];
    $whereFilter = " AND ite_category = '$cat_ID'";
    $titulo = "Items de la categoría: $category";
  } else {
    $category = "No hay categoría seleccionada...";
    $titulo = "Todos los Items...";
  }


  ?>
  <table id="flex1" style="display:none"></table>


  <script type="text/javascript">
    function GetUrlValue(VarSearch) {
      var SearchString = window.location.search.substring(1);
      var VariableArray = SearchString.split('&');
      for (var i = 0; i < VariableArray.length; i++) {
        var KeyValuePair = VariableArray[i].split('=');
        if (KeyValuePair[0] == VarSearch) {
          return KeyValuePair[1];
        }
      }
    }

    function GetFeederURL() {
      //validation, if there is no parameter for get from URL...
      if ((GetUrlValue('cat_name') == undefined) && (GetUrlValue('cat_name') == undefined)) {
        return 'getItemsWithFGFeeder.php';
      }

      return 'getItemsWithFGFeeder.php?cat_name=' + GetUrlValue('cat_name') + '&cat_ID=' + GetUrlValue('cat_ID');
    }

  </script>

  <script type="text/javascript">

    $("#flex1").flexigrid({
      url: GetFeederURL(),
      dataType: 'json',
      colModel: [
        { display: 'Categoría', name: 'cat_name', width: 180, sortable: true, align: 'left' },
        { display: 'Monto Total', name: 'ite_totalAmount', width: 120, sortable: true, align: 'left' },
        { display: 'Cantidad', name: 'ite_quantity', width: 81, sortable: true, align: 'left', hide: true },
        { display: 'Fecha', name: 'ite_date', width: 80, sortable: true, align: 'right' },
        { display: 'Descripción', name: 'ite_comment', width: 252, sortable: true, align: 'left' }
      ],
      //searchitems : [
      //  {display: 'Descripción', name : 'ite_comment'} /*,*/

      //],
      sortname: "ite_date",
      sortorder: "desc",
      usepager: true,
      title: 'Items',
      useRp: true,
      rp: 15,
      showTableToggleBtn: true,
      width: 800,
      onSubmit: addFormData,
      //////////////////////////
      //qtype: "Category", //Search By Category...
      //query: "Transport",   //Value to Search...
      //////////////////////////
      striped: true,
      height: 200
    });

    //This function adds paramaters to the post of flexigrid. You can add a verification as well by return to false if you don't want flexigrid to submit
    function addFormData() {
      //passing a form object to serializeArray will get the valid data from all the objects, but, if the you pass a non-form object, you have to specify the input elements that the data will come from
      var dt = $('#calendarform').serializeArray();
      $("#flex1").flexOptions({ params: dt });
      return true;
    }

    $('#calendarform').submit(function () {
      $('#flex1').flexOptions({ newp: 1 }).flexReload();
      return false;
    });

  </script>
  <?
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  ?>

  <script type="application/javascript">
    function loadJSON() {
      //var data_file = GetFeederURL();
      var http_request = new XMLHttpRequest();
      try {
        // Opera 8.0+, Firefox, Chrome, Safari
        http_request = new XMLHttpRequest();
      } catch (e) {
        // Internet Explorer Browsers
        try {
          http_request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
          try {
            http_request = new ActiveXObject("Microsoft.XMLHTTP");
          } catch (e) {
            // Something went wrong
            alert("Your browser broke!");
            return false;
          }
        }
      }
      http_request.onreadystatechange = function () {
        if (http_request.readyState == 4) {
          // Javascript function JSON.parse to parse JSON data
          var jsonObj = JSON.parse(http_request.responseText);

          // jsonObj variable now contains the data structure.
          document.getElementById("sqlSumINTotal").innerHTML = jsonObj.sqlSumINTotal;
          document.getElementById("sqlSumOUTTotal").innerHTML = jsonObj.sqlSumOUTTotal;

          document.getElementById("rDates").innerHTML = "Desde: " + document.getElementById("date1").value + "      Hasta: " + document.getElementById("date2").value + "";
        }
      }
      //http_request.open("GET", data_file, true);
      //http_request.open("GET",GetFeederURL,true);
      //http_request.send();
      http_request.open("POST", GetFeederURL(), true);
      http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      http_request.send("date1=" + document.getElementById("date1").value + "&date2=" + document.getElementById("date2").value + "");
    }

  </script>

  <table class="src" style="width:100%">
    <tr>
      <th style="width:30%">Ingreso Total: <div id="sqlSumINTotal"> </div>
      </th>
      <th>Egreso Total: <div id="sqlSumOUTTotal"> </div>
      </th>
    </tr>
    <tr>
      <td></td>
      <td></td>
    </tr>
  </table>

  <div id="rDates">
  </div>

  <div id="apDivResume">
    <input type="submit" onclick="loadJSON()" value="Balance">
  </div>

  <div class="central">

</body>

</html>
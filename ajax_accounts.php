<?php
include("scripts/settings.php");
//logvalidate($_SESSION['username'], $_SERVER['SCRIPT_FILENAME']);
$q = strtoupper($_GET["term"]);
if (!$q) return;

if(isset($_REQUEST['id'])){
	$id = $_REQUEST['id'];
}
else {
	$id='';
}
$result = array();
if($id=='ac') {
	$ledger_sno = "'BANK ACCOUNTS', 'CASH IN HAND'";
	
	$sql = "select * from pl_heads where description like '".$q."%' and description in ('CASH IN HAND')"; 
	$res = execute_query(connect(), $sql);
	while($row = mysqli_fetch_array($res)) {
		array_push($result, array("id"=>$row['description'], "label"=>$row['description'], "parent" => 'CASH'));
	}
	$sql = 'select * from party_ledger where parent in ("BANK ACCOUNTS", "CASH IN HAND")';
	$res = execute_query(connect(), $sql);
	while($row = mysqli_fetch_array($res)){
		$ledger_sno .= ', '.get_child_list($row['sno']);
	}
	
	$sql = 'select * from party_ledger where sno in ('.$ledger_sno.') and ledger_name like "'.$q.'%"'; 
	$res = execute_query(connect(), $sql);
	while($row = mysqli_fetch_array($res)) {
		array_push($result, array("id"=>$row['sno'], "label"=>$row['ledger_name'], "cust_name"=>$row['ledger_name'], "parent" => $row['parent'], "opening" => $row['opening']));
	}
	}
elseif($id=='gen') {
	$sql = 'select * from party_ledger where ledger_name like "'.$q.'%"'; 
	$res = execute_query(connect(), $sql);
	while($row = mysqli_fetch_array($res)) {
		array_push($result, array("id"=>$row['sno'], "label"=>$row['ledger_name'], "cust_name"=>$row['ledger_name'], "parent" => $row['parent'], "opening" => $row['opening']));
	}
}

echo array_to_json($result);

function array_to_json( $array ){

    if( !is_array( $array ) ){
        return false;
    }

    $associative = count( array_diff( array_keys($array), array_keys( array_keys( $array )) ));
    if( $associative ){

        $construct = array();
        foreach( $array as $key => $value ){

            // We first copy each key/value pair into a staging array,
            // formatting each key and value properly as we go.

            // Format the key:
            if( is_numeric($key) ){
                $key = "key_$key";
            }
            $key = "\"".addslashes($key)."\"";

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "\"".addslashes($value)."\"";
            }

            // Add to staging array:
            $construct[] = "$key: $value";
        }

        // Then we collapse the staging array into the JSON form:
        $result = "{ " . implode( ", ", $construct ) . " }";

    } else { // If the array is a vector (not associative):

        $construct = array();
        foreach( $array as $value ){

            // Format the value:
            if( is_array( $value )){
                $value = array_to_json( $value );
            } else if( !is_numeric( $value ) || is_string( $value ) ){
                $value = "'".addslashes($value)."'";
            }

            // Add to staging array:
            $construct[] = $value;
        }

        // Then we collapse the staging array into the JSON form:
        $result = "[ " . implode( ", ", $construct ) . " ]";
    }

    return $result;
}
?>
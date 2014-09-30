<?

/**
 * Query Builder class would Build Query According to Submitted Parameters.
 
 * @author  
 * @package MVC
 * @since   1.0
 */

class QueryBuilder
{
	
	function selectQry($fieldsName, $tableName, $where = '', $sorting = '',$limit='', $groupBy='')
	{
		$qryString = "SELECT $fieldsName FROM ";
		$qryString .= "$tableName ";
		
		if($where!='')
		{
			$qryString .= "WHERE $where ";
		}
		if($groupBy!='')
		{
			$qryString .= " GROUP BY $groupBy";
		}
		if($sorting!='')
		{
			$qryString .= " ORDER BY $sorting";
		}
		
		$qryString .= " $limit";
		return $qryString;
		//unset($qryString);
	}

		  /**
     * Genrate Insert Query.
     *
     * @param tablename: table name.
     * @param attribute: attributes of table.
     * @param values: values to insert in attributes.
	 *
     * @return SQL Query, otherwise <b>NULL</b>.
     *
     * @access public
     * @since  1.0
     */
	function insertQry($tableName, $attributes, $values)
	{
		$qryString = "INSERT INTO ";
		$qryString .= "$tableName ($attributes)";
		$qryString .= " VALUES ($values)";
		return $qryString;		
	}

		  /**
     * Genrate Update Query.
     *
     * @param tablename: table name.
     * @param values: attributes/values , spreated values to update.
     * @param values: value of where condition without where Clause.
	 *
     * @return SQL Query, otherwise <b>NULL</b>.
     *
     * @access public
     * @since  1.0
     */
	 function updateQry($tableName,$values, $where='')
	{
		//$values=$this->getUpdateQry($attributes,$values);
		
		$qryString = "UPDATE $tableName SET ";
		$qryString .= "$values ";
		$qryString .= "WHERE $where";		
		return $qryString;
		//unset($qryString);
	}
	/*function updateQry($tableName, $values, $where='')
	{
		$qryString = "UPDATE $tableName SET ";
		$qryString .= "$values ";
		$qryString .= "WHERE $where";		
		return $qryString;
		//unset($qryString);
	}*/
	
		  /**
     * Genrate Delete Query.
     *
     * @param tablename: table name.
     * @param where: value of where condition without where Clause.
	 *
     * @return SQL Query, otherwise <b>NULL</b>.
     *
     * @access public
     * @since  1.0
     */
	
	function getUpdate($arr)
	{
		$count=count($arr);
		$counter=0;
		$fieldValue="";
		foreach ($arr as $key => $value) {
			 $fieldValue.="$key = '$value'";
			 if($counter<$count-1)  
			 {
				$fieldValue.=",";			 
			}
			 $counter++;
		}
		return $fieldValue;
	}	
	
	function getValue($arr)
	{
		$count=count($arr);
		$counter=0;
		foreach ($arr as $key => $value) {
		     //$field.=$key;
			 $value1.="'".trim($value)."'";
			 if($counter<$count-1)  
			 {
			 	//$field.=",";
				$value1.=",";
			 }
			 $counter++;
		}
		return $value1;
	}	
	
	function getFields($arr)
	{
		$count=count($arr);
		$counter=0;
		foreach ($arr as $key => $value) {
		     $field.="`".$key."`";
			 //$value1.="'".$value."'";
			 if($counter<$count-1)  
			 {
			 	$field.=",";
				//$value1.=",";
			 }
			 $counter++;
		}
		return $field;
	}	
	
	
	function deleteQry($tableName, $where='')
	{
		$qryString = "DELETE FROM $tableName ";		
		$qryString .= "WHERE $where";		
		return $qryString;
		//unset($qryString);
	}
	function getUpdateQry($Attributes,$Values)
	{
		$strAttributes = $Attributes;
		$strValues = $Values;
		$arrAtt = explode(",",$strAttributes );
		$arrValue = explode(",",$strValues);
		$qryUpdate = "";
		
		for ($i=0;$i<sizeof($arrAtt);$i++)
		{
			$qryUpdate .= $arrAtt[$i]."=".$arrValue[$i].",";
		}
			return substr($qryUpdate,0,strlen($qryUpdate)-1);
	}
}
?>

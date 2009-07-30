<?php
if (!defined('MSD_VERSION')) die('No direct access.');

//SQL-Library laden
include ( './inc/sqllib.php' );

if (!isset($config['sql_limit'])) $config['sql_limit']=30;
if (!isset($config['bb_width'])) $config['bb_width']=300;
if (!isset($config['bb_textcolor'])) $config['bb_textcolor']="#990033";

function ReadSQL()
{
	global $SQL_ARRAY,$config;
	$sf=$config['paths']['config'] . 'sql_statements';
	if (!is_file($sf))
	{
		$fp=fopen($sf,"w+");
		fclose($fp);
		@chmod($sf,0777);
	}
	if (count($SQL_ARRAY) == 0 && filesize($sf) > 0)
	{
		$SQL_ARRAY=file($sf);
	}
}

function WriteSQL()
{
	global $SQL_ARRAY,$config;
	$sf=$config['paths']['config'] . 'sql_statements';
	$str="";
	for ($i=0; $i < count($SQL_ARRAY); $i++)
	{
		$str.=$SQL_ARRAY[$i];
		if (substr($str,-1) != "\n" && $i != ( count($SQL_ARRAY) - 1 )) $str.="\n";
	
	}
	if ($config['magic_quotes_gpc']) $str=stripslashes($str);
	$fp=fopen($sf,"wb");
	fwrite($fp,$str);
	fclose($fp);

}

function SQL_Name($index)
{
	global $SQL_ARRAY;
	$s=explode('|',$SQL_ARRAY[$index]);
	return $s[0];
}

function SQL_String($index)
{
	global $SQL_ARRAY;
	if (isset($SQL_ARRAY[$index]) && !empty($SQL_ARRAY[$index]))
	{
		$s=explode('|',$SQL_ARRAY[$index],2);
		return ( isset($s[1]) ) ? $s[1] : '';
	}
}

function SQL_ComboBox()
{
	global $SQL_ARRAY,$tablename,$nl;
	$s='';
	if (count($SQL_ARRAY) > 0)
	{
		$s=$nl . $nl . '<select class="SQLCombo" name="sqlcombo" onchange="this.form.sqltextarea.value=this.options[this.selectedIndex].value;">' . $nl;
		$s.='<option value="" selected>---</option>' . $nl;
		for ($i=0; $i < count($SQL_ARRAY); $i++)
		{
			$s.='<option value="' . htmlspecialchars(stripslashes(SQL_String($i))) . '">' . SQL_Name($i) . '</option>' . $nl;
		}
		$s.='</select>' . $nl . $nl;
	}
	return $s;
}

function Table_ComboBox()
{
	global $db,$config,$lang,$nl;
	$tabellen=mysql_query('SHOW TABLES FROM `' . $db . '`',$config['dbconnection']);
	$num_tables=mysql_num_rows($tabellen);
	$s=$nl . $nl . '<select class="SQLCombo" name="tablecombo" onchange="this.form.sqltextarea.value=this.options[this.selectedIndex].value;this.form.execsql.click();">' . $nl . '<option value="" selected> ---  </option>' . $nl;
	for ($i=0; $i < $num_tables; $i++)
	{
		$t=mysql_fetch_row($tabellen);
		$s.='<option value="SELECT * FROM `' . $db . '`.`' . $t[0] . '`">' . $lang['table'] . ' `' . $t[0] . '`</option>' . $nl;
	}
	$s.='</select>' . $nl . $nl;
	return $s;
}

function TableComboBox($default='')
{
	global $db,$config,$lang,$nl;
	$tabellen=mysql_list_tables($db,$config['dbconnection']);
	$num_tables=mysql_num_rows($tabellen);
	$s='<option value="" ' . ( ( $default == '' ) ? 'selected' : '' ) . '>                 </option>' . $nl;
	for ($i=0; $i < $num_tables; $i++)
	{
		$t=mysql_tablename($tabellen,$i);
		$s.='<option value="`' . $t . '`"' . ( ( $default == '`' . $t . '`' ) ? 'selected' : '' ) . '>`' . $t . '`</option>' . $nl;
	}
	return $s;
}

function DB_Exists($db)
{
	global $config;
	if (!isset($config['dbconnection'])) MSD_mysql_connect();
	$erg=false;
	$dbs=mysql_list_dbs($config['dbconnection']);
	while ($row=mysql_fetch_object($dbs))
	{
		if (strtolower($row->Database) == strtolower($db))
		{
			$erg=true;
			break;
		}
	}
	return $erg;
}

function Table_Exists($db, $table)
{
	global $config;
	if (!isset($config['dbconnection'])) MSD_mysql_connect();
	$sqlt="SHOW TABLES FROM `$db`";
	$res=MSD_query($sqlt);
	if ($res)
	{
		$tables=array();
		WHILE ($row=mysql_fetch_row($res))
		{
			$tables[]=$row[0];
		}
		if (in_array($table,$tables)) return true;
	}
	return false;
}

function DB_Empty($dbn)
{
	$r="DROP DATABASE `$dbn`;\nCREATE DATABASE `$dbn`;";
	MSD_DoSQL($r);

}

function sqlReturnsRecords($sql)
{
	global $mysql_SQLhasRecords;
	$s=explode(' ',$sql);
	return in_array(strtoupper($s[0]),$mysql_SQLhasRecords) ? 1 : 0;
}

function getCountSQLStatements($sql)
{
	$z=0;
	$l=strlen($sql);
	$inQuotes=false;
	for ($i=0; $i < $l; $i++)
	{
		if ($sql[$i] == "'" || $sql[$i] == '"') $inQuotes=!$inQuotes;
		if (( $sql[$i] == ';' && $inQuotes == false ) || $i == $l - 1) $z++;
	}
	return $z;
}

function splitSQLStatements2Array($sql)
{
	$z=0;
	$sqlArr=array();
	$tmp='';
	$sql=str_replace("\n",'',$sql);
	$l=strlen($sql);
	$inQuotes=false;
	for ($i=0; $i < $l; $i++)
	{
		$tmp.=$sql[$i];
		if ($sql[$i] == "'" || $sql[$i] == '"') $inQuotes=!$inQuotes;
		if ($sql[$i] == ';' && $inQuotes == false)
		{
			$z++;
			$sqlArr[]=$tmp;
			$tmp='';
		}
	}
	if (trim($tmp) != '') $sqlArr[]=$tmp;
	return $sqlArr;
}

function DB_Copy($source, $destination, $drop_source=0, $insert_data=1)
{
	global $config;
	if (!isset($config['dbconnection'])) MSD_mysql_connect();
	$SQL_Array=$t="";
	if (!DB_Exists($destination)) $SQL_Array.="CREATE DATABASE `$destination` ;\n";
	$SQL_Array.="USE `$destination` ;\n";
	$tabellen=mysql_list_tables($source,$config['dbconnection']);
	$num_tables=mysql_num_rows($tabellen);
	for ($i=0; $i < $num_tables; $i++)
	{
		$table=mysql_tablename($tabellen,$i);
		$sqlt="SHOW CREATE TABLE `$source`.`$table`";
		$res=MSD_query($sqlt);
		$row=mysql_fetch_row($res);
		$c=$row[1];
		if (substr($c,-1) == ";") $c=substr($c,0,strlen($c) - 1);
		$SQL_Array.=( $insert_data == 1 ) ? "$c SELECT * FROM `$source`.`$table` ;\n" : "$c ;\n";
	}
	if ($drop_source == 1) $SQL_Array.="DROP DATABASE `$source` ;";
	
	mysql_select_db($destination);
	MSD_DoSQL($SQL_Array);

}

function Table_Copy($source, $destination, $insert_data, $destinationdb="")
{
	global $config;
	if (!isset($config['dbconnection'])) MSD_mysql_connect();
	$SQL_Array=$t="";
	$sqlc="SHOW CREATE TABLE $source";
	$res=MSD_query($sqlc);
	$row=mysql_fetch_row($res);
	$c=$row[1];
	$a1=strpos($c,"`");
	$a2=strpos($c,"`",$a1 + 1);
	$c=substr($c,0,$a1 + 1) . $destination . substr($c,$a2);
	if (substr($c,-1) == ";") $c=substr($c,0,strlen($c) - 1);
	$SQL_Array.=( $insert_data == 1 ) ? "$c SELECT * FROM $source ;\n" : "$c ;\n";
	//echo "<h5>$SQL_Array</h5>";
	MSD_DoSQL($SQL_Array);

}

function MSD_DoSQL($sqlcommands, $limit="")
{
	global $config,$out,$numrowsabs,$numrows,$num_befehle,$time_used,$sql;
	
	if (!isset($sql['parser']['sql_commands'])) $sql['parser']['sql_commands']=0;
	if (!isset($sql['parser']['sql_errors'])) $sql['parser']['sql_errors']=0;
	
	$sql['parser']['time_used']=getmicrotime();
	if (!isset($config['dbconnection'])) MSD_mysql_connect();
	$out=$sqlcommand='';
	$allSQL=splitSQLStatements2Array($sqlcommands); #explode(';',preg_replace('/\r\n|\n/', '', $sqlcommands));
	$sql_queries=count($allSQL);
	
	if (!isset($allSQL[$sql_queries - 1])) $sql_queries--;
	if ($sql_queries == 1)
	{
		SQLParser($allSQL[0]);
		$sql['parser']['sql_commands']++;
		$out.=Stringformat(( $sql['parser']['sql_commands'] ),4) . ': ' . $allSQL[0] . "\n";
		$result=MSD_query($allSQL[0]);
	}
	else
	{
		for ($i=0; $i < $sql_queries; $i++)
		{
			$allSQL[$i]=trim(rtrim($allSQL[$i]));
			
			if ($allSQL[$i] != "")
			{
				$sqlcommand.=$allSQL[$i];
				$sqlcommand=SQLParser($sqlcommand);
				if ($sql['parser']['start'] == 0 && $sql['parser']['end'] == 0 && $sqlcommand != '')
				{
					//sql complete
					$sql['parser']['sql_commands']++;
					$out.=Stringformat(( $sql['parser']['sql_commands'] ),4) . ': ' . $sqlcommand . "\n";
					$result=MSD_query($sqlcommand);
					$sqlcommand="";
				}
			}
		}
	}
	$sql['parser']['time_used']=getmicrotime() - $sql['parser']['time_used'];
}

function SQLParser($command, $debug=0)
{
	global $sql;
	$sql['parser']['start']=$sql['parser']['end']=0;
	$sql['parser']['sqlparts']=0;
	if (!isset($sql['parser']['drop'])) $sql['parser']['drop']=0;
	if (!isset($sql['parser']['create'])) $sql['parser']['create']=0;
	if (!isset($sql['parser']['insert'])) $sql['parser']['insert']=0;
	if (!isset($sql['parser']['update'])) $sql['parser']['update']=0;
	if (!isset($sql['parser']['comment'])) $sql['parser']['comment']=0;
	$Backslash=chr(92);
	$s=rtrim(trim(( $command )));
	
	//Was ist das für eine Anfrage ?
	if (substr($s,0,1) == "#" || substr($s,0,2) == "--")
	{
		$sql['parser']['comment']++;
		$s="";
	}
	elseif (strtoupper(substr($s,0,5)) == "DROP ")
	{
		$sql['parser']['drop']++;
	}
	elseif (strtoupper(substr($s,0,7)) == "CREATE ")
	{
		//Hier nur die Anzahl der Klammern zählen
		$sql['parser']['start']=1;
		$kl1=substr_count($s,"(");
		$kl2=substr_count($s,")");
		if ($kl2 - $kl1 == 0)
		{
			$sql['parser']['start']=0;
			$sql['parser']['create']++;
		}
	}
	elseif (strtoupper(substr($s,0,7)) == "INSERT " || strtoupper(substr($s,0,7)) == "UPDATE ")
	{
		
		if (strtoupper(substr($s,0,7)) == "INSERT ") $sql['parser']['insert']++;
		else $sql['parser']['update']++;
		$i=strpos(strtoupper($s)," VALUES") + 7;
		$st=substr($s,$i);
		$i=strpos($st,"(") + 1;
		$st=substr($st,$i);
		$st=substr($st,0,strlen($st) - 2);
		
		$tb=explode(",",$st);
		for ($i=0; $i < count($tb); $i++)
		{
			$first=$B_Esc=$B_Ticks=$B_Dashes=0;
			$v=trim($tb[$i]);
			//Ticks + Dashes zählen
			for ($cpos=2; $cpos <= strlen($v); $cpos++)
			{
				if (substr($v,( -1 * $cpos ),1) == "'")
				{
					$B_Ticks++;
				}
				else
				{
					break;
				}
			}
			for ($cpos=2; $cpos <= strlen($v); $cpos++)
			{
				if (substr($v,( -1 * $cpos ),1) == '"')
				{
					$B_Dashes++;
				}
				else
				{
					break;
				}
			}
			
			//Backslashes zählen
			for ($cpos=2 + $B_Ticks; $cpos <= strlen($v); $cpos++)
			{
				if (substr($v,( -1 * $cpos ),1) == "\\")
				{
					$B_Esc++;
				}
				else
				{
					break;
				}
			}
			
			if ($v == "NULL" && $sql['parser']['start'] == 0)
			{
				$sql['parser']['start']=1;
				$sql['parser']['end']=1;
			}
			if ($sql['parser']['start'] == 0 && is_numeric($v))
			{
				$sql['parser']['start']=1;
				$sql['parser']['end']=1;
			}
			if ($sql['parser']['start'] == 0 && substr($v,0,2) == "0X" && strpos($v," ") == false)
			{
				$sql['parser']['start']=1;
				$sql['parser']['end']=1;
			}
			if ($sql['parser']['start'] == 0 && is_object($v))
			{
				$sql['parser']['start']=1;
				$sql['parser']['end']=1;
			}
			
			if (substr($v,0,1) == "'" && $sql['parser']['start'] == 0)
			{
				$sql['parser']['start']=1;
				if (strlen($v) == 1) $first=1;
				$DELIMITER="'";
			}
			if (substr($v,0,1) == '"' && $sql['parser']['start'] == 0)
			{
				$sql['parser']['start']=1;
				if (strlen($v) == 1) $first=1;
				$DELIMITER='"';
			}
			if ($sql['parser']['start'] == 1 && $sql['parser']['end'] != 1 && $first == 0)
			{
				if (substr($v,-1) == $DELIMITER)
				{
					$B_Delimiter=( $DELIMITER == "'" ) ? $B_Ticks : $B_Dashes;
					//ist Delimiter maskiert?
					if (( $B_Esc % 2 ) == 1 && ( $B_Delimiter % 2 ) == 1 && strlen($v) > 2)
					{
						
						$sql['parser']['end']=1;
					}
					elseif (( $B_Delimiter % 2 ) == 1 && strlen($v) > 2)
					{
						//ist mit `'` maskiert
						$sql['parser']['end']=0;
					}
					elseif (( $B_Esc % 2 ) == 1)
					{
						//ist mit Backslash maskiert
						$sql['parser']['end']=0;
					}
					else
					{
						
						$sql['parser']['end']=1;
					}
				}
			}
			if ($debug == 1) echo "<font color='#0000FF'>" . $sql['parser']['start'] . "/" . $sql['parser']['end'] . "</font> Feld $i: " . htmlspecialchars($tb[$i]) . "<font color=#008000>- " . $sql['parser']['sqlparts'] . "  ($B_Ticks / $B_Esc)</font><br>";
			if ($sql['parser']['start'] == 1 && $sql['parser']['end'] == 1)
			{
				$sql['parser']['sqlparts']++;
				$sql['parser']['start']=$sql['parser']['end']=0;
			}
		}
	}
	return $s;
}

function SQLOutput($sqlcommand, $meldung='')
{
	global $sql,$lang;
	$s='<h6 align="center">' . $lang['sql_output'] . '</h6><div id="sqloutbox"><strong>';
	if ($meldung != '') $s.=$meldung;
	
	if (isset($sql['parser']['sql_commands']))
	{
		$s.='' . $sql['parser']['sql_commands'] . '</strong>' . $lang['sql_commands_in'] . round($sql['parser']['time_used'],4) . $lang['sql_commands_in2'] . '<br><br>';
		$s.=$lang['sql_out1'] . '<strong>' . $sql['parser']['drop'] . '</strong> <span style="color:#990099;font-weight:bold;">DROP</span>-, ';
		$s.='<strong>' . $sql['parser']['create'] . '</strong> <span style="color:#990099;font-weight:bold;">CREATE</span>-, ';
		$s.='<strong>' . $sql['parser']['insert'] . '</strong> <span style="color:#990099;font-weight:bold;">INSERT</span>-, ';
		$s.='<strong>' . $sql['parser']['update'] . '</strong> <span style="color:#990099;font-weight:bold;">UPDATE</span>-' . $lang['sql_out2'] . '<br>';
		$s.=$lang['sql_out3'] . '<strong>' . $sql['parser']['comment'] . '</strong> ' . $lang['sql_out4'] . '<br>';
		if ($sql['parser']['sql_commands'] < 50) $s.='<pre>' . Highlight_SQL($sqlcommand) . '</pre>';
		else $s.=$lang['sql_out5'];
	}
	elseif ($sqlcommand != '') $s.='<h5 align="center">' . $lang['sql_output'] . '</h5><pre>' . Highlight_SQL($sqlcommand) . '</pre>';
	return $s . '</div>';
}

function GetCreateTable($db, $tabelle)
{
	global $config;
	if (!isset($config['dbconnection'])) MSD_mysql_connect();
	$res=mysql_query("SHOW CREATE TABLE `$db`.`$tabelle`");
	if ($res)
	{
		$row=mysql_fetch_array($res);
		if (isset($row['Create Table'])) return $row['Create Table'];
		elseif (isset($row['Create View'])) return $row['Create View'];
		else return false;
	}
	else
		return mysql_error();

}

function KindSQL($sql)
{
	if (preg_match('@^((-- |#)[^\n]*\n|/\*.*?\*/)*(DROP|CREATE)[[:space:]]+(IF EXISTS[[:space:]]+)?(TABLE|DATABASE)[[:space:]]+(.+)@im',$sql))
	{
		return 2;
	}
	elseif (preg_match('@^((-- |#)[^\n]*\n|/\*.*?\*/)*(DROP|CREATE)[[:space:]]+(IF EXISTS[[:space:]]+)?(TABLE|DATABASE)[[:space:]]+(.+)@im',$sql))
	{
		return 1;
	}
}

function GetPostParams()
{
	global $db,$dbid,$tablename,$context,$limitstart,$order,$orderdir,$sql;
	$db=$_POST['db'];
	$dbid=$_POST['dbid'];
	$tablename=$_POST['tablename'];
	$context=$_POST['context'];
	$limitstart=$_POST['limitstart'];
	$order=$_POST['order'];
	$orderdir=$_POST['orderdir'];
	$sql['sql_statement']=( isset($_POST['sql_statement']) ) ? stripslashes(urldecode($_POST['sql_statement'])) : "SELECT * FROM `$tablename`";

}

function ComboCommandDump($when, $index)
{
	global $SQL_ARRAY,$nl,$databases,$lang;
	if (count($SQL_ARRAY) == 0)
	{
		$r='<a href="sql.php?context=1" class="uls">' . $lang['sql_befehle'] . '</a>';
		if ($when == 0) $r.='<input type="hidden" name="command_before_' . $index . '" value="">';
		else $r.='<input type="hidden" name="command_after_' . $index . '" value="">';
	}
	else
	{
		if ($when == 0)
		{
			$r='<select class="SQLCombo" name="command_before_' . $index . '">';
			$csql=$databases['command_before_dump'][$index];
		}
		else
		{
			$r='<select class="SQLCombo" name="command_after_' . $index . '">';
			$csql=$databases['command_after_dump'][$index];
		}
		
		$r.='<option value="" ' . ( ( $csql == '' ) ? ' selected="selected"' : '' ) . '>&nbsp;</option>' . "\n";
		if (count($SQL_ARRAY) > 0)
		{
			for ($i=0; $i < count($SQL_ARRAY); $i++)
			{
				$s=trim(SQL_String($i));
				$r.='<option value="' . htmlspecialchars($s) . '" ' . ( ( $csql == $s ) ? ' selected="selected"' : '' ) . '>' . SQL_Name($i) . '</option>' . "\n";
			}
		}
		$r.='</select>';
	}
	return $r;
}

function EngineCombo($default="")
{
	global $config;
	if (!$config['dbconnection']) MSD_mysql_connect();
	
	$r='<option value="" ' . ( ( $default == "" ) ? "selected" : "" ) . '></option>';
	if (!MSD_NEW_VERSION)
	{
		//BDB | HEAP | ISAM | InnoDB | MERGE | MRG_MYISAM | MYISAM
		$r.='<option value="BDB" ' . ( ( "BDB" == $default ) ? "selected" : "" ) . '>BDB</option>';
		$r.='<option value="HEAP" ' . ( ( "HEAP" == $default ) ? "selected" : "" ) . '>HEAP</option>';
		$r.='<option value="ISAM" ' . ( ( "ISAM" == $default ) ? "selected" : "" ) . '>ISAM</option>';
		$r.='<option value="InnoDB" ' . ( ( "InnoDB" == $default ) ? "selected" : "" ) . '>InnoDB</option>';
		$r.='<option value="MERGE" ' . ( ( "MERGE" == $default ) ? "selected" : "" ) . '>MERGE</option>';
		$r.='<option value="MRG_MYISAM" ' . ( ( "MRG_MYISAM" == $default ) ? "selected" : "" ) . '>MRG_MYISAM</option>';
		$r.='<option value="MYISAM" ' . ( ( "MyISAM" == $default ) ? "selected" : "" ) . '>MyISAM</option>';
	}
	else
	{
		$res=mysql_query("SHOW ENGINES");
		$num=mysql_num_rows($res);
		for ($i=0; $i < $num; $i++)
		{
			$row=mysql_fetch_array($res);
			$r.='<option value="' . $row['Engine'] . '" ' . ( ( $row['Engine'] == $default ) ? "selected" : "" ) . '>' . $row['Engine'] . '</option>';
		}
	}
	return $r;
}

function CharsetCombo($default="")
{
	global $config;
	if (!MSD_NEW_VERSION)
	{
		return "";
	}
	else
	{
		if (!isset($config['dbconnection'])) MSD_mysql_connect();
		$res=mysql_query("SHOW Charset");
		$num=mysql_num_rows($res);
		$r='<option value="" ' . ( ( $default == "" ) ? "selected" : "" ) . '></option>';
		$charsets=array();
		for ($i=0; $i < $num; $i++)
		{
			$charsets[]=mysql_fetch_array($res);
		}
		
		if (is_array($charsets))
		{
			$charsets=mu_sort($charsets,'Charset');
			foreach ($charsets as $row)
			{
				$r.='<option value="' . $row['Charset'] . '" ' . ( ( $row['Charset'] == $default ) ? "selected" : "" ) . '>' . $row['Charset'] . '</option>';
			}
		}
		return $r;
	}
}

function GetCollationArray()
{
	global $config;
	if (!isset($config['dbconnection'])) MSD_mysql_connect();
	
	$res=mysql_query("SHOW Collation");
	$num=@mysql_num_rows($res);
	$r=Array();
	if (is_array($r))
	{
		for ($i=0; $i < $num; $i++)
		{
			$row=mysql_fetch_array($res);
			$r[$i]['Collation']=isset($row['Collation']) ? $row['Collation'] : '';
			$r[$i]['Charset']=isset($row['Charset']) ? $row['Charset'] : '';
			$r[$i]['Id']=isset($row['Id']) ? $row['Id'] : '';
			$r[$i]['Default']=isset($row['Default']) ? $row['Default'] : '';
			$r[$i]['Compiled']=isset($row['Compiled']) ? $row['Compiled'] : '';
			$r[$i]['Sortlen']=isset($row['Sortlen']) ? $row['Sortlen'] : '';
		}
	}
	return $r;
}

function CollationCombo($default="", $withcharset=0)
{
	if (!MSD_NEW_VERSION)
	{
		return "";
	}
	else
	{
		$r=GetCollationArray();
		sort($r);
		$s="";
		$s='<option value="" ' . ( ( $default == "" ) ? "selected" : "" ) . '></option>';
		$group="";
		for ($i=0; $i < count($r); $i++)
		{
			$gc=$r[$i]['Charset'];
			if ($gc != $group)
			{
				$group=$gc;
				if ($i > 0) $s.='</optgroup>';
				$s.='<optgroup label="' . $group . '">';
			}
			$s.='<option value="' . ( ( $withcharset == 1 ) ? $group . '|' : '' ) . $r[$i]['Collation'] . '" ' . ( ( $r[$i]['Collation'] == $default ) ? "selected" : "" ) . '>' . $r[$i]['Collation'] . '</option>';
		}
		return $s . '</optgroup>';
	}
}

function AttributeCombo($default="")
{
	$s='<option value="" ' . ( ( $default == "" ) ? "selected" : "" ) . '></option>';
	$s.='<option value="unsigned" ' . ( ( $default == "unsigned" ) ? "selected" : "" ) . '>unsigned</option>';
	$s.='<option value="unsigned zerofill" ' . ( ( $default == "unsigned zerofill" ) ? "selected" : "" ) . '>unsigned zerofill</option>';
	return $s;

}

function simple_bbcode_conversion($a)
{
	global $config;
	$tag_start='';
	$tag_end='';
	
	//replacements
	$a=nl2br($a);
	$a=str_replace('<br>',' <br>',$a);
	$a=str_replace('<br />',' <br>',$a);
	
	$a=preg_replace("/\[url=(.*?)\](.*?)\[\/url\]/si","<a class=\"small\"  href=\"$1\" target=\"blank\">$2</a>",$a);
	$a=preg_replace("/\[urltargetself=(.*?)\](.*?)\[\/urltargetself\]/si","<a class=\"small\"  href=\"$1\" target=\"blank\">$2</a>",$a);
	$a=preg_replace("/\[url\](.*?)\[\/url\]/si","<a class=\"small\"  href=\"$1\" target=\"blank\">$1</a>",$a);
	$a=preg_replace("/\[ed2k=\+(.*?)\](.*?)\[\/ed2k\]/si","<a class=\"small\"  href=\"$1\" target=\"blank\">$2</a>",$a);
	$a=preg_replace("/\[ed2k=(.*?)\](.*?)\[\/ed2k\]/si","<a class=\"small\"  href=\"$1\" target=\"blank\">$2</a>",$a);
	
	$a=preg_replace("/\[center\](.*?)\[\/center\]/si","<div align=\"center\">$1</div>",$a);
	$a=preg_replace("/\[size=([1-2]?[0-9])\](.*?)\[\/size\]/si","<span style=\"font-size=$1px;\">$2</span>",$a);
	$a=preg_replace("/\[size=([1-2]?[0-9]):(.*?)\](.*?)\[\/size(.*?)\]/si","<span style=\"font-size=$1px;\">$3</span>",$a);
	$a=preg_replace("/\[font=(.*?)\](.*?)\[\/font\]/si","<span style=\"font-family:$1;\">$2</span>",$a);
	$a=preg_replace("/\[color=(.*?)\](.*?)\[\/color\]/si","<span style=\"color=$1;\">$2</span>",$a);
	$a=preg_replace("/\[color=(.*?):(.*?)\](.*?)\[\/color(.*?)\]/si","<span style=\"color=$1;\">$3</span>",$a);
	$a=preg_replace("/\[img\](.*?)\[\/img\]/si","<img src=\"$1\" vspace=4 hspace=4>",$a);
	//$a=preg_replace("/\[b\](.*?)\[\/b\]/si", "<strong>$1</strong>", $a);
	$a=preg_replace("/\[b(.*?)\](.*?)\[\/b(.*?)\]/si","<strong>$2</strong>",$a);
	//$a=preg_replace("/\[u\](.*?)\[\/u\]/si", "<u>$1</u>", $a);
	$a=preg_replace("/\[u(.*?)\](.*?)\[\/u(.*?)\]/si","<u>$2</u>",$a);
	//$a=preg_replace("/\[i\](.*?)\[\/i\]/si", "<em>$1</em>", $a);
	$a=preg_replace("/\[i(.*?)\](.*?)\[\/i(.*?)\]/si","<em>$2</em>",$a);
	//$a=preg_replace("/\[quote\](.*?)\[\/quote\]/si", "<p align=\"left\" style=\"border: 2px solid silver;padding:4px;\">$1</p>", $a);
	$a=preg_replace("/\[quote(.*?)\](.*?)\[\/quote(.*?)\]/si","<p align=\"left\" style=\"border: 2px solid silver;padding:4px;\">$2</p>",$a);
	$a=preg_replace("/\[code(.*?)\](.*?)\[\/code(.*?)\]/si","<p align=\"left\" style=\"border: 2px solid red;color:green;padding:4px;\">$2</p>",$a);
	$a=preg_replace("/\[hide\](.*?)\[\/hide\]/si","<div style=\"background-color:#ccffcc;\">$1</div>",$a);
	$a=preg_replace("/(^|\s)+((http:\/\/)|(www.))(.+)(\s|$)+/Uis"," <a href=\"http://$4$5\" target=\"_blank\">http://$4$5</a> ",$a);
	return $tag_start . $a . $tag_end;
}

function ExtractTablenameFromSQL($q)
{
	global $databases,$db,$dbid;
	$tablename='';
	if (strlen($q) > 100) $q=substr(0,100,$q);
	$p=trim($q);
	// if we get a list of tables - no current table is selected -> return ''
	if (strtoupper(substr($q,0,17)) == 'SHOW TABLE STATUS') return '';
	// check for SELECT-Statement to extract tablename after FROM
	if (strtoupper(substr($p,0,7)) == 'SELECT ')
	{
		$parts=array();
		$p=substr($p,strpos(strtoupper($p),'FROM') + 5);
		$parts=explode(' ',$p);
		$p=$parts[0];
	}
	$suchen=array(
				
				'SHOW ', 
				'SELECT', 
				'DROP', 
				'INSERT', 
				'UPDATE', 
				'DELETE', 
				'CREATE', 
				'TABLE', 
				'STATUS', 
				'FROM', 
				'*'
	);
	$ersetzen=array(
					
					'', 
					'', 
					'', 
					'', 
					'', 
					'', 
					'', 
					'', 
					'', 
					'', 
					''
	);
	$cleaned=trim(str_ireplace($suchen,$ersetzen,$p));
	$tablename=$cleaned;
	if (strpos($cleaned,' ')) $tablename=substr($cleaned,0,strpos($cleaned,' '));
	$tablename=str_replace('`','',$tablename); // remove backticks
	// take care of db-name.tablename
	if (strpos($tablename,'.'))
	{
		$p=explode('.',$tablename);
		$databases['db_actual']=$p[0];
		// if database is changed in Query we need to get the index of the actual db
		$db_temp=array_flip($databases['Name']);
		if (isset($db_temp[$databases['db_actual']]))
		{
			$databases['db_selected_index']=$db_temp[$databases['db_actual']];
			$dbid=$databases['db_selected_index'];
		}
		if (isset($_GET['tablename'])) unset($_GET['tablename']);
		//echo "<br>" . $db;
		$tablename=$p[1];
	}
	//	if (Table_Exists($databases['db_actual'],$tablename)) return $tablename;
	//	else return '';
	return $tablename;
}

function GetOptionsCombo($arr, $default)
{
	global $feldtypen,$feldattribute,$feldnull,$feldextras,$feldkeys,$feldrowformat;
	$r='';
	foreach ($arr as $s)
	{
		$r.='<option value="' . $s . '" ' . ( ( strtoupper($default) == strtoupper($s) ) ? "selected" : "" ) . '>' . $s . '</option>' . "\n";
	}
	return $r;
}

function make_options($arr, $selected)
{
	$r='';
	foreach ($arr as $key=>$val)
	{
		$r.='<option value="' . $key . '"';
		if ($key == $selected) $r.=' selected';
		$r.='>' . $val . '</option>' . "\n";
	}
	return $r;
}

function FillFieldinfos($db, $tabelle)
{
	global $config;
	$fields_infos=Array();
	$t=GetCreateTable($db,$tabelle);
	$sqlf="SHOW FULL FIELDS FROM `$db`.`$tabelle`;";
	$res=MSD_query($sqlf);
	$anz_fields=mysql_num_rows($res);
	
	for ($i=0; $i < $anz_fields; $i++)
	{
		// define defaults
		$fields_infos[$i]['name']='';
		$fields_infos[$i]['size']='';
		$fields_infos[$i]['default']='';
		$fields_infos[$i]['extra']='';
		$fields_infos[$i]['attribut']='';
		$fields_infos[$i]['null']='';
		
		$row=mysql_fetch_array($res);
		$fields_infos[$i]['collate']=isset($row['Collation']) ? $row['Collation'] : '';
		if (isset($row['COLLATE'])) $fields_infos[$i]['collate']=$row['COLLATE']; // MySQL <4.1
		if (isset($row['Comment'])) $fields_infos[$i]['comment']=$row['Comment'];
		$fields_infos[$i]['privileges']=$row['Privileges'];
		$fields_infos[$i]['type']=$row['Type'];
		if (isset($row['Field'])) $fields_infos[$i]['name']=$row['Field'];
		if (isset($row['Size'])) $fields_infos[$i]['size']=$row['Size'];
		if (isset($row['NULL'])) $fields_infos[$i]['null']=$row['NULL'];
		if (isset($row['Default'])) $fields_infos[$i]['default']=$row['Default'];
		if (isset($row['extra'])) $fields_infos[$i]['extra']=$row['Extra'];
		if (isset($row['key'])) $fields_infos[$i]['key']=$row['Key'];
	}
	$fields_infos['_primarykey_']="";
	$flds=$keys=$ukeys=$fkeys=0;
	$fields_infos['_createtable_']=$t;
	$tmp=explode("\n",$t);
	for ($i=1; $i < count($tmp) - 1; $i++)
	{
		$t=trim($tmp[$i]);
		if (substr($t,-1) == ',') $t=substr($t,0,strlen($t) - 1);
		if (substr($t,0,12) == 'PRIMARY KEY ')
		{
			$t=str_replace('`','',$t);
			$fields_infos['_primarykey_']=substr($t,strpos($t,'(') + 1,strpos($t,')') - strpos($t,'(') - 1);
		}
		elseif (substr($t,0,4) == "KEY ")
		{
			$t=str_replace('`','',$t);
			$att=explode(' ',$t);
			$fields_infos['_key_'][$keys]['name']=$att[1];
			$att[2]=str_replace('(','',$att[2]);
			$att[2]=str_replace(')','',$att[2]);
			$fields_infos['_key_'][$keys]['columns']=$att[2];
			$keys++;
		}
		elseif (substr($t,0,11) == 'UNIQUE KEY ')
		{
			$t=str_replace('`','',$t);
			$att=explode(' ',$t);
			$fields_infos['_uniquekey_'][$ukeys]['name']=$att[2];
			$att[3]=str_replace('(','',$att[3]);
			$att[3]=str_replace(')','',$att[3]);
			$fields_infos['_uniquekey_'][$ukeys]['columns']=$att[3];
			$ukeys++;
		}
		elseif (substr($t,0,13) == 'FULLTEXT KEY ')
		{
			$t=str_replace('`','',$t);
			$att=explode(' ',$t);
			$fields_infos['_fulltextkey_'][$fkeys]['name']=$att[2];
			$att[3]=str_replace('(','',$att[3]);
			$att[3]=str_replace(')','',$att[3]);
			$fields_infos['_fulltextkey_'][$fkeys]['columns']=$att[3];
			$fkeys++;
		}
		else
		{
			$att=explode(' ',$t);
			if (substr($att[0],0,1) == '`' && substr($att[0],-1) == '`')
			{
				$fields_infos[$flds]['name']=str_replace('`','',$att[0]);
				$s=1;
			}
			else
			{
				$fields_infos[$flds]['name']=str_replace('`','',$att[0]) . ' ';
				for ($ii=1; $i < count($att); $i++)
				{
					if (substr($att[$ii],-1) != '`')
					{
						$fields_infos[$flds]['name'].=$att[$ii];
					}
					else
					{
						$fields_infos[$flds]['name'].=str_replace('`','',$att[$ii]);
						$s=$ii + 1;
						break;
					}
				}
			}
			
			$fields_infos[$flds]['type']=( strpos($att[$s],'(') ) ? substr($att[$s],0,strpos($att[$s],'(')) : $att[$s];
			$fields_infos[$flds]['size']=( strpos($att[$s],'(') ) ? substr($att[$s],strpos($att[$s],'(') + 1,strpos($att[$s],')') - strpos($att[$s],'(') - 1) : '';
			$fields_infos[$flds]['default']='';
			$fields_infos[$flds]['null']='';
			$fields_infos[$flds]['extra']='';
			$fields_infos[$flds]['attribut']='';
			
			$s++;
			while ($s < count($att))
			{
				if (isset($att[$s + 1]) && strtolower($att[$s] . $att[$s + 1]) == 'unsignedzerofill')
				{
					$fields_infos[$flds]['attribut']='unsigned zerofill';
					$s+=2;
				}
				elseif (strtolower($att[$s]) == 'unsigned')
				{
					$fields_infos[$flds]['attribut']='unsigned';
					$s++;
				}
				elseif (isset($att[$s + 1]) && strtolower($att[$s] . $att[$s + 1]) == 'notnull')
				{
					$fields_infos[$flds]['null']='NOT NULL';
					$s+=2;
				}
				elseif (strtolower($att[$s]) == 'null')
				{
					$fields_infos[$flds]['null']='NULL';
					$s++;
				}
				elseif (strtolower($att[$s]) == 'auto_increment')
				{
					$fields_infos[$flds]['extra']='auto_increment';
					$s++;
				}
				elseif (strtolower($att[$s]) == 'collate')
				{
					$fields_infos[$flds]['collate']=$att[$s + 1];
					$s+=2;
				}
				elseif (strtolower($att[$s]) == 'character')
				{
					$fields_infos[$flds]['character set']=$att[$s + 2];
					$s+=3;
				}
				elseif (strtolower($att[$s]) == 'default')
				{
					$ii=$s + 1;
					if (substr($att[$ii],0,1) == '\'' && substr($att[$ii],-1) == '\'')
					{
						$fields_infos[$flds]['default']=$att[$ii];
						$s+=2;
					}
					else
					{
						if (substr($att[$ii],0,1) == '\'')
						{
							$fields_infos[$flds]['default']=$att[$ii] . ' ' . $att[$ii + 1];
							$s+=3;
						}
						else
						{
							$fields_infos[$flds]['default']=$att[$ii];
							$s+=2;
						}
					}
				}
				else
				{
					$s++;
				}
			}
			
			$flds++;
		}
	}
	$ext=explode(' ',substr($tmp[count($tmp) - 1],2));
	$s='';
	$haltchar='=';
	for ($i=0; $i < count($ext); $i++)
	{
		if (!strpos($ext[$i],$haltchar))
		{
			$s.=$ext[$i] . ' ';
		}
		else
		{
			if ($haltchar == "'")
			{
				$fields_infos['_tableinfo_']['COMMENT']=$s . $ext[$i];
				$s='';
				$haltchar='=';
			}
			else
			{
				$s.=substr($ext[$i],0,strpos($ext[$i],$haltchar));
				if (strtoupper($s) == 'COMMENT')
				{
					$s=substr($ext[$i],strpos($ext[$i],$haltchar) + 1);
					if (substr($s,-1) == "'")
					{
						$fields_infos['_tableinfo_']['COMMENT']=$s;
						$s='';
					}
					else
					{
						$s.=' ';
						$haltchar="'";
					}
				}
				else
				{
					$fields_infos['_tableinfo_'][strtoupper($s)]=substr($ext[$i],strpos($ext[$i],$haltchar) + 1);
					$s='';
				}
			}
		}
	}
	return $fields_infos;
}

function ChangeKeys($ok, $nk, $fld, $size, $restriction='')
{
	if ($ok[0] == $nk[0] && $ok[1] == $nk[1] && $ok[2] == $nk[2] && $ok[3] == $nk[3]) return '';
	else
	{
		$s='';
		if ($ok[0] == 0 && $nk[0] == 1)
		{
			if ($restriction != 'drop_only') $s.="ADD PRIMARY KEY (`$fld`), ";
		}
		elseif ($ok[0] == 1 && $nk[0] == 0)
		{
			$s.='DROP PRIMARY KEY, ';
		}
		if ($ok[1] == 0 && $nk[1] == 1)
		{
			if ($restriction != 'drop_only') $s.="ADD UNIQUE INDEX `$fld` (`$fld`), ";
		}
		elseif ($ok[1] == 1 && $nk[1] == 0)
		{
			$s.="DROP INDEX `$fld`, ";
		}
		if ($ok[2] == 0 && $nk[2] == 1)
		{
			if ($restriction != 'drop_only') $s.="ADD INDEX `$fld` (`$fld`), ";
		}
		elseif ($ok[2] == 1 && $nk[2] == 0)
		{
			$s.="DROP INDEX `$fld`, ";
		}
		if ($ok[3] == 0 && $nk[3] == 1)
		{
			if ($restriction != 'drop_only') $s.="ADD FULLTEXT INDEX `$fld` (`$fld`($size)), ";
		}
		elseif ($ok[3] == 1 && $nk[3] == 0)
		{
			$s.="DROP FULLTEXT INDEX `$fld`, ";
		}
	}
	if ($s != '') $s=substr($s,0,strlen($s) - 2);
	return $s;
}

function CheckCSVOptions()
{
	global $sql;
	if (!isset($sql['export']['trenn'])) $sql['export']['trenn']=";";
	if (!isset($sql['export']['enc'])) $sql['export']['enc']="\"";
	if (!isset($sql['export']['esc'])) $sql['export']['esc']="\\";
	if (!isset($sql['export']['ztrenn'])) $sql['export']['ztrenn']="\\r\\n";
	if (!isset($sql['export']['null'])) $sql['export']['null']="NULL";
	if (!isset($sql['export']['namefirstline'])) $sql['export']['namefirstline']=0;
	if (!isset($sql['export']['format'])) $sql['export']['format']=0;
	if (!isset($sql['export']['sendfile'])) $sql['export']['sendfile']=0;
	if (!isset($sql['export']['tables'])) $sql['export']['tables']=Array();
	if (!isset($sql['export']['compressed'])) $sql['export']['compressed']=0;
	if (!isset($sql['export']['htmlstructure'])) $sql['export']['htmlstructure']=0;
	if (!isset($sql['export']['xmlstructure'])) $sql['export']['xmlstructure']=0;
	
	if (!isset($sql['import']['trenn'])) $sql['import']['trenn']=";";
	if (!isset($sql['import']['enc'])) $sql['import']['enc']="\"";
	if (!isset($sql['import']['esc'])) $sql['import']['esc']="\\";
	if (!isset($sql['import']['ztrenn'])) $sql['import']['ztrenn']="\\r\\n";
	if (!isset($sql['import']['null'])) $sql['import']['null']="NULL";
	if (!isset($sql['import']['namefirstline'])) $sql['import']['namefirstline']=0;
	if (!isset($sql['import']['format'])) $sql['import']['format']=0;

}

function ExportCSV()
{
	global $sql,$config;
	$t="";
	$time_start=time();
	if (!isset($config['dbconnection'])) MSD_mysql_connect();
	for ($table=0; $table < count($sql['export']['tables']); $table++)
	{
		$sqlt="SHOW Fields FROM `" . $sql['export']['db'] . "`.`" . $sql['export']['tables'][$table] . "`;";
		$res=MSD_query($sqlt);
		if ($res)
		{
			$numfields=mysql_numrows($res);
			if ($sql['export']['namefirstline'] == 1)
			{
				for ($feld=0; $feld < $numfields; $feld++)
				{
					$row=mysql_fetch_row($res);
					if ($sql['export']['enc'] != "") $t.=$sql['export']['enc'] . $row[0] . $sql['export']['enc'] . ( ( $feld + 1 < $numfields ) ? $sql['export']['trenn'] : '' );
					else $t.=$row[0] . ( ( $feld + 1 < $numfields ) ? $sql['export']['trenn'] : '' );
				}
				$t.=$sql['export']['endline'];
				$sql['export']['lines']++;
			}
		}
		$sqlt="SELECT * FROM `" . $sql['export']['db'] . "`.`" . $sql['export']['tables'][$table] . "`;";
		$res=MSD_query($sqlt);
		if ($res)
		{
			$numrows=mysql_numrows($res);
			for ($data=0; $data < $numrows; $data++)
			{
				$row=mysql_fetch_row($res);
				for ($feld=0; $feld < $numfields; $feld++)
				{
					if (!isset($row[$feld]) || is_null($row[$feld]))
					{
						$t.=$sql['export']['null'];
					}
					elseif ($row[$feld] == '0' || $row[$feld] != '')
					{
						if ($sql['export']['enc'] != "") $t.=$sql['export']['enc'] . str_replace($sql['export']['enc'],$sql['export']['esc'] . $sql['export']['enc'],$row[$feld]) . $sql['export']['enc'];
						else $t.=$row[$feld];
					}
					else
					{
						$t.='';
					}
					$t.=( $feld + 1 < $numfields ) ? $sql['export']['trenn'] : '';
				}
				$t.=$sql['export']['endline'];
				$sql['export']['lines']++;
				if (strlen($t) > $config['memory_limit'])
				{
					CSVOutput($t);
					$t="";
				}
				$time_now=time();
				if ($time_start >= $time_now + 30)
				{
					$time_start=$time_now;
					header('X-MSDPing: Pong');
				}
			}
		}
	}
	CSVOutput($t,1);
}

function CSVOutput($str, $last=0)
{
	global $sql,$config;
	if ($sql['export']['sendfile'] == 0)
	{
		//Display
		echo $str;
	}
	else
	{
		if ($sql['export']['header_sent'] == "")
		{
			if ($sql['export']['compressed'] == 1 & !function_exists('gzencode')) $sql['export']['compressed']=0;
			if ($sql['export']['format'] < 4)
			{
				$file=$sql['export']['db'] . ( ( $sql['export']['compressed'] == 1 ) ? ".csv.gz" : ".csv" );
			}
			elseif ($sql['export']['format'] == 4)
			{
				$file=$sql['export']['db'] . ( ( $sql['export']['compressed'] == 1 ) ? ".xml.gz" : ".xml" );
			}
			elseif ($sql['export']['format'] == 5)
			{
				$file=$sql['export']['db'] . ( ( $sql['export']['compressed'] == 1 ) ? ".html.gz" : ".html" );
			}
			$mime=( $sql['export']['compressed'] == 0 ) ? "x-type/subtype" : "application/x-gzip";
			
			header('Content-Disposition: attachment; filename="' . $file . '"');
			header('Pragma: no-cache');
			header('Content-Type: ' . $mime);
			header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
			$sql['export']['header_sent']=1;
		}
		if ($sql['export']['compressed'] == 1) echo gzencode($str);
		else echo $str;
	
	}
}

function DoImport()
{
	global $sql,$lang;
	$r='<span class="swarnung">';
	$zeilen=count($sql['import']['csv']) - $sql['import']['namefirstline'];
	$sql['import']['first_zeile']=explode($sql['import']['trenn'],$sql['import']['csv'][0]);
	$importfelder=count($sql['import']['first_zeile']);
	
	if ($sql['import']['tablecreate'] == 0)
	{
		$res=MSD_query("show fields FROM " . $sql['import']['table']);
		$tabellenfelder=mysql_num_rows($res);
		if ($importfelder != $tabellenfelder)
		{
			$r.='<br>' . sprintf($lang['csv_fieldcount_nomatch'],$tabellenfelder,$importfelder);
		}
		else
		{
			$ok=1;
		}
	}
	else
	{
		$ok=ImportCreateTable();
		if ($ok == 0)
		{
			$r.='<br>' . sprintf($lang['csv_errorcreatetable'],$sql['import']['table']);
		}
	}
	if ($ok == 1)
	{
		$insert="";
		if ($sql['import']['emptydb'] == 1 && $sql['import']['tablecreate'] == 0)
		{
			MSD_DoSQL("TRUNCATE " . $sql['import']['table'] . ";");
		}
		$sql['import']['lines_imported']=0;
		$enc=( $sql['import']['enc'] == "" ) ? "'" : "";
		$zc="";
		for ($i=$sql['import']['namefirstline']; $i < $zeilen + $sql['import']['namefirstline']; $i++)
		{
			//Importieren
			$insert="INSERT INTO " . $sql['import']['table'] . " VALUES(";
			if ($sql['import']['createindex'] == 1) $insert.="'', ";
			$zc.=trim(rtrim($sql['import']['csv'][$i]));
			//echo "Zeile $i: $zc<br>";
			if ($zc != "")
			{ // && substr($zc,-1)==$enc) {
				$zeile=explode($sql['import']['trenn'],$zc);
				for ($j=0; $j < $importfelder; $j++)
				{
					$a=( $zeile[$j] == "" && $enc == "" ) ? "''" : $zeile[$j];
					$insert.=$enc . $a . $enc . ( ( $j == $importfelder - 1 ) ? ");\n" : "," );
				}
				MSD_DoSQL($insert);
				$sql['import']['lines_imported']++;
				$zc="";
			}
		
		}
		$r.=sprintf($lang['csv_fieldslines'],$importfelder,$sql['import']['lines_imported']);
	}
	
	$r.='</span>';
	return $r;

}

function ImportCreateTable()
{
	global $sql,$lang,$db,$config;
	$tbl=Array();
	$tabellen=mysql_list_tables($db,$config['dbconnection']);
	$num_tables=mysql_num_rows($tabellen);
	for ($i=0; $i < $num_tables; $i++)
	{
		$tbl[]=strtolower(mysql_tablename($tabellen,$i));
	}
	$i=0;
	$sql['import']['table']=$sql['import']['table'] . $i;
	while (in_array($sql['import']['table'],$tbl))
	{
		$sql['import']['table']=substr($sql['import']['table'],0,strlen($sql['import']['table']) - 1) . ++$i;
	}
	$create="CREATE TABLE `" . $sql['import']['table'] . "` (" . ( ( $sql['import']['createindex'] == 1 ) ? '`import_id` int(11) unsigned NOT NULL auto_increment, ' : '' );
	if ($sql['import']['namefirstline'])
	{
		for ($i=0; $i < count($sql['import']['first_zeile']); $i++)
		{
			$create.='`' . $sql['import']['first_zeile'][$i] . '` VARCHAR(250) NOT NULL, ';
		}
	}
	else
	{
		for ($i=0; $i < count($sql['import']['first_zeile']); $i++)
		{
			$create.='`FIELD_' . $i . '` VARCHAR(250) NOT NULL, ';
		}
	}
	if ($sql['import']['createindex'] == 1) $create.='PRIMARY KEY (`import_id`) ';
	else $create=substr($create,0,strlen($create) - 2);
	
	$create.=') ' . ( ( MSD_NEW_VERSION ) ? 'ENGINE' : 'TYPE' ) . "=MyISAM COMMENT='imported at " . date("l dS of F Y H:i:s A") . "'";
	$res=mysql_query($create,$config['dbconnection']) || die(SQLError($create,mysql_error()));
	return 1;
}

function ExportXML()
{
	global $sql,$config;
	$tab="\t";
	$level=0;
	$t='<?xml version="1.0" encoding="UTF-8" ?>' . "\n" . '<database name="' . $sql['export']['db'] . '">' . "\n";
	$level++;
	$time_start=time();
	
	if (!isset($config['dbconnection'])) MSD_mysql_connect();
	for ($table=0; $table < count($sql['export']['tables']); $table++)
	{
		$t.=str_repeat($tab,$level++) . '<table name="' . $sql['export']['tables'][$table] . '">' . "\n";
		$sqlt="SHOW Fields FROM `" . $sql['export']['db'] . "`.`" . $sql['export']['tables'][$table] . "`;";
		$res=MSD_query($sqlt);
		if ($res)
		{
			$numfields=mysql_num_rows($res);
			if ($sql['export']['xmlstructure'] == 1)
			{
				$t.=str_repeat($tab,$level++) . '<structure>' . "\n";
				for ($feld=0; $feld < $numfields; $feld++)
				{
					$row=mysql_fetch_array($res);
					$t.=str_repeat($tab,$level++) . '<field no="' . $feld . '">' . "\n";
					$t.=str_repeat($tab,$level) . '<name>' . $row['Field'] . '</name>' . "\n";
					$t.=str_repeat($tab,$level) . '<type>' . $row['Type'] . '</type>' . "\n";
					$t.=str_repeat($tab,$level) . '<null>' . $row['Null'] . '</null>' . "\n";
					$t.=str_repeat($tab,$level) . '<key>' . $row['Key'] . '</key>' . "\n";
					$t.=str_repeat($tab,$level) . '<default>' . $row['Default'] . '</default>' . "\n";
					$t.=str_repeat($tab,$level) . '<extra>' . $row['Extra'] . '</extra>' . "\n";
					$t.=str_repeat($tab,--$level) . '</field>' . "\n";
				}
				$t.=str_repeat($tab,--$level) . '</structure>' . "\n";
			}
		}
		$t.=str_repeat($tab,$level++) . '<data>' . "\n";
		$sqlt="SELECT * FROM `" . $sql['export']['db'] . "`.`" . $sql['export']['tables'][$table] . "`;";
		$res=MSD_query($sqlt);
		if ($res)
		{
			$numrows=mysql_numrows($res);
			for ($data=0; $data < $numrows; $data++)
			{
				$t.=str_repeat($tab,$level) . "<row>\n";
				$level++;
				$row=mysql_fetch_row($res);
				for ($feld=0; $feld < $numfields; $feld++)
				{
					$t.=str_repeat($tab,$level) . '<field no="' . $feld . '">' . $row[$feld] . '</field>' . "\n";
				}
				$t.=str_repeat($tab,--$level) . "</row>\n";
				$sql['export']['lines']++;
				if (strlen($t) > $config['memory_limit'])
				{
					CSVOutput($t);
					$t="";
				}
				$time_now=time();
				if ($time_start >= $time_now + 30)
				{
					$time_start=$time_now;
					header('X-MSDPing: Pong');
				}
			}
		}
		$t.=str_repeat($tab,--$level) . '</data>' . "\n";
		$t.=str_repeat($tab,--$level) . '</table>' . "\n";
	}
	$t.=str_repeat($tab,--$level) . '</database>' . "\n";
	CSVOutput($t,1);
}

function ExportHTML()
{
	global $sql,$config,$lang;
	$header='<html><head><title>MSD Export</title></head>';
	$footer="\n\n</body>\n</html>";
	$content="";
	$content.='<h1>' . $lang['db'] . ' ' . $sql['export']['db'] . '</h1>';
	
	$time_start=time();
	
	if (!isset($config['dbconnection'])) MSD_mysql_connect();
	for ($table=0; $table < count($sql['export']['tables']); $table++)
	{
		$content.='<h2>Tabelle ' . $sql['export']['tables'][$table] . '</h2>' . "\n";
		$fsql="show fields from `" . $sql['export']['tables'][$table] . "`";
		$dsql="select * from `" . $sql['export']['tables'][$table] . "`";
		//Struktur
		$res=MSD_query($fsql);
		if ($res)
		{
			$field=$fieldname=$fieldtyp=Array();
			$structure="<table class=\"Table\">\n";
			$numfields=mysql_numrows($res);
			for ($feld=0; $feld < $numfields; $feld++)
			{
				$row=mysql_fetch_row($res);
				$field[$feld]=$row[0];
				
				if ($feld == 0)
				{
					$structure.="<tr class=\"Header\">\n";
					for ($i=0; $i < count($row); $i++)
					{
						$str=mysql_fetch_field($res,$i);
						$fieldname[$i]=$str->name;
						$fieldtyp[$i]=$str->type;
						$structure.="<th>" . $str->name . "</th>\n";
					}
					$structure.="</tr>\n<tr>\n";
				}
				for ($i=0; $i < count($row); $i++)
				{
					$structure.="<td class=\"Object\">" . ( ( $row[$i] != "" ) ? $row[$i] : "&nbsp;" ) . "</td>\n";
				}
				$structure.="</tr>\n";
			}
			$structure.="</table>\n";
		}
		if ($sql['export']['htmlstructure'] == 1) $content.="<h3>Struktur</h3>\n" . $structure;
		//Daten
		

		$res=MSD_query($dsql);
		if ($res)
		{
			$anz=mysql_num_rows($res);
			$content.="<h3>Daten ($anz Datens&auml;tze)</h3>\n";
			$content.="<table class=\"Table\">\n";
			for ($feld=0; $feld < count($field); $feld++)
			{
				if ($feld == 0)
				{
					$content.="<tr class=\"Header\">\n";
					for ($i=0; $i < count($field); $i++)
					{
						$content.="<th>" . $field[$i] . "</th>\n";
					}
					$content.="</tr>\n";
				}
			}
			for ($d=0; $d < $anz; $d++)
			{
				$row=mysql_fetch_row($res);
				$content.="<tr>\n";
				for ($i=0; $i < count($row); $i++)
				{
					
					$content.='<td class="Object">' . ( ( $row[$i] != "" ) ? $row[$i] : "&nbsp;" ) . "</td>\n";
				}
				$content.="</tr>\n";
			}
		}
		$content.="</table>";
	}
	CSVOutput($header . $content . $footer);
}

// Bildet die WHERE-Bedingung zur eindeutigen Identifizierung wenn kein Primaerschluessel vorhanden ist
// erwartet ein Array mit $data[feldname]=wert
function build_recordkey($data)
{
	if (!is_array($data)) return urlencode($data);
	else return urlencode(serialize($data));
}

function build_where_from_record($data)
{
	if (!is_array($data)) return false;
	$ret='';
	foreach ($data as $key=>$val)
	{
		$val=str_replace('<span class="treffer">','',$val);
		$val=str_replace('</span>','',$val);
		$ret.='`' . $key . '`="' . addslashes($val) . '"|';
	}
	$ret=substr($ret,0,-1);
	return $ret;
}

/*
 * Array mit Primaerschluesseln aufbauen
 * INPUT: Datenbank.Tabelle (oder nur Tabelle)
 * OUTPUT: Array mit allen Tabellenschluesseln
 * Author: DH
 */
function getPrimaryKeys($db, $table)
{
	$keys=Array();
	$sqlk="SHOW KEYS FROM `" . $db . "`.`" . $table . "`;";
	$res=MSD_query($sqlk);
	while ($row=mysql_fetch_array($res))
	{
		//wenn Primaerschluessel
		if ($row['Key_name'] == "PRIMARY") $keys[]=$row['Column_name'];
	}
	return $keys;
}

/*
 * Array mit allen Feldern aufbauen
 * INPUT: Datenbank.Tabelle
 * OUTPUT: Array mit allen Feldern der Tabelle
 * Author: DH
 */
function getAllFields($db, $table)
{
	$fields=Array();
	$sqlk="DESCRIBE `" . $db . "`.`" . $table . "`;";
	$res=MSD_query($sqlk);
	while ($row=mysql_fetch_array($res))
	{
		$fields[]=$row['Field'];
	}
	return $fields;
}

/*
 * Alte Primaerschluessel verwerfen, neue Primaerschluessel setzen
 * INPUT: Datenbank.Tabelle, Array mit neuen Primaerschluesseln
 * OUTPUT: true/false
 * Author: DH
 */
function setNewPrimaryKeys($db, $table, $newKeys)
{
	$sqlSetNewPrimaryKeys="ALTER TABLE `" . $db . "`.`" . $table . "` DROP PRIMARY KEY";
	//wenn min. 1 Schluessel im Array, sonst nur loeschen
	if (count($newKeys) > 0)
	{
		$sqlSetNewPrimaryKeys.=",
			ADD PRIMARY KEY (`" . implode("`,`",$newKeys) . "`)";
	}
	$sqlSetNewPrimaryKeys.=";";
	$res=MSD_query($sqlSetNewPrimaryKeys);
	return $res;
}
?>

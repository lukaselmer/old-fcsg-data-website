<?php
if (!defined('MSD_VERSION')) die('No direct access.');
include ( './language/' . $config['language'] . '/lang.php' );
include ( './language/' . $config['language'] . '/lang_dump.php' );
include ( './inc/template.php' );
$tblr=( $tblfrage_refer == 'dump' ) ? 'Backup' : 'Restore';
$filename=( isset($_GET['filename']) ) ? $_GET['filename'] : '';
if (isset($_POST['file'][0])) $filename=$_POST['file'][0];

ob_start();
$tpl=new MSDTemplate();
$sel_dump_encoding=isset($_POST['sel_dump_encoding']) ? $_POST['sel_dump_encoding'] : '';
$tpl=new MSDtemplate();

//Informationen zusammenstellen
if ($tblr == 'Backup')
{
	$tpl->set_filenames(array(
							'show' => './tpl/dump_select_tables.tpl'
	));
	$button_name='dump_tbl';
	//Info aus der Datenbank lesen
	MSD_mysql_connect();
	$res=mysql_query('SHOW TABLE STATUS FROM `' . $databases['db_actual'] . '`');
	$numrows=mysql_num_rows($res);
	$tbl_zeile='';
	for ($i=0; $i < $numrows; $i++)
	{
		$row=mysql_fetch_array($res,MYSQL_ASSOC);
		//v($row);	
		// Get nr of records -> need to do it this way because of incorrect returns when using InnoDBs
		$sql_2="SELECT count(*) as `count_records` FROM `" . $databases['db_actual'] . "`.`" . $row['Name'] . "`";
		$res2=@mysql_query($sql_2);
		if ($res2 === false)
		{
			$read_error='(' . mysql_errno() . ') ' . mysql_error();
			$row['Rows']='<span class="error">' . $lang['error'] . ': ' . $read_error . '</span>';
		}
		else
		{
			$row2=@mysql_fetch_array($res2);
			$row['Rows']=$row2['count_records'];
		}
		
		$klasse=( $i % 2 ) ? 1 : '';
		$table_size=$row['Data_length'] + $row['Index_length'];
		$table_type=$row['Engine'];
		if (substr($row['Comment'],0,4) == 'VIEW')
		{
			$table_type='View';
			$table_size='-';
		}
		$tpl->assign_block_vars('ROW',array(
											
											'CLASS' => 'dbrow' . $klasse, 
											'ID' => $i, 
											'NR' => $i + 1, 
											'TABLENAME' => $row['Name'], 
											'TABLETYPE' => $table_type, 
											'RECORDS' => $table_type == 'View' ? '<i>' . $row['Rows'] . '</i>' : '<strong>' . $row['Rows'] . '</strong>', 
											'SIZE' => is_int($table_size) ? byte_output($table_size) : $table_size, 
											'LAST_UPDATE' => $row['Update_time']
		));
	}
}
else
{
	$tpl->set_filenames(array(
							
							'show' => './tpl/restore_select_tables.tpl'
	));
	//Restore - Header aus Backupfile lesen
	$button_name='restore_tbl';
	$gz=( substr($filename,-3) ) == '.gz' ? 1 : 0;
	if ($gz)
	{
		$fp=gzopen($fpath . $filename,"r");
		$statusline=gzgets($fp,40960);
		$offset=gztell($fp);
	}
	else
	{
		$fp=fopen($fpath . $filename,"r");
		$statusline=fgets($fp,5000);
		$offset=ftell($fp);
	}
	//Header auslesen
	$sline=ReadStatusline($statusline);
	
	$anzahl_tabellen=$sline['tables'];
	$anzahl_eintraege=$sline['records'];
	$tbl_zeile='';
	$part=( $sline['part'] == '' ) ? 0 : substr($sline['part'],3);
	if ($anzahl_eintraege == -1)
	{
		// not a backup of MySQLDumper
		$tpl->assign_block_vars('NO_MSD_BACKUP',array());
	}
	else
	{
		$tabledata=array();
		$i=0;
		//Tabellenfinos lesen
		gzseek($fp,$offset);
		$eof=false;
		WHILE (!$eof)
		{
			$line=$gz ? gzgets($fp,40960) : fgets($fp,40960);
			
			if (substr($line,0,9) == '-- TABLE|')
			{
				$d=explode('|',$line);
				$tabledata[$i]['name']=$d[1];
				$tabledata[$i]['records']=$d[2];
				$tabledata[$i]['size']=$d[3];
				$tabledata[$i]['update']=$d[4];
				$tabledata[$i]['engine']=isset($d[5]) ? $d[5] : '';
				$i++;
			}
			if (substr($line,0,6) == '-- EOF') $eof=true;
			if (substr(strtolower($line),0,6) == 'create') $eof=true;
		}
		for ($i=0; $i < sizeof($tabledata); $i++)
		{
			$klasse=( $i % 2 ) ? 1 : '';
			$tpl->assign_block_vars('ROW',array(
												
												'CLASS' => 'dbrow' . $klasse, 
												'ID' => $i, 
												'NR' => $i + 1, 
												'TABLENAME' => $tabledata[$i]['name'], 
												'RECORDS' => $tabledata[$i]['records'], 
												'SIZE' => byte_output($tabledata[$i]['size']), 
												'LAST_UPDATE' => $tabledata[$i]['update'], 
												'TABLETYPE' => $tabledata[$i]['engine']
			));
		}
	}
	if ($gz) gzclose($fp);
	else fclose($fp);
}

if (!isset($dk)) $dk='';

$confirm_restore=$lang['fm_alertrestore1'] . ' `' . $databases['db_actual'] . '`  ' . $lang['fm_alertrestore2'] . ' ' . $filename . ' ' . $lang['fm_alertrestore3'];

$tpl->assign_vars(array(
						
						'PAGETITLE' => $tblr . ' -' . $lang['tableselection'], 
						'L_NAME' => $lang['name'], 
						'L_DATABASE' => $lang['db'], 
						'DATABASE' => $databases['db_actual'], 
						'L_LAST_UPDATE' => $lang['lastbufrom'], 
						'SEL_DUMP_ENCODING' => $sel_dump_encoding, 
						'FILENAME' => $filename, 
						'DUMP_COMMENT' => $dk, 
						'BUTTON_NAME' => $button_name, 
						'L_START_BACKUP' => $lang['startdump'], 
						'L_START_RESTORE' => $lang['fm_restore'], 
						'L_ROWS' => $lang['info_records'], 
						'L_SIZE' => $lang['info_size'], 
						'L_TABLE_TYPE' => $lang['table_type'], 
						'L_SELECT_ALL' => $lang['selectall'], 
						'L_DESELECT_ALL' => $lang['deselectall'], 
						'L_RESTORE' => $lang['restore'], 
						'L_NO_MSD_BACKUP' => $lang['not_supported'], 
						'L_CONFIRM_RESTORE' => $confirm_restore
));

$tpl->pparse('show');
ob_end_flush();
?>
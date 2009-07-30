<?php
$lang['convert_start']="Start Conversion";
$lang['convert_title']="Convert Dump to MSD Format";
$lang['convert_wrong_parameters']="Wrong parameters!  Conversion is not possible.";
$lang['fm_uploadfilerequest']="please choose a file.";
$lang['fm_uploadnotallowed1']="This file type is not supported.";
$lang['fm_uploadnotallowed2']="Valid types are: *.gz and *.sql-files";
$lang['fm_uploadmoveerror']="Couldn't move selected file to the upload directory.";
$lang['fm_uploadfailed']="The upload has failed!";
$lang['fm_uploadfileexists']="A file with the same name already exists !";
$lang['fm_nofile']="You didn't choose a file!";
$lang['fm_delete1']="The file ";
$lang['fm_delete2']=" was deleted successfully.";
$lang['fm_delete3']=" couldn't be deleted!";
$lang['fm_choose_file']="Chosen file:";
$lang['fm_filesize']="File size";
$lang['fm_filedate']="File date";
$lang['fm_nofilesfound']="No file found.";
$lang['fm_tables']="Tables";
$lang['fm_records']="Records";
$lang['fm_all_bu']="All Backups";
$lang['fm_anz_bu']="Backups";
$lang['fm_last_bu']="Last Backup";
$lang['fm_totalsize']="Total Size";
$lang['fm_selecttables']="Select tables";
$lang['fm_comment']="Enter Comment";
$lang['fm_restore']="Restore";
$lang['fm_alertrestore1']="Should the database";
$lang['fm_alertrestore2']="be restored with the records from the file";
$lang['fm_alertrestore3']=" ?";
$lang['fm_delete']="Delete";
$lang['fm_askdelete1']="Should the file ";
$lang['fm_askdelete2']=" really be deleted?";
$lang['fm_askdelete3']="Do you want autodelete to be executed with configured rules now?";
$lang['fm_askdelete4']="Do you want to delete all backup files?";
$lang['fm_askdelete5']="Do you want to delete all backup files with ";
$lang['fm_askdelete5_2']="_* ?";
$lang['fm_deleteauto']="Run autodelete manually";
$lang['fm_deleteall']="Delete all backup files";
$lang['fm_deleteallfilter']="Delete all with ";
$lang['fm_deleteallfilter2']="_*";
$lang['fm_startdump']="Start New Backup";
$lang['fm_fileupload']="Upload file";
$lang['fm_dbname']="Database name";
$lang['fm_files1']="Database Backups";
$lang['fm_autodel1']="Autodelete: the following files were deleted because of maximum files setting:";
$lang['delete_file_success']="File \"%s\" was deleted successfully.";
$lang['fm_dumpsettings']="Configuration for Perl Cron script";
$lang['fm_oldbackup']="(unknown)";
$lang['fm_restore_header']="Restore of Database \"<strong>%s</strong>\"";
$lang['delete_file_error']="Error deleting file \"%s\"!";
$lang['fm_dump_header']="Backup";
$lang['DoCronButton']="Run the Perl Cron script";
$lang['DoPerlTest']="Test Perl Modules";
$lang['DoSimpleTest']="Test Perl";
$lang['perloutput1']="Entry in crondump.pl for absolute_path_of_configdir";
$lang['perloutput2']="URL for the browser or for external Cron job";
$lang['perloutput3']="Commandline in the Shell or for the Crontab";
$lang['restore_of_tables']="Choose tables to be restored";
$lang['converter']="Backup Converter";
$lang['convert_file']="File to be converted";
$lang['convert_filename']="Name of destination file (without extension)";
$lang['converting']="Converting";
$lang['convert_fileread']="Read file '%s'";
$lang['convert_finished']="Conversion finished, '%s' was written successfully.";
$lang['no_msd_backupfile']="Backups of other scripts";
$lang['max_upload_size']="Maximum filesize";
$lang['max_upload_size_info']="Wenn Ihre Backup-Datei größer als das angegebene Limit ist, dann müssen Sie diese per FTP in den \"work/backup\"-Ordner hochladen. 
Danach wird diese Datei hier in der Verwaltung angezeigt uns lässt sich für eine Wiederherstellung auswählen.";
$lang['encoding']="encoding";
$lang['fm_choose_encoding']="Choose encoding of backupfile";
$lang['choose_charset']="MySQLDumper couldn't detect the encoding of the backupfile automatically.
<br>You must choose the charset with which this backup was saved.
<br>If you discover any problems with some characters after restoring, you can repeat the backup-progress and then choose another chracter set.
<br>Good luck. ;)

";


?>
<?php
$lang['convert_start']="Iniciar conversión";
$lang['convert_title']="Convertir copia de seguridad al formato MSD";
$lang['convert_wrong_parameters']="¡Parámetros incorrectos!  La conversión no es posible.";
$lang['fm_uploadfilerequest']="Por favor, elija un archivo.";
$lang['fm_uploadnotallowed1']="Esta clase de archivo no está permitida.";
$lang['fm_uploadnotallowed2']="Los tipos de archivo permitidos son: *.gz y *.sql";
$lang['fm_uploadmoveerror']="No se ha podido copiar el archivo enviado al directorio correcto.";
$lang['fm_uploadfailed']="¡El envío del archivo ha fallado!";
$lang['fm_uploadfileexists']="¡ Ya existe un archivo con este nombre !";
$lang['fm_nofile']="No ha elegido ningún archivo!";
$lang['fm_delete1']="El archivo ";
$lang['fm_delete2']=" ha sido eliminado.";
$lang['fm_delete3']=" no ha podido ser eliminado!";
$lang['fm_choose_file']="archivo elegido:";
$lang['fm_filesize']="tamaño";
$lang['fm_filedate']="fecha";
$lang['fm_nofilesfound']="No se han encontrado archivos.";
$lang['fm_tables']="tablas";
$lang['fm_records']="registros";
$lang['fm_all_bu']="Lista de todas las copias de seguridad";
$lang['fm_anz_bu']="cantidad de copias de seguridad";
$lang['fm_last_bu']="última copia de seguridad";
$lang['fm_totalsize']="tamaño total";
$lang['fm_selecttables']="Selección de tablas";
$lang['fm_comment']="Enter Comment";
$lang['fm_restore']="Restaurar";
$lang['fm_alertrestore1']="¿Desea llenar la base de datos ";
$lang['fm_alertrestore2']="con el contenido del archivo";
$lang['fm_alertrestore3']="?";
$lang['fm_delete']="Eliminar";
$lang['fm_askdelete1']="¿Desea realmente eliminar el archivo ";
$lang['fm_askdelete2']=" ?";
$lang['fm_askdelete3']="¿Desea ejecutar el borrado automático según las reglas especificadas?";
$lang['fm_askdelete4']="¿Desea eliminar todos los archivos de copia de seguridad?";
$lang['fm_askdelete5']="¿Desea eliminar todos los archivos con el prefijo ";
$lang['fm_askdelete5_2']="_*?";
$lang['fm_deleteauto']="Ejecutar borrado automático manualmente";
$lang['fm_deleteall']="eliminar todas las copias de seguridad";
$lang['fm_deleteallfilter']="eliminar todos los archivos con ";
$lang['fm_deleteallfilter2']="_*";
$lang['fm_startdump']="Iniciar nueva copia de seguridad";
$lang['fm_fileupload']="Subir archivo";
$lang['fm_dbname']="Nombre de la base de datos";
$lang['fm_files1']="Copias de seguridad";
$lang['fm_autodel1']="Eliminado automático: Los siguientes archivos han sido eliminados al superarse la cantidad máxima de ficheros:";
$lang['delete_file_success']="File \"%s\" was deleted successfully.";
$lang['fm_dumpsettings']="Propiedades de la copia de seguridad";
$lang['fm_oldbackup']="(desconocido)";
$lang['fm_restore_header']="Recuperación de la base de datos \"<strong>%s</strong>\"";
$lang['delete_file_error']="Error deleting file \"%s\"!";
$lang['fm_dump_header']="Copia de seguridad";
$lang['DoCronButton']="Ejecutar Cronscript Perl";
$lang['DoPerlTest']="Comprobar Módulos Perl";
$lang['DoSimpleTest']="Comprobar Perl";
$lang['perloutput1']="Línea a escribir en crondump.pl para absolute_path_of_configdir";
$lang['perloutput2']="Ejecutar desde el navegador o desde un Cronjob externo al servidor";
$lang['perloutput3']="Ejecutar desde Shell o como entrada en Crontab";
$lang['restore_of_tables']="Choose tables to be restored";
$lang['converter']="Copia de seguridad-Conversor";
$lang['convert_file']="archivo que se convertirá";
$lang['convert_filename']="Nombre del archivo de destino (sin extensión)";
$lang['converting']="La conversión";
$lang['convert_fileread']="Leyendo el archivo '%s'";
$lang['convert_finished']="Conversión finalizada: '%s' se ha guardado correctamente.";
$lang['no_msd_backupfile']="Copias de seguridad de otros programas";
$lang['max_upload_size']="Tamaño máximo del fichero";
$lang['max_upload_size_info']="If your Dumpfile is bigger than the above mentioned limit, you must upload it via FTP into the directory \"work/backup\". 
After that you can choose it to begin a restore progress. ";
$lang['encoding']="encoding";
$lang['fm_choose_encoding']="Choose encoding of backupfile";
$lang['choose_charset']="MySQLDumper couldn't detect the encoding of the backupfile automatically.
<br>You must choose the charset with which this backup was saved.
<br>If you discover any problems with some characters after restoring, you can repeat the backup-progress and then choose another chracter set.
<br>Good luck. ;)

";


?>
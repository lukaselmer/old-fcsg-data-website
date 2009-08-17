<?php

$backup_file = $backup_dir.SYSTEM_SLASH.'serialized.byte-stream';
$serialized_string = serialize($csv_exports);
$fp = fopen($backup_file, 'w');
fwrite($fp, $serialized_string);
fclose($fp);
chmod($backup_file, 0777);

foreach ($csv_exports as $table => $rows) {
    $backup_file = $backup_dir.SYSTEM_SLASH.$table.'.csv';
    $fp = fopen($backup_file, 'w');
    foreach ($rows as $row) {
        fputcsv($fp, $row);
    }
    fclose($fp);
    chmod($backup_file, 0777);
}

?>

<h1>Sicherung erfolgreich angelegt.</h1>
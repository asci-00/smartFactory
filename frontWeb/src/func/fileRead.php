<?
    function file_to_json($filename) {
        $path = "{$_SERVER["DOCUMENT_ROOT"]}/data/{$filename}";
        $file = file_get_contents($path);
        $data = json_decode($file, true);
        return $data;
    }
?>
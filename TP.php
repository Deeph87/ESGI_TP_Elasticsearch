<?php


class TP
{
    public function exercice1(string $file)
    {
        //START CSV TO JSON
        $header = ['title', 'seo_title', 'url', 'author', 'date', 'category', 'locales', 'content'];

        $csv = file_get_contents($file);

        $array = array_map(function ($line) use ($header) {
            $explodedLine = str_getcsv($line, ';');

            if (count($explodedLine) != count($header)) {
                return null;
            }

            return array_combine($header, $explodedLine);
        }, explode("\n", $csv));


        $array = array_filter($array);
        //END CSV TO JSON


        //START BULK
        $finalString = '';
        array_walk($array, function ($line, $key) use (&$finalString) {
            $finalString .= json_encode(['index' => ['_id' => $key + 1]]);
            $finalString .= "\n";
            $finalString .= json_encode($line);
            $finalString .= "\n";
        });

        var_dump($finalString);
        var_dump("Number entries : " . count($array));

        //END BULK

        return json_encode($array);
    }
}
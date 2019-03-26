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
        $final = [];
        array_walk($array, function ($line, $key) use (&$final) {
            $final[] = [
                'index' => ['index' => ['_id' => $key + 1]],
                'content' => $line
            ];
        });

        $finalString = '';
        array_walk($final, function ($line) use (&$finalString) {
            $finalString .= json_encode($line['index']);
            $finalString .= "\n";
            $finalString .= json_encode($line['content']);
            $finalString .= "\n";
        });

        var_dump($finalString);
        var_dump("Number entries : " . count($array));

        //END BULK

//        $ch = curl_init();
//        curl_setopt_array($ch, [
//            CURLOPT_URL => "kibana:5601/exo/_doc/_bulk",
//            CURLOPT_POST => true,
//            CURLOPT_POSTFIELDS => '',
//            CURLOPT_RETURNTRANSFER => true
//        ]);
//        $output = curl_exec($ch);
//
//        curl_close($ch);

        return json_encode($array);
    }
}
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

        $this->curl("elasticsearch:9200/blog/_doc/_bulk", "POST", $finalString);

        //END BULK

        return json_encode($array);
    }

    public function exercice2(){
        $finalString= "";
        $exo2 = $this->curl("elasticsearch:9200/blog/_search", "GET", $finalString);
        var_dump($exo2);
        return $exo2;
    }

    public function exercice3(){
        $finalString= "{\"from\" : 0, \"size\" : 100}";
        $exo3 = $this->curl("elasticsearch:9200/blog/_search", "GET", $finalString);
        var_dump($exo3);
        return $exo3;
    }

    public function exercice5()
    {
        $url = 'elasticsearch:9200/blog/_search';
        $method = 'GET';
        $content = '{
          "query": {
            "match": {
              "title": "elastic"
            }
          }
        }';

        $result = $this->curl($url, $method, $content);

        var_dump($result);

        return $result;
    }

    public function exercice6()
    {
        // Nombre de hit augmenté car of match sur elastic ou stack
        $url = 'elasticsearch:9200/blog/_search';
        $method = 'GET';
        $content = '{
          "query": {
            "match": {
              "title": "elastic stack"
            }
          }
        }';

        $result = $this->curl($url, $method, $content);

        var_dump($result);

        return $result;
    }

    private function curl($url, $method, $content)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => $content,
            CURLOPT_RETURNTRANSFER => true
        ]);

        $output = curl_exec($ch);

        curl_close($ch);

        return $output;
    }
}
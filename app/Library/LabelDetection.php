<?php
namespace App\Library;

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Illuminate\Support\Facades\Log;

class LabelDetection implements Vision {
    /**
     * @param $image
     * @return array<string>
     */
    public static function tags($image): array
    {
        # auth
        $config = base_path('key.json');
        if (!file_exists($config)) {
            throw new Exception("File '$config' not found for google vision");
        }
        $imageAnnotator = new ImageAnnotatorClient([
               'credentials' => base_path('key.json')
           ]);

        # annotate the image
        try {
            $response = $imageAnnotator->labelDetection($image);
        } catch (\Google\ApiCore\ApiException $e) {
            Log::error($e->getMessage());
            $imageAnnotator->close();
            return [];
        }
        $labels = $response->getLabelAnnotations();
        $imageAnnotator->close();

        $tags = array();
        if ($labels) {
            foreach ($labels as $label) {
                // change get description with other function for different results?
                array_push($tags, $label->getDescription());

            }
        } else {
            $imageAnnotator->close();
            return [];
        }

        $imageAnnotator->close();
        return $tags;
    }
}

interface Vision
{
    /**
     * @param $image
     * @return array<string>
     */
    public static function tags($image): array;
}

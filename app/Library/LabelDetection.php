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
        // dd(fopen(__DIR__ . '\first-grove-316710-76cf1e81a4b1.json', "r"));
        $imageAnnotator = new ImageAnnotatorClient(
           [
               'credentials' => __DIR__ . '\first-grove-316710-76cf1e81a4b1.json'
           ]
        );

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

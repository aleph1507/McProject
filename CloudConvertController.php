<?php

require_once 'vendor/autoload.php';
use \CloudConvert\Api;

class CloudConvertController
{
    private $api;
    private $process;
    private $file;

    //xrristo: q4NGoFm4E0mcOwdZ1da5oisBPUn2Bs15LwG5OHNnqdoRaBN2VPekXmP8aPHafTX2
    //digitalorangeconvert: LOi3Z1GrykEWdKkEIvKYKuqmjenHPWFxgUb6fFjr1RoDX64ztC0zPl56k0T0lqKb

    public function __construct(string $api_key = '6TxxM2gjTJvwK9zOygnthoXwf1O6S7uv9pvpRl3WtL1MQoNzGNDqjynQm7Epdvdn')
    {
        try {
            $this->api = new Api($api_key);
        } catch(\CloudConvert\Exceptions\InvalidParameterException $ipe) {
            echo 'Invalid API Key: ' . $ipe->getMessage();
        }
    }

    public function create_process(string $input_format, string $output_format = 'mp4')
    {
        $create_process_args = [];
        $create_process_args = [
            'inputformat' => $input_format,
            'outputformat' => $output_format,
            'mode' => 'info'
        ];
        try {
            $this->process = $this->api->createProcess($create_process_args);
        } catch (\CloudConvert\Exceptions\ApiException $e) {
            echo 'ApiException: ' . $e->getMessage();
            return;
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            echo 'GuzzleException: ' . $e->getMessage();
            return;
        }
    }

    private function setFile(File $file)
    {
        $this->file = $file;
    }

    private function start_process(string $filepath, string $output_format = 'mp4')
    {
        $start_process_args = [
            'input' => 'upload',
            'file' => fopen($filepath, 'r'),
            'filename' => time() . $this->file->getName(),
            'outputformat' => $output_format,
            "converteroptions" => $this->get_converteroptions()
        ];
        $filepath = '../cloudconvert_downloads/' . time() . '_' . $this->file->getName();
        $this->process->start($start_process_args)
            ->wait()
            ->download($filepath);

        $this->file->setName(time() . '_' . $this->file->getName());
        $this->file->setPath($filepath);
        return $this->file;

    }

    public function convert(File $file)
    {
        $input_format = pathinfo($file->getName(), PATHINFO_EXTENSION);
        $output_format = 'mp4';
        $this->setFile($file);

        $this->create_process($input_format, $output_format);
        return $this->start_process($file->getPath(), $output_format);
    }

    private function get_converteroptions()
    {
        return [
            "video_codec" => "H265",
            "video_crf" => "28",
            "video_profile" => null,
            "video_profile_level" => null,
            "video_qscale" => -1,
            "video_bitrate" => 1024,
            "video_bitrate_max" => null,
            "video_transpose" => "clock, cclock",
            "video_resolution" => "480x720",
            "video_ratio" => null,
            "video_fps" => "20",
            "faststart" => null,
            "subtitles_copy" => null,
            "subtitles_srt" => null,
            "subtitles_ass" => null,
            "audio_all_streams" => null,
            "thumbnail_format" => null,
            "thumbnail_size" => null,
            "thumbnail_count" => null,
            "audio_codec" => "AAC",
            "audio_qscale" => -1,
            "audio_bitrate" => "32",
            "audio_channels" => null,
            "audio_frequency" => 44100,
            "audio_normalize" => null,
            "trim_to" => null,
            "trim_from" => null,
            "strip_metatags" => false,
            "command" => null,
        ];
    }


}

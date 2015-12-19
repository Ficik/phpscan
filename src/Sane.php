<?php

namespace PhpScan;
/**
 * @author: Stanislav Fifik <stanislav.fifik@designeo.cz>
 */

class Sane {

    /**
     * @var String
     */
    private $device;

    /**
     * @var String
     */
    private $outputDir;

    public function __construct($device="", $outputDir="outputs"){
        $this->device = $device;
        $this->outputDir = $outputDir;
    }

    public function preview($options=[]){
        return $this->scan("preview.jpeg", array_merge(['--preview', '--format=jpeg'], $options));
    }

    public function scan($filename, $options=[]){
        $command = array("scanimage");
        $command = array_merge($command, $options);
        $dest = sprintf("\"%s/%s\"", $this->outputDir, $filename);
        if ($this->device){
            $command[] = sprintf("--device \"%s\"", $this->device);
        }
        $command[] = ">";
        $command[] = $dest;
        exec(implode(" ", $command));

        return $filename;
    }

}
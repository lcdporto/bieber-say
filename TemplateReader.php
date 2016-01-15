<?php
class TemplateReader{

    private static $instance;
    private $baseMessage = '';
    private $templatesDir = __DIR__ . '/templates/';

    public static function getInstance(){
        if (null === static::$instance) {
            TemplateReader::$instance = new TemplateReader();
        }

        return static::$instance;
    }

    protected function __construct(){}


    function setBaseMessage($baseMessage){
        $this->baseMessage = $baseMessage;
    }

    private function applyMessageArgs($replaceTable){
        $finalMessage = $this->baseMessage;
        foreach($replaceTable as $key => $value){
            $finalMessage = str_replace('{{' . $key . '}}', $value, $finalMessage);
        }
        return $finalMessage;
    }

    function getMessage($replaceTable){
        return $this->applyMessageArgs($replaceTable);
    }


    function getList(){
        $files = glob($this->templatesDir . '*.php');
        $templates = [];
        foreach($files as $key => $value){
            $templateName = str_replace($this->templatesDir, '', $value);
            $templateName = str_replace('.php', '', $templateName);

            $this->load($templateName);
            $templates[$templateName] = $this->baseMessage;
        }

        return $templates;
    }

    function exists($templateName){
        return file_exists($this->templatesDir . $templateName . '.php');
    }

    function load($templateName){
        include $this->templatesDir . $templateName . '.php';
    }

    function save($templateName, $templateMessage){
        $fp=fopen($this->templatesDir . $templateName . '.php','w');
        fwrite($fp, '<?php TemplateReader::getInstance()->setBaseMessage("' . $templateMessage . '"); ');
        fclose($fp);
    }
}

<?php
/**
 * http://platesphp.com
 */
return array(
    "factories" => array(
        "template" => array(hubert\factory\template::class, 'getTemplateEngine')
        ),
    
    
   "config" => array(
       "template" => array(
           "path" => dirname(__dir__).'/app/templates/',
           "fileExtension" => "phtml",
           "extensions" => array(
               hubert\service\template\urlExtension::class
           )
       )
   ),
);

/**
 * //echo $app["template"]->render('index', ['name' => 'Jonathan']);
 */

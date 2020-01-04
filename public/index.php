<?php
/**
 * Created by Gbenga Ogunbule.
 * User: Gbenga Ogunbule
 * Date: 14/9/2018
 * Time: 15:
 */

 try{
     //include __DIR__ . '/../includes/autoload.php';
 	include __DIR__ . '/../vendor/autoload.php';
     //require '/../classes/Utilities/Time.php';

     $route = ltrim(strtok($_SERVER['REQUEST_URI'], '?'), '/');

     $entryPoint =new \Generic\EntryPoint($route, $_SERVER['REQUEST_METHOD'], new \Route\Routes());
     $entryPoint->run();
 }catch(PDOException $e){
     $title = 'An error has occured';

     $output = 'Database error: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine();

     include __DIR__ . '/../template/layouts/application.html.php';
 }
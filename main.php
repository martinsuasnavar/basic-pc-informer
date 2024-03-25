<?php
    /*
    Minimalist program to document information about PC applications from user input

    It must handle:
    + Opening a data file and modifying its information
    + Saving the data file
    
    The data structure is the following:

    app:
        $id,
        $name,
        $size
    
    Size is in MBs
    */

    include "utilities.php";

    $appArray = [];
    echoEndl("Welcome to BASIC PC INFORMER");
    displayMenu();
   

   
    function getFile($appArray){
        $file = fopen("data", "rb");
        if ($file != null){
        
            while (($line = fgets($file)) !== false) {
                $id = trim($line);
                $name = trim(fgets($file)); 
                $size = trim(fgets($file)); 
    
   
                if ($id !== false && $name !== false && $size !== false) {
                    $app = [
                        'id' => $id,
                        'name' => $name,
                        'size' => $size
                    ];
                    $appArray[] = $app;
                } else {
           
                    echoError("Error reading data from file");
                    break;
                }
    
             
                fgets($file);
            }
            fclose($file);
            return $appArray;
        } else {
            $file = fopen("data", "wb");
            echoInfo("File has been created as no data file was found");
            fclose($file);
            return $appArray;
        }
    }

    function resetFile(){
        $file = fopen("data", "rb");
        if ($file != null){
            echo "Overwrite file? (Y/N): ";
            $response = trim(fgets(STDIN));
            if (strtoupper($response) === "Y"){
                echoSuccess("Data file overwritted");
                fopen("data", "wb");
            }
        }else{
            echoError("File not found, you have to create it");
        }
        fclose($file);
    }

    function addData($appArray){
        do{
            echoEndl("Enter PC applications information");
            echo "Id: "; $id = trim(fgets(STDIN));
            if ($id == 0){
                break;
            }
            echo "Name: "; $name = trim(fgets(STDIN));
            echo "Size (in MB): "; $size = trim(fgets(STDIN));

            $app = [
                'id' => $id,
                'name' => $name,
                'size' => $size
            ];
            $appArray[] = $app;
        }while($id != 0);
        echoSuccess("Data added");
        return $appArray;
    }

    function display($appArray) {
        echoEndl("***** ALL PC APPLICATIONS *****");
        if (!empty($appArray)) { 
            foreach ($appArray as $app) {
                echo "id: " . $app['id'] . "\n";
                echo "name: " . $app['name'] . "\n";
                echo "size: " . $app['size'] . "\n";
            }
        } else {
            echoError("No applications found");
        }
    }

    function displayMenu(){
        do{
            echoSkip(1);
            echoEndl("***** MENU *****");
            echoEndl("1: Open/create data file");
            echoEndl("2: Reset data");
            echoEndl("3: Add data");
            echoEndl("4: Display");
            echoEndl("5: Save all changes");
            echoEndl("0: Exit");
            echo ANSI_WHITE . "Select an option: ";

            $option = fgets(STDIN);
            switch($option){
                case 1: $appArray = getFile($appArray); break;
                case 2: resetFile(); break;
                case 3: $appArray = addData($appArray); break;
                case 4: display($appArray); break;
                case 5: saveFile($appArray); break;
                case 0: echoEndl(""); break;
                default: echoError("Invalid option"); $option = -1; break;
            }
        }while($option != 0);
    
    }

function saveFile($appArray){
    $file = fopen("data", "wb");
    if ($file != null){
        foreach ($appArray as $app) {
            fwrite($file, $app['id'] . PHP_EOL);
            fwrite($file, $app['name'] . PHP_EOL);
            fwrite($file, $app['size'] . PHP_EOL);
            fwrite($file, PHP_EOL);
        }
        fclose($file);
        echoSuccess("Changes saved to data file");
    } else {
        echoError("Can't apply any changes because the data file does not exist");
    }
}
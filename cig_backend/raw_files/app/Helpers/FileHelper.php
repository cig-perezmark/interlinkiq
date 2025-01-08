<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    /**
     * Generate a unique filename.
     *
     * @param string $extension
     * @param string $tableName
     * @param string $columnName
     * @return string
     */
    public static function generateUniqueFilename(string $namespace, string $extension): string
    {
        /**
         * 
         *  This automatically generate a prefix based  on Systemname and Modulename + a Unique Generated Filename
         * 
         */

        // Split the namespace by backslash
        $segments = explode('\\', $namespace);

        // Initialize an empty array to hold the formatted parts
        $formattedParts = [];

        // Loop through each segment (SystemName, ModuleNameOne, etc.)
        foreach ($segments as $segment) {
            // Extract capital letters from each segment
            preg_match_all('/[A-Z]/', $segment, $matches);

            // Combine the capital letters and add to the formatted parts array
            $formattedParts[] = implode('', $matches[0]);
        }

        // Join the formatted parts with a hyphen
        $prefix = implode('-', $formattedParts);

        // Generate a unique ID with the prefix
        $generated_filename = uniqid($prefix, true);

        // Append the file extension (with a dot)
        return $generated_filename . '.' . $extension;
    }

    public static function saveFile($file, $generated_filename, $controllerInstance){

        //file, unique generated filename, $this
        try {
            // Dynamically extract the namespace from the controller instance
            $namespace = get_class($controllerInstance); // Get full class name (including namespace)
            $namespace = substr($namespace, strlen('App\Http\Controllers\\')); // Remove base namespace

            // Define the storage directory dynamically using the namespace
            $directory = str_replace('\\', '/', $namespace); // Convert namespace to a valid directory path

            // Store the file with the specified filename in the public storage
            $path = $file->storeAs($directory, $generated_filename, 'public');

            return true; // Return the path of the saved file
        } catch (Exception $e) {
            \Log::error('File upload failed: ' . $e->getMessage()); // Log the error
            return false; // Return false if there's an error
        }
    }


    public static function downloadFile($filename, $controllerInstance){
        try {
            // Dynamically extract the namespace from the controller instance
            $namespace = get_class($controllerInstance); // Get full class name (including namespace)
            $namespace = substr($namespace, strlen('App\Http\Controllers\\')); // Remove base namespace

            // Define the storage directory dynamically using the namespace
            $directory = str_replace('\\', '/', $namespace); // Convert namespace to a valid directory path

            $filePath = storage_path('app/public/' . $directory . '/' . $filename);

            // Check if the file exists
            if (file_exists($filePath)) {
                // Return the file as a download response
                return Response::download($filePath);
            } else {
                // Log error if file is not found
               
                return false;
            }

            
        } catch (Exception $e) {
            \Log::error('File upload failed: ' . $e->getMessage()); // Log the error
            return false; // Return false if there's an error
        }
    }



}

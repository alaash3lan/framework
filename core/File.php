<?php
namespace Core;

class File
{
     /**
     * Directory Separator
     *
     * @const string
     */
    const DS = DIRECTORY_SEPARATOR;

     /**
     * Root Path
     *
     * @var string
     */
    private $root;

     /**
     * Constructor
     *
     * @param string $root
     */
    public function __construct($root)
    {
        $this->root = $root;
    }

    
    /**
     * Check if the given path exists
     * 
     * @param string $path
     * @return bool 
     */
    public function exists($file) :bool
    {
        return file_exists($this->to($file));
    }


    /**
     * Check if the given path is a file
     * 
     * @param string $path
     * @return bool 
     */
    public function isFile(string $path):bool
    {
        return is_file($path);
    }


    /**
     * Check if the given path is a directory
     * 
     * @param string $path
     * @return bool 
     */
    public function isDirectory(string $path):bool
    {
        return is_dir($path);
    }


    /**
     * Create a directory.
     *
     * @param  string  $path
     * @param  int     $mode
     * @param  bool    $recursive
     * @param  bool    $force
     * @return bool
     */
    public function makeDirectory(string $path, int $mode, bool $recursive, bool $force): bool
    {
        return mkdir($path,$mode,$recursive);
    }


    /**
     * Remove all contents of the given directory path and keep the directory
     * 
     * @param  string $path 
     * @return bool
     */
    public function cleanDirectory(string $path) :bool
    {
        $path = $path."/";
        if ($this->isDirectory($path)) {
            $files = glob($path."*"); 
            // pred($files);
            foreach($files as $file) { 
                if ($this->isFile($file)){
                    unlink($file);      
                }
                else if($this->isDirectory($file)){
                    $countable = (new \FilesystemIterator($file))->valid();
                    print $countable;
                     if ($countable) {
                       $this->cleanDirectory($file."/");
                     }
                     rmdir($file);
                }
            }
            return true;
        }
        return false;    
    }


    /**
     * Get the content of the given file path
     * 
     * @param string $path
     * @param bool   $lock
     * @return string
     * @throws FileNotFoundException
     */
    public function get(string $path, bool $lock): string
    {
        $path = $this->to($path);
        try {
            return file_get_contents($path);
        } catch (\Throwable $th) {
           throw $th; 
        }
    }
    

    /**
     * Require the given file path 
     * 
     * @param string $file
     * @return mixed
     */
    public function require(string $file)
    {
        return require $this->to($file);
    }

    /**
     * Require the given file path once 
     * 
     * @param string $file
     * @return mixed
     */
    public function requireOnce(string $file)
    {
        return require_once $this->to($file);
    }



    /**
     * put content to the given file path
     * 
     * @param string $path
     * @param string $content
     * @param int $flags
     * @return int|false 
     */
    public function put(string $path, string $content, int $flags)
    {
        $path = $this->to($path);

        if (!is_writable($dir)) {
            throw new IOException(sprintf('Unable to write to the "%s" directory.', $dir), 0, null, $dir);
        }
        return file_put_contents($path,$content,$flags);
    }
    

    /**
     * Add content to the beginning of the given file path
     * 
     * @param string $path
     * @param string $content
     * @return int|false 
     */
    public function prepend(string $path, string $content)
    {
        $path = $this->to($path);
        $fileContents = file_get_contents($path);
       return file_put_contents($path, $content ."\n". $fileContents);

    }
    
    /**
     * Add content to the end of the given file path
     * 
     * @param string $path
     * @param string $content
     * @return int|false 
     */
    public function append(string $path, string $content)
    {
        $this->put($path,$content,FILE_APPEND);
    }
    

     /**
     * Delete the given path
     * This works with files and directories as well
     * 
     * @param string $path
     * @return bool 
     */
    public function delete(string $path):bool
    {
        $path =  $this->to($path);
        $this->cleanDirectory($path);
        return rmdir($path);
    }

     /**
     * Rename the given path to the new path
     * 
     * @param string $oldPath
     * @param string $newPath
     * @return bool 
     */
    public function rename(string $oldPath, string $newPath):bool
    {
        $oldPath = $this->to($oldPath);
        if ($this->isDirectory($oldPath) || $this->isFile($oldPath)) return rename($oldPath, $newPath);
        return false;
    }

    /**
     * Copy the given path to the new path
     * This works with files and directories as well
     * 
     * @param string $target
     * @param string $destination
     * @return bool 
     */
    public function copy(string $target, string $destination): bool
    {    
        if($this->isFile($target)){
            if ($this->isDirectory($destination)) {
               $fileName = $this->name($target);
               $newFile = $destination."/".$fileName; 
               touch($newFile);
               return copy($target,$newFile);
            }
            return copy($arget,$destination);
        } else if ($this->isDirectory($target)) {
            $this->copyDir($target,$destination);
            return true;
            }
        return false;
    }

    /**
     * copy hole director to new path 
     *
     * @param [string] $target
     * @param [string] $destination
     * @return void
     */
    public function copyDir(string $target,string $destination)
    {
       if ($this->isDirectory($destination)) {
          $files = glob($target."/"."*");
          foreach ($files as $file) {

              if ($this->isFile($file)) {
                  $this->copy($file,$destination);      
              } elseif ($this->isDirectory($file)) {
                $fileName = $this->name($file);
                $newDstination = $destination."/".$fileName; 

                if (!file_exists($newDstination)) mkdir($newDstination, 777);
                $this->copyDir($file,$newDstination);
              }
          }       
       }
    }

    /**
     * Move the given path to the new path
     * This works with files and directories as well
     * 
     * @param string $target
     * @param string $destination
     * @return bool 
     */
    public function move(string $target, string $destination): bool
    {
        $target = $this->to($target);
        $destination = $this->to($destination);
        $file = $this->name($target);
        return rename($target,$destination."/".$file);
    }

    /**
     * Get the MD5 hash of the file at the given path.
     *
     * @param  string  $path
     * @return string
     */
    public function hash(string $path): string
    {
       return hash_file('md5', $path);
    }

    /**
     * Get the file|directory size.
     * If the unit parameter is passed then convert the size to its corresponding unit accordingly
     * Available units: kb|mb|gb
     *  
     * @param  string  $path
     * @param  string  $unit
     * @return float
     */
    public function size(string $path, string $unit): float
    {
        $path = $this->to($path);
        $bytes  =  floatval(filesize($path));

        $con = [
            "gb" => pow(1024,3),
            "mb" => pow(1024,2),
            "kb" => 1024
        ];
        return $bytes/$con[$unit];
    }
    
    /**
     * Get or set UNIX mode of a file or directory.
     * If second parameter is passed, then set the mode otherwise return it.
     *
     * @param  string  $path
     * @param  int  $mode
     * @return mixed
     */
    public function chmod(string $path, int $mode)
    {
        $path = $this->to($path);
        return chmod($path,$mode);
    }

    /**
     * Extract the file name from a file path.
     *
     * @param  string  $path
     * @return string
     */
    public function name(string $path): string
    {
        $temp = explode("/",$path);
        return end($temp);
    }

    /**
     * Extract the trailing name component from a file path.
     *
     * @param  string  $path
     * @return string
     */
    public function basename(string $path): string
    {
        return basename($path);
    }

    /**
     * Extract the parent directory from a file path.
     *
     * @param  string  $path
     * @return string
     */
    public function dirname(string $path):? string
    {
        $temp = explode("/",$path);
        end($temp);
        return prev($temp);
    }

    /**
     * Extract the file extension from a file path.
     *
     * @param  string  $path
     * @return string
     */
    public function extension(string $path):? string
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * Get the file type of a given file.
     *
     * @param  string  $path
     * @return string
     */
    public function type(string $path):? string
    {
        return filetype($path);
    }
    /**
     * Get the mime-type of a given file.
     *
     * @param  string  $path
     * @return string|null
     */
    public function mimeType(string $path):? string
    {
        return mime_content_type($path);
    }

    /**
     * Get the file's last modification time.
     *
     * @param  string  $path
     * @return int
     */
    public function lastModified(string $path): int
    {
        return filemtime($path);
    }

    /**
     * Determine if the given path is readable.
     *
     * @param  string  $path
     * @return bool
     */
    public function isReadable(string $path): bool
    {
        $path = $this->to($path);
        return is_readable($path);
    }
    
    /**
     * Determine if the given path is writable.
     *
     * @param  string  $path
     * @return bool
     */
    public function isWritable(string $path): bool
    {
        $path = $this->to($path);
        return is_writable($path);
    }

    /**
     * Get an array of all files in a directory.
     *
     * @param  string  $directory
     * @param  bool  $hidden
     */
    public function files(string $directory, bool $hidden = false): iterable
    { 
        $dir = $this->to($directory);
        return array_filter($this->list($directory,$hidden),function($file) use($dir)
               {
                    if($this->isDirectory($dir."/".$file)) return false;
                    return true;         
               });    
    }
    
    /**
     * Get an array of all files in a directory recursively.
     *
     * @param  string  $directory
     * @param  bool  $hidden
     */
    public function allFiles(string $directory, bool $hidden = false): iterable
    {
        return array_filter($this->listAll($directory,$hidden), function ($file)
        {
            if(!$this->isDirectory($file))return true;
        });
    }
    
    /**
     * Get an array of all directories in a directory.
     *
     * @param  string  $directory
     * @param  bool  $hidden
     */
    public function directories(string $directory, bool $hidden = false): iterable
    {
        $dir = $this->to($directory);
        return array_filter($this->list($directory,$hidden),function($file) use($dir)
               {
                    if(!$this->isDirectory($dir."/".$file)) return false;
                    return true;         
               });
    }
    
    /**
     * Get an array of all directories in a directory recursively.
     *
     * @param  string  $directory
     * @param  bool  $hidden
     */
    public function allDirectories(string $directory, bool $hidden = false): iterable
    {
        return array_filter($this->listAll($directory,$hidden), function ($file)
        {
            if($this->isDirectory($file))return true;
        });
    }
    
    /**
     * Get an array of all directories and files in a directory.
     *
     * @param  string  $directory
     * @param  bool  $hidden
     */
    public function list(string $directory, bool $hidden = false): iterable
    {
        $dir = $this->to($directory);
        return  array_filter(scandir($dir),function ($file) use ($hidden,$dir)
        {
           if(!$hidden){
                if ($file[0] === ".") {
                  return false;
                } return true;
           } else return true;
        }); 
    }
    
    /**
     * Get an array of all directories and files in a directory recursively.
     *
     * @param  string  $directory
     * @param  bool  $hidden
     */
    public function listAll(string $directory, bool $hidden = false): iterable
    {
        $directory = $this->to($directory);
        $directory = new \RecursiveDirectoryIterator($directory);
        $iterator = new \RecursiveIteratorIterator($directory);
        $files = [];

        if ($hidden) {
            foreach ($iterator as $info) {
                $files[] = $info->getPathname();
            }
                
        } else{
            foreach ($iterator as $info) {
                $file  = $info->getPathname();
               if($this->isHidden($info->getPathname())) continue;
                $files[] = $info->getPathname();
            }

        }
        return $files;
    }


    /**
     * check if file is hidden
     *
     * @param string $path
     * @return boolean
     */
    private function isHidden(string $path)
    {
        $path = \str_replace($this->root,"",$path);
        $temp  =   explode("/",$path);
        foreach ($temp as $file) {  
            if (strlen($file) == 0) {
                continue;
            }
            if (strlen($file) == 1){
               continue;
            } else if(strlen($file) == 2 ) {
                if ($file[1] == ".") {
                  continue;
                }
               continue;
            }
            elseif($file[0] == ".") {
               
                return true;
            }
            continue;
        }
        return false;
    }
    
    /**
     * Find path names matching a given pattern.
     *
     * @param  string  $pattern
     * @param  int     $flags
     * @return array
     */
    public function glob(string $pattern, int $flags = 0): iterable
    {
        return glob($pattern,$flags);
    }
    

     /**
     * Generate full path to the given path in public folder
     *
     * @param string $path
     * @return string
     */
    public function toView($path)
    {
        return $this->to('app/views' . $path);
    }
   /**
   * Generate full path to the given path
   *
   * @param string $path
   * @return string
   */
  public function to($path)
  {
      return $this->root . static::DS . str_replace(['/', '\\'], static::DS, $path);
  }
}

/**
 * makeDirectory bool force
 * get bool lock
 * 
 */
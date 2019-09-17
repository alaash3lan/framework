<?php
namespace Core\Http;

class Validator 
{  
    
    /**
     * Check if the field is empty or not 
     * if empty return error
     * @param string $key
     * @param string $value
     * @return false/string
     */
    public function required(string $key,string $value)
    {
        if (!strlen($value) == 0) {
            return false;
        }
        return sprintf("%s field Required",$key);        
    }

    /**
     * Check if the field is numeric or not 
     * if not return error
     * @param string $key
     * @param string $value
     * @return false/string
     */
    public function numeric(string $key,string $value)
    {
        if (is_numeric($value)) {
            return false;
        }
        return sprintf("%s field must be numeric",$key); 
    }

      /**
     * Check if the string length is bigger than given number or not 
     * if biger return error
     * @param string $key
     * @param string $value
     * @return false/string
     */
    public function max(string $key,string $value,$num)
    {
        if (strlen($value) < $num) {
            return false;
        }
        return sprintf("%s maximum characters is %d",$key, $num);     
    }
    

       /**
     * Check if the string length is less than given number or not 
     * if less return error
     * @param string $key
     * @param string $value
     * @return false/string
     */
    public function min(string $key,string $value,$num)
    {
        if (strlen($value) >= $num) {
            return false;
        }
        return sprintf("%s minimum characters is %d",$key, $num);    
    }

  


    /**
     * Validate that if the field is emeil or not 
     * If emil return false 
     * If not return error
     * @param string $key
     * @param string $str
     * @return false/string
     */
    public function email(string $key ,string $email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        } else {
            return sprintf("%s field must be a email",$key);
        }
    }
}

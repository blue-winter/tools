<?php
namespace admintools\tools\tools;

class ToolDb
{
    private $config;

    public function __construct($config=null)
    {
        if($config){
            $this->config=$config;
        }else{
            $this->install();
        }
        \DB::$host=$this->config['host'];
        \DB::$port=$this->config['port'];
        \DB::$user=$this->config['user'];
        \DB::$password=$this->config['password'];
        \DB::$dbName=$this->config['dbname'];
        \DB::$encoding=$this->config['charset'];
    }

    /**
     * init
     */
    public function init(){

    }

    /**
     * 获取/生成配置文件
     */
    public function install($config=null)
    {
        $path = getBasePath().'tools/';
        if(!is_dir($path)){
            try{
                mkdir ($path,0777,true);
            }catch (\Exception $e){
                return "File creation failed, no permission! \n Please manually create in the root directory of the website: tools/config.php";
                die;
            }
        }
        $file =$path."config.php";
        if(!file_exists($file)){
            if($config){
                $data=$obj =$data=$obj =[
                    'db_config'=>$config
                ];
            }else{
                $data=$obj =[
                    'db_config'=>[
                        'host'      => '127.0.0.1',
                        'dbname'    => 'dbname',
                        'user'      => 'root',
                        'password'  => 'root',
                        'port'      => '3360',
                        'driver'    => 'mysql',
                        'charset'   => 'utf8mb4'
                    ]
                ];
            }

            try{
                $o=fopen($file, "w");
                $txt = "<?php \n  return   ";
                fwrite($o, $txt);
                fclose($o);
                file_put_contents($file,var_export($data,true),FILE_APPEND );
                $o=fopen($file, "a");
                $txt = ";";
                fwrite($o, $txt);
                fclose($o);
            }
            catch (\Exception $e){
                return "File creation failed, no permission! \n Please manually create in the root directory of the website: tools/config.php";
                die;
            }
        }

        if(file_exists($file)){
            try{
                $config = include "$file";
                $config=$config['db_config'];
                $this->config=$config;
            }catch (\Exception $e){}
        }
        else{
            return "File creation failed, no permission! \n Please manually create in the root directory of the website: tools/config.php";

        }

    }

}


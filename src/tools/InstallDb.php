<?php
namespace admintools\tools\tools;
class InstallDb
{

    /**
     * install db
     */
    public function installAll()
    {
        //new ToolDb();
        $sql="CREATE TABLE `tools_core_config` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `name` VARCHAR(255) NULL DEFAULT NULL COMMENT '配置项' COLLATE 'utf8mb4_bin',
                `value` MEDIUMTEXT NULL COMMENT '配置值' COLLATE 'utf8mb4_bin',
                PRIMARY KEY (`id`),
                INDEX `name` (`name`)
                    )
                COLLATE='utf8mb4_bin'
                ENGINE=InnoDB;";
        try{
            \DB::query($sql);
        }catch (\Exception $e){}
        catch (\ErrorException $e){
            
        }



    }

    /**
     * create file
     */
    public function createInstallFile($is_get=false)
    {
        if($is_get){
            $file= getBasePath().'tools/install.lock';
            try{
                if(is_file($file)){
                    return  true;
                }else{
                    return false;
                }

            }catch (\Exception $e){
                return false;
            }
        }else{
            $file= getBasePath().'tools/install.lock';
            try{
                if(is_file($file)){
                    return  true;
                }else{
                    $o=fopen($file, "w");
                    $txt = "Install:".time();
                    fwrite($o, $txt);
                    fclose($o);
                    return  true;
                }

            }catch (\Exception $e){
                return false;
            }
        }
    }

}

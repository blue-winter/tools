<?php
namespace admintools\tools\tools;
class InstallDb
{

    /**
     * install db
     */
    public function installAll()
    {

        $sql ="DROP TABLE IF EXISTS `tools_core_config`;";
        try{
            \DB::query($sql);
        }catch (\Exception $e){}
        catch (\ErrorException $e){
        }
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
        // install block
        $sql ="DROP TABLE IF EXISTS `tools_blocks`;";
        try{
            \DB::query($sql);
        }catch (\Exception $e){}
        catch (\ErrorException $e){
        }

        $sql="  CREATE TABLE `tools_blocks` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`status` TINYINT(2) NULL DEFAULT '1',
	`name` VARCHAR(50) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`block_name` VARCHAR(100) NULL DEFAULT NULL COMMENT 'block name 调用时使用' COLLATE 'utf8_unicode_ci',
	`desc` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`content` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_unicode_ci',
	`create_time` INT(11) NULL DEFAULT NULL,
	`update_time` INT(11) NULL DEFAULT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `block_name` (`block_name`) USING BTREE
)
                COMMENT='admin tools block'
                COLLATE='utf8_unicode_ci'
                ENGINE=InnoDB
                ;";
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

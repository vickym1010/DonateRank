<?php

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\permission\Permission;
use pocketmine\event\Listener;


class Main extends PluginBase implements Listener{
	
	public function onEnable(){
		$this->getLogger()->info(TextFormat::BlUE."Loading Plugin...");
		$this->saveDefaultConfig();
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		if(!(is_dir($this->getDataFolder()."Pending_Users/"))){
			@mkdir($this->getDataFolder()."Pending_Users/");
			$this->getLogger()->info(TextFormat::YELLOW."Folder P_U Generated/Loaded");
		}
		if(!(is_dir($this->getDataFolder()."Activated_Users/"))){
			@mkdir($this->getDataFolder()."Activated_Users/");
			$this->getLogger()->info(TextFormat::YELLOW."Folder A_U Generated/Loaded");
		}
		if(!(is_dir($this->getDataFolder()."Backups/"))){
			@mkdir($this->getDataFolder()."Backups/");
			$filelog = fopen($fileLocation,"w");
			$content = "|---PLAYER NAMES---|----RANK----|---UNIQUE CODE---|";
			fwrite($filelog,$content);
			fclose($filelog);

			$this->getLogger()->info(TextFormat::YELLOW."Backup Folder Created/Loaded");
		}
		
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		if($this->getConfig()->get("AllEnableStart") == "true"){
			$this->allEnabled = "true";
		}else{
			$this->allEnabled = "false";
		}
		$this->playersEnabled = array();
		$this->getLogger()->info(TextFormat::GREEN."Plugin Loaded!");
	}
	public function onDisable(){
		$minute = $this->time()
		$this->getLogger()->info(TextFormat::RED."Donation Rank Disabled!");
		$this->getLogger()->info(TextFormat::YELLOW."Making Plugin backup...");
		$zip = new ZipArchive();
		$filename = "Backups/Backup".$minute.".zip";

		if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
			exit("ERROR, Cannon create ".$filename."\n");
		}
		$zip->addFile($thisdir . "Pending_Users/*","/Activated_Users/*");
		echo "numfiles: " . $zip->numFiles . "\n";
		echo "status:" . $zip->status . "\n";
		$zip->close();
	}

	if(strtolower($command->getName()) == "donation"){
			if(!(isset($args[0]))){
				if ($sender->hasPermission("donrank")){
					$sender->sendMessage(TextFormat::RED."---------DonateRank--------");
					$sender->sendMessage(TextFormat::YELLOW."--No subcommands provided--");
					$sender->sendMessage(TextFormat::GREEN."/donation rank <rank> - Claim a rank");
					$sender->sendMessage(TextFormat::BLUE."/donation rank list - shows a list of ranks available");
					$sender->sendMessage(TextFormat::GREEN."/donation add <rank> - adds a rank to the list (OP)");
					$sender->sendMessage(TextFormat::BLUE."/donation delete <rank> - deletes a rank to the list (OP)");
			}else{
				return true;
			}elseif(isset($args[0])){
				if($args[0] == "rank"){
					if ($sender->hasPermission("donrank.ranks")){
					$sender->sendMessage(TextFormat::RED."[DonateRank] No Subcommand Written:");
					$sender->sendMessage(TextFormat::YELLOW."Use: /donate rank <rank> - to claim a rank");
					$sender->sendMessage(TextFormat::YELlOW."Use: /donate rank list - to get a list of ranks");
					}else{
					$sender->sendMessage($this->permMessage);
					return true;
					}
					}else{
						$sender->sendMessage(TextFormat::RED . "[DonateRank] What? X125");
						return true;
					}
				}elseif($args[0] == "add"){
				// Plugin is still in progress, just saving it for Backup

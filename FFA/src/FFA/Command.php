<?php

namespace FFA;

use pocketmine\command\{PluginCommand, CommandSender, PluginIdentifiableCommand};
use pocketmine\utils\TextFormat as TE;

class Command extends PluginCommand implements PluginIdentifiableCommand {
	
	/**
	 * Command Constructor.
	 */
	public function __construct(){
		parent::__construct("ffa", Loader::getInstance());
	}
	
	/**
	 * @param CommandSender $sender
	 * @param String $commandLabel
	 * @param Array $args
	 * @return void
	 */
	public function execute(CommandSender $sender, String $commandLabel, Array $args) : void {
		if(count($args) === 0){
			$sender->sendMessage(TE::RED."Use: /{$commandLabel} help (view list of commands)");
			return;
		}
		if(!$sender->hasPermission("use.command.ffa")){
			$sender->sendMessage(TE::RED."You have not permissions to use this command!");
			return;
		}
		switch($args[0]){
			case "create":
				if(empty($args[1])){
					$sender->sendMessage(TE::GRAY."Use: ".TE::YELLOW."/{$commandLabel} {$args[0]} <arenaName>");
					return;
				}
				if(Loader::getInstance()->isArena($args[1])){
					$sender->sendMessage(TE::RED."The arena {$args[1]} alredy exists!");
					return;
				}
				Loader::getInstance()->addArena($args[1]);
				$sender->sendMessage(TE::GREEN."The arena {$args[1]} was create correctly!");
			break;
			case "delete":
				if(empty($args[1])){
					$sender->sendMessage(TE::GRAY."Use: ".TE::YELLOW."/{$commandLabel} {$args[0]} <arenaName>");
					return;
				}
				if(!Loader::getInstance()->isArena($args[1])){
					$sender->sendMessage(TE::RED."The arena {$args[1]} was never created!");
					return;
				}
				Loader::getInstance()->deleteArena($args[1]);
				$sender->sendMessage(TE::GREEN."The arena {$args[1]} was delete correctly!");
			break;
			case "setspawn":
				if(!Loader::getInstance()->isArena($sender->getLevel()->getName())){
					$sender->sendMessage(TE::RED."The arena {$sender->getLevel()->getName()} was never created!");
					return;
				}
				Loader::getInstance()->addSpawn($sender->getPosition());
				$sender->sendMessage(TE::GREEN."Spawn was registered at the coordinates: ".TE::AQUA.$sender->getX().TE::GRAY.", ".TE::AQUA.$sender->getY().TE::GRAY.", ".TE::AQUA.$sender->getZ());
			break;
			case "join":
				Loader::getInstance()->joinToArena($sender);
			break;
			case "help":
			case "?":
				$sender->sendMessage(TE::GRAY."=======================");
				$sender->sendMessage(TE::YELLOW."Use: ".TE::GREEN."/{$commandLabel} create <arenaName> ".TE::GRAY."(To create a new arena)");
				$sender->sendMessage(TE::YELLOW."Use: ".TE::GREEN."/{$commandLabel} delete <arenaName> ".TE::GRAY."(To remove a arena)");
				$sender->sendMessage(TE::YELLOW."Use: ".TE::GREEN."/{$commandLabel} setspawn ".TE::GRAY."(To create the player spawn point)");
				$sender->sendMessage(TE::GRAY."=======================");
			break;
		}
	}
}

?>
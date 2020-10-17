<?php

/**
 * FFA - PocketMine plugin.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Author: iBryMax
 * Website: https://github.com/iBryMax/Free-For-All-Basic-Game
 */

namespace FFA;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\math\Vector3;
use pocketmine\utils\{Config, TextFormat as TE};

use RuntimeException;

class Loader extends PluginBase implements Listener {
	
	/** @var Loader */
	protected static $pluginLogger = null;
	
	public function onLoad(){
		//TODO:
		self::$pluginLogger = $this;
	}
	
	public function onEnable(){
		//TODO:
		$this->getServer()->getCommandMap()->register("/ffa", new Command());
	}
	
	public function onDisable(){
		//TODO:
	}
	
	/**
	 * @return Loader
	 */
	public static function getInstance() : Loader {
		if(self::$pluginLogger === null){
			throw new RuntimeException("Can't instantiate main class");
		}
		return self::$pluginLogger;
	}
		
	/**
	 * @param String $arenaName
	 * @return bool
	 */
	public function isArena(String $arenaName) : bool {
		$config = new Config($this->getDataFolder()."config.yml", Config::YAML);
		if($config->exists($arenaName)){
			return true;
		}else{
			return false;
		}
		return false;
	}
	
	/**
	 * @param Vector3 $position
	 */
	public function addSpawn(Vector3 $position){
		$config = new Config($this->getDataFolder()."config.yml", Config::YAML);
		$config->set("Spawn", [$position->getLevel(), $position->getX(), $position->getY(), $position->getZ()]);
		$config->save();
	}
	
	/**
	 * @return Vector3
	 */
	public function getPositionSpawn() : Vector3 {
		$config = new Config($this->getDataFolder()."config.yml", Config::YAML);
		$spawn = $config->get("Spawn");
		return new Vector3($spawn[1], $spawn[2], $spawn[3], $spawn[0]);
	}
	
	/**
	 * @param String $arenaName
	 */
	public function addArena(String $arenaName){
		$config = new Config($this->getDataFolder()."config.yml", Config::YAML);
		$config->set("Arena", $arenaName);
		$config->save();
	}
	
	/**
	 * @param String $arenaName
	 */
	public function deleteArena(String $arenaName){
		$config = new Config($this->getDataFolder()."config.yml", Config::YAML);
		$config->remove($arenaName);
		$config->save();
	}
	
	/**
	 * @param Player $player
	 */
	public function joinToArena(Player $player){
		$player->teleport($this->getPositionSpawn());
	}
}

?>

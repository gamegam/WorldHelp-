<?php

namespace WorldEditUP\WorldEditUP\cmd;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use WorldEditUP\WorldEditUP\Main;

class UPCommand extends Command{

	public function __construct(){
		parent::__construct("up", "/up command", null, ["/up"]);
		$this->setPermission('up.cmd');
	}
	public function execute(CommandSender $p, string $label, array $args): bool{
		if (! $this->testPermission($p)){
			return true;
		}
		if (! $p instanceof Player){
			$p->sendMessage("§cTo use this command, you must connect to the server.");
			return true;
		}
		$y = $p->getPosition()->getY();
		if (!isset($args[0])){
			$p->sendMessage("§d/up [number] It goes up by that number.");
			return false;
		}
		if (!is_numeric($args[0])){
			$p->sendMessage("§bPlease write a number");
			return false;
		}
		if ($args[0] < 0){
			$p->sendMessage("§cdo not write negative numbers");
			return true;
		}
		if ($y + $args[0] > 320 || $args[0] > 320){
			Main::getInstance()->UP($p, $args[0]);
		}else{
			Main::getInstance()->UP($p, $args[0]);
		}
		return true;
    }
}

<?php

namespace WorldEditUP\WorldEditUP;

use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use WorldEditUP\WorldEditUP\com\Event;
use pocketmine\player\Player;
use pocketmine\world\Position;
use pocketmine\math\Vector3;
use pocketmine\block\VanillaBlocks;
use WorldEditUP\WorldEditUP\cmd\UPCommand;

class Main extends PluginBase implements Listener{

    private static $instance = null;

    public function onEnable():void{
        $this->getServer()->getPluginManager()->registerEvents(new Event($this), $this);
        $this->getServer()->getCommandMap()->registerAll("cmd", [new UPCommand()]);
    }

    public function onLoad(): void{
        if (self::$instance == null)
        self::$instance = $this;
    }

    public static function getInstance(){
        return static::$instance;
    }

    public function UP(Player $p, $int){
        $numeric = $int ?? "0";
        $pos = $p->getPosition();
        $newY = floatval($pos->getY()) + $numeric;
        if ($newY > 320){
            $newY = 320;
        }
        $p->teleport(new Position(floatval($pos->getX()), $newY, floatval($pos->getZ()), $p->getWorld()));
        $p->sendMessage("§dIt has risen to a height equal to that number.");
        $p->getWorld()->setBlock(new Vector3($pos->getX(), $newY - 1, $pos->getZ()), VanillaBlocks::GLASS());
    }
}

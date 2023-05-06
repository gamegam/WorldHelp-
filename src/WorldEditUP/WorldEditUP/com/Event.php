<?php

namespace WorldEditUP\WorldEditUP\com;

use pocketmine\event\Listener;
use pocketmine\event\player\{PlayerItemUseEvent, PlayerInteractEvent};
use pocketmine\math\Vector3;
use pocketmine\Server;
use pocketmine\world\Position;
use pocketmine\block\Air;
use pocketmine\event\block\BlockBreakEvent;

class Event implements Listener{

    public function BlockKd(BlockBreakEvent $ev){
        $p = $ev->getPlayer();
        $block = $ev->getBlock();
        $pos = $p->getPosition ();
        $item = $p->getInventory()->getItemInHand();
        if (Server::getInstance()->isOP($p->getName())){
            if($item->getTypeId() == 20074){
                $p->teleport(new Vector3($pos->getX(), $p->getWorld()->getHighestBlockAt($pos->getFloorX(), $pos->getFloorZ()) + 1, $pos->getZ()));
                $ev->cancel();
                $p->sendTip("§dTeleported to the top of the block.");
            }
        }
    }
    public function onToucsh(PlayerInteractEvent $ev){
        $p = $ev->getPlayer();
        $block = $ev->getBlock();
        $bb = $block->getPosition();
        $item = $p->getInventory()->getItemInHand();
        $x = $p->getPosition();
        if (Server::getInstance()->isOP($p->getName())){
            if($item->getTypeId() == 20074){ 
                $p->teleport(new Position(floatval($bb->x) + 0.5, floatval($bb->y) + 1, floatval($bb->z) +0.5, $p->getWorld()));
                $ev->cancel();
            }
        }
    }

    public function PlayerItemUseEvent(PlayerItemUseEvent $ev){
        $p = $ev->getPlayer();
        $pos = $p->getPosition ();
        $item = $p->getInventory()->getItemInHand();
        if (Server::getInstance()->isOP($p->getName())){
            if($item->getTypeId() == 20074){
                $blockPos = $p->getTargetBlock(100);
                if ($blockPos instanceof Air){
                    $p->sendMessage("§cNothing within 100 meters (void).");
                    return false;
                }
                $ev->cancel();
                $directionVector = $p->getDirectionVector();
                $bp = $blockPos->getPosition();
                $x = $bp->getX() + 0.5 + $directionVector->x;
                $y = $bp->getY() + 1.0;
                $z = $bp->getZ() + 0.5 + $directionVector->z;
                $p->teleport(new Vector3($x, $y, $z));
            }
        }
    }
}

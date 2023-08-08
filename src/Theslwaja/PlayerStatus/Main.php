<?php

namespace Theslwaja\PlayerStatus;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use Ifera\ScoreHud\event\TagsResolveEvent;

class Main extends PluginBase implements Listener{

    public function onEnable(): void {
	if($this->getServer()->getPluginManager()->getPlugin("ScoreHud") != null){
           $this->getServer()->getPluginManager()->registerEvent(new TagResolceEvent(), $this);
	}
    }
    
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
    {
        if($command->getName() == "player"){
            if(count($args) < 1){
                $sender->sendMessage("Usage /player <name>");
                return false;
            }
            $name = implode($args);
            $os = ["Unknown", "Android", "iOS", "macOS", "FireOS", "GearVR", "HoloLens", "Windows 10", "Windows", "Dedicated", "Orbis", "Playstation 4", "Nintento Switch", "Xbox One"];
            $controls = ["Unknown", "Mouse & Keyboard", "Touch", "Controller"];
            $player = Server::getInstance()->getPlayerByPrefix($name);
            if($player instanceof Player){
                $sender->sendMessage(TextFormat::GRAY . "Player: " . $player->getName() . " : Device: " . $os[$player->getPlayerInfo()->getExtraData()["DeviceOS"] ?? 0] . " : Ping: " . $player->getNetworkSession()->getPing() . " : Control: " . $controls[$player->getPlayerInfo()->getExtraData()["CurrentInputMode"] ?? 0] . " : Device Model: " . $player->getPlayerInfo()->getExtraData()["DeviceModel"]);
            } else {
                $sender->sendMessage(TextFormat::RED . "Player not found!");
            }
        }
        return true;
    }

    public function onTagResolve(TagsResolveEvent $event){
	    $player = $event->getPlayer();
	    $tag = $event->getTag();

        $os = ["Unknown", "Android", "iOS", "macOS", "FireOS", "GearVR", "HoloLens", "Windows 10", "Windows", "Dedicated", "Orbis", "Playstation 4", "Nintento Switch", "Xbox One"];
        $controls = ["Unknown", "Mouse & Keyboard", "Touch", "Controller"];

	    switch($tag->getName()){
		    case "playerstatus.device":
		    	$tag->setValue($os[$player->getPlayerInfo()->getExtraData()["DeviceOS"] ?? 0]);
		    break;

		    case "playerstatus.control":
			    $tag->setValue($controls[$player->getPlayerInfo()->getExtraData()["CurrentInputMode"] ?? 0]);
		    break;

		    case "playerstatus.devicemodel":
		    	$tag->setValue($player->getPlayerInfo()->getExtraData()["DeviceModel"]);
		    break;
	    }
    }
}

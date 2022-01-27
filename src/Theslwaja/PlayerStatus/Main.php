
<?php

namespace Theslwaja/PlayerStatus;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class Main extends PluginBase{

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
                $sender->sendMessage(TextFormat::GRAY . "Player: " . $player->getName() . " : Device: " . $os[$player->getPlayerInfo()->getExtraData()["DeviceOS"] ?? 0] . " : Ping: " . $player->getNetworkSession()->getPing() . " : Control: " . $controls[$player->getPlayerInfo()->getExtraData()["CurrentInputMode"] ?? 0] . " : Device Model: " . $player->getPlayerInfo()->getExtraData()["DeviceModel"] ?? "Unknown");
            } else {
                $sender->sendMessage(TextFormat::RED . "Player not found!");
            }
        }
        return true;
    }
}

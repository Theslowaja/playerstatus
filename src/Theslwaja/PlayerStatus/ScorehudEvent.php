<?php

namespace Theslwaja\PlayerStatus;

use pocketmine\event\Listener;
use Ifera\ScoreHud\event\TagsResolveEvent;

class ScorehudEvent implements Listener {

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

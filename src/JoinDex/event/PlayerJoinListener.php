<?php

namespace JoinDex\event;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use JoinDex\Main;
use pocketmine\utils\TextFormat;

class PlayerJoinListener implements Listener {

    public function onPlayerJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $plugin = Main::getInstance();

        // Check if this is the first time the player has joined the server
        if ($player->hasPlayedBefore()) {
            if ($plugin->isWelcomeMessageEnabled()) {
                $message = $plugin->getWelcomeMessage();
                $message = str_replace("{player}", $player->getName(), $message);
                $message = TextFormat::colorize($message);
                $player->sendMessage($message);

                if ($plugin->isLogWelcomeMessageEnabled()) {
                    $plugin->getLogger()->info("A welcome message has been sent to " . $player->getName());
                }
            }
        } else {
            if ($plugin->isFirstJoinMessageEnabled()) {
                $message = $plugin->getFirstJoinMessage();
                $message = str_replace("{player}", $player->getName(), $message);
                $message = TextFormat::colorize($message);
                $player->sendMessage($message);

                if ($plugin->isLogFirstJoinMessageEnabled()) {
                    $plugin->getLogger()->info("A welcome message has been sent for the first entry to " . $player->getName());
                }
            }
        }
    }
}

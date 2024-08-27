<?php

namespace JoinDex\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use JoinDex\Main;

class SetWelcomeCommand extends Command {

    public function __construct() {
        parent::__construct("setwelcome", "Set the welcome message", "/setwelcome <tipo> <mensaje>", []);
        $this->setPermission("welcomemessage.set");
    }

    public function execute(CommandSender $sender, string $label, array $args): bool {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage("Este comando solo puede ser usado en el juego.");
            return true;
        }

        if (count($args) < 2) {
            $sender->sendMessage("Uso: /setwelcome <tipo> <mensaje>");
            return false;
        }

        $type = strtolower($args[0]);
        $message = implode(" ", array_slice($args, 1)); // Tomar el resto de los argumentos como el mensaje

        $plugin = Main::getInstance();

        switch ($type) {
            case "welcome":
                $plugin->setWelcomeMessage($message);
                $sender->sendMessage("Mensaje de bienvenida para jugadores recurrentes actualizado a: " . TextFormat::colorize($message));
                break;

            case "firstjoin":
                $plugin->setFirstJoinMessage($message);
                $sender->sendMessage("Mensaje de bienvenida para nuevos jugadores actualizado a: " . TextFormat::colorize($message));
                break;

            default:
                $sender->sendMessage("Tipo no válido. Usa 'welcome' o 'firstjoin'.");
                return false;
        }

        return true;
    }
}

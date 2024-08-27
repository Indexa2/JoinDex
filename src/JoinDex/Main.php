<?php

namespace JoinDex;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use JoinDex\event\PlayerJoinListener;
use JoinDex\command\SetWelcomeCommand;

class Main extends PluginBase {
    use SingletonTrait;

    private bool $enableWelcomeMessage;
    private bool $enableFirstJoinMessage;
    private string $welcomeMessage;
    private string $firstJoinMessage;
    private bool $logWelcomeMessage;
    private bool $logFirstJoinMessage;

    public function onEnable(): void {
        self::setInstance($this);

        // Cargar la configuración
        $this->loadConfigData();

        // Registrar el listener
        $this->getServer()->getPluginManager()->registerEvents(new PlayerJoinListener(), $this);

        // Registrar el comando
        $this->getServer()->getCommandMap()->register("setwelcome", new SetWelcomeCommand());

        $this->getLogger()->info("JoinDex enabled!");
    }

    // Método para cargar las configuraciones
    public function loadConfigData(): void {
        $this->saveDefaultConfig();
        $config = $this->getConfig();

        $this->enableWelcomeMessage = $config->get("enable-welcome-message", true);
        $this->enableFirstJoinMessage = $config->get("enable-first-join-message", true);
        $this->welcomeMessage = $config->get("welcome-message", "§a¡Bienvenido de nuevo, {player}!");
        $this->firstJoinMessage = $config->get("first-join-message", "§b¡Es tu primera vez aquí, {player}! ¡Esperamos que te diviertas!");
        $this->logWelcomeMessage = $config->get("log-welcome-message", true);
        $this->logFirstJoinMessage = $config->get("log-first-join-message", true);
    }

    // Métodos de acceso a las configuraciones
    public function isWelcomeMessageEnabled(): bool {
        return $this->enableWelcomeMessage;
    }

    public function isFirstJoinMessageEnabled(): bool {
        return $this->enableFirstJoinMessage;
    }

    public function getWelcomeMessage(): string {
        return $this->welcomeMessage;
    }

    public function getFirstJoinMessage(): string {
        return $this->firstJoinMessage;
    }

    public function isLogWelcomeMessageEnabled(): bool {
        return $this->logWelcomeMessage;
    }

    public function isLogFirstJoinMessageEnabled(): bool {
        return $this->logFirstJoinMessage;
    }

    // Métodos para establecer los mensajes y guardar en config.yml
    public function setWelcomeMessage(string $message): void {
        $this->getConfig()->set("welcome-message", $message);
        $this->getConfig()->save();
        $this->loadConfigData(); // Recargar la configuración
    }

    public function setFirstJoinMessage(string $message): void {
        $this->getConfig()->set("first-join-message", $message);
        $this->getConfig()->save();
        $this->loadConfigData(); // Recargar la configuración
    }

    public function onDisable(): void {
        $this->getLogger()->info("JoinDex disabled!");
    }
}

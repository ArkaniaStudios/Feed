<?php

/*
 *     _      ____    _  __     _      _   _   ___      _
 *    / \    |  _ \  | |/ /    / \    | \ | | |_ _|    / \
 *   / _ \   | |_) | | ' /    / _ \   |  \| |  | |    / _ \
 *  / ___ \  |  _ <  | . \   / ___ \  | |\  |  | |   / ___ \
 * /_/   \_\ |_| \_\ |_|\_\ /_/   \_\ |_| \_| |___| /_/   \_\
 *
 * @author Julien
 * @link https://arkaniastudios.com/Feed
 * @version 1.0.0
 *
 */

declare(strict_types=1);

namespace feed;

use feed\command\FeedCommand;
use pocketmine\permission\DefaultPermissions;
use pocketmine\permission\Permission;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use function time;

class Main extends PluginBase {
	/** @var array<string, int> */
	private array $cooldown = [];

	public Config $config;

	protected function onLoad() : void {
		$this->saveResource('config.yml', false);
		$this->config = new Config($this->getDataFolder() . 'config.yml', Config::YAML);
		if ($this->config->get('load-plugin-message', true) === true) {
			$this->getLogger()->info($this->config->get('load-plugin-message-text', '§aFeed plugin has been loaded.'));
		}
		$this->loadCooldown();
	}

	private function type(string $match) : Permission {
		$consoleRoot  = DefaultPermissions::registerPermission(new Permission(DefaultPermissions::ROOT_CONSOLE));
		$operatorRoot = DefaultPermissions::registerPermission(new Permission(DefaultPermissions::ROOT_OPERATOR, '', [$consoleRoot]));
		$everyoneRoot = DefaultPermissions::registerPermission(new Permission(DefaultPermissions::ROOT_USER, ''), [$operatorRoot]);
		return match ($match) {
			'console' => $consoleRoot,
			'op'      => $operatorRoot,
			default   => $everyoneRoot
		};
	}

	protected function onEnable() : void {
		$config = $this->config;
		if ($config->get('enable-plugin-message', true) === true) {
			$this->getLogger()->info($config->get('enable-plugin-message-text', '§aFeed plugin has been enabled.'));
		}

		$permission      = new Permission($config->get('permission', 'feed.command'));
		$permissionOther = new Permission($config->get('permission-feed-others', 'feed.command.other'));
		DefaultPermissions::registerPermission($permission, [$this->type($config->get('default', 'everyone'))]);
		DefaultPermissions::registerPermission($permissionOther, [$this->type($config->get('default-feed-others', 'everyone'))]);

		$this->getServer()->getCommandMap()->register(
			'FeedCommand-Command',
			new FeedCommand(
				$this,
				$config->get('name', 'feed'),
				$config->get('description', 'Feed command'),
				$config->get('usage', '/feed [player]'),
				$config->get('aliases', ['eat']),
				$config->get('permission', 'feed.command')
			)
		);

	}

	protected function onDisable() : void {
		$this->saveCooldown();
		if ($this->config->get('disable-plugin-message', true) === true) {
			$this->getLogger()->info($this->config->get('disable-plugin-message-text', '§cFeed plugin has been unloaded.'));
		}
	}

	public function addCooldown(string $player) : void {
		if($this->config->get('cooldown', 5) <= 0) {
			return;
		}
		$this->cooldown[$player] = time() + $this->getConfig()->get('cooldown', 5);
	}

	public function getCooldown(string $player) : int {
		return $this->cooldown[$player] ?? 0;
	}

	private function saveCooldown() : void {
		$this->config->set('cooldown-list', $this->cooldown);
		$this->config->save();
	}

	private function loadCooldown() : void {
		$this->cooldown = $this->config->get('cooldown-list', []);
	}

}

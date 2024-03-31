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

namespace feed\command;

use feed\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\lang\Translatable;
use pocketmine\permission\Permission;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use function str_replace;
use function time;

class FeedCommand extends Command {
	private Main $plugin;

	public function __construct(
		Main $plugin,
		string $name,
		string|Translatable $description,
		null|string|Translatable $usageMessage,
		array $aliases,
		string $permission
	) {
		parent::__construct(
			$name,
			$description,
			$usageMessage,
			$aliases
		);
		$this->setPermission($permission);
		$this->plugin = $plugin;
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : void {
		$config = $this->plugin->config;
		if (!$sender instanceof Player) {
			if ($config->get('console-can-feed-other', true) === true) {
				if($this->plugin->getCooldown($sender->getName()) <= time()) {
					if(isset($args[0])) {
						if($config->get('must-pseudo-exact', true)) {
							$player = $this->plugin->getServer()->getPlayerExact($args[0]);
						} else {
							$player = $this->plugin->getServer()->getPlayerByPrefix($args[0]);
						}
						if($player !== null) {
							$this->feed($player, $config, $sender);
							if($config->get('cooldown-in-console', true) === true) {
								$this->plugin->addCooldown($player->getName());
							}
						} else {
							$sender->sendMessage($config->get('player-not-found-message', '§cPlayer not found.'));
						}
					} else {
						$sender->sendMessage($config->get('usage', '/feed [player]'));
					}
				} else {
					$sender->sendMessage(
						str_replace(
							'%time%',
							(string) ($this->plugin->getCooldown($sender->getName()) - time()),
							$config->get('cooldown-message', '§cYou can feed again in ' . $this->plugin->getCooldown($sender->getName()) - time() . ' seconds.')
						)
					);
				}
			} else {
				$sender->sendMessage($config->get('console-cannot-feed-other-message'));
			}
			return;
		}
		if($this->plugin->getCooldown($sender->getName()) <= time()) {
			if(!isset($args[0])) {
				$sender->getHungerManager()->setFood($config->get('food-restored', 20));
				$sender->getHungerManager()->setSaturation($config->get('saturation-restored', 20));
				$sender->sendMessage($config->get('feed-message', '§aYou have been fed.'));
				if($config->get('cooldown', -1) >= 0) {
					$this->plugin->addCooldown($sender->getName());
				}
			} else {
				if($sender->hasPermission($config->get('permission-feed-others'))) {
					if($config->get('must-pseudo-exact', true)) {
						$player = $this->plugin->getServer()->getPlayerExact($args[0]);
					} else {
						$player = $this->plugin->getServer()->getPlayerByPrefix($args[0]);
					}
					if($player !== null) {
						$this->feed($player, $config, $sender);
						if($config->get('cooldown', -1) >= 0) {
							$this->plugin->addCooldown($player->getName());
						}
					} else {
						$sender->sendMessage($config->get('player-not-found-message', '§cPlayer not found.'));
					}
				} else {
					$sender->sendMessage(KnownTranslationFactory::commands_generic_permission());
				}
			}
		} else {
			$sender->sendMessage(
				str_replace(
					'%time%',
					(string) ($this->plugin->getCooldown($sender->getName()) - time()),
					$config->get('cooldown-message', '§cYou can feed again in ' . $this->plugin->getCooldown($sender->getName()) - time() . ' seconds.')
				)
			);
		}

	}
	public function feed(Player $player, Config $config, CommandSender|Player $sender) : void {
		$player->getHungerManager()->setFood($config->get('food-restored', 20));
		$player->getHungerManager()->setSaturation($config->get('saturation-restored', 20));
		$sender->sendMessage(
			str_replace(
				'%player%',
				$player->getName(),
				$config->get('feed-other-message', '§aYou have fed' . $player->getName())
			)
		);
		$player->sendMessage(
			str_replace(
				'%player%',
				$player->getName(),
				$config->get('feed-by-other-message', '§aYou have been fed by' . $sender->getName())
			)
		);
	}

}

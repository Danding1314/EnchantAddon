<?php

declare(strict_types=1);

namespace TPE\EnchantAddon\Commands;

use DaPigGuy\PiggyCustomEnchants\enchants\CustomEnchant;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\Player;
use TPE\EnchantAddon\EnchantAddon;

class TinkererCommand extends PluginCommand {

    private $plugin;

    public function __construct(EnchantAddon $plugin) {
        parent::__construct("tinkerer", $plugin);
        $this->plugin = $plugin;
        $this->setPermission("tinkerer.command");
        $this->setDescription("Gets rid of all enchants on the item within your hand in return for XP");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$this->testPermission($sender)) {
            $sender->sendMessage($this->plugin->getConfig()->get("no-perms-message"));
            return false;
        }

        if(!$sender instanceof Player) {
            $sender->sendMessage("You can not run that command via console!");
            return false;
        }

        $item = $sender->getInventory()->getItemInHand();

        if(!$item->hasEnchantments()) {
            $sender->sendMessage($this->plugin->getConfig()->get("no-enchants-message"));
            return false;
        }

        $profit = 0;

        foreach($item->getEnchantments() as $enchantment) {

            $level = $enchantment->getLevel();
            $id = $enchantment->getId();

            if($enchantment instanceof CustomEnchant) {

                if($enchantment->getRarity() == 10) {

                    $xp = $this->plugin->getConfig()->get("common-xp-amount");
                    $sender->addXp((int)$xp);
                    $profit += $xp;
                    $item->removeEnchantment($id, $level);

                } elseif($enchantment->getRarity() == 5) {

                    $xp = $this->plugin->getConfig()->get("uncommon-xp-amount");
                    $sender->addXp((int)$xp);
                    $profit += $xp;
                    $item->removeEnchantment($id, $level);

                } elseif($enchantment->getRarity() == 2) {

                    $xp = $this->plugin->getConfig()->get("rare-xp-amount");
                    $sender->addXp((int)$xp);
                    $profit += $xp;
                    $item->removeEnchantment($id, $level);

                } elseif($enchantment->getRarity() == 1) {

                    $xp = $this->plugin->getConfig()->get("mythic-xp-amount");
                    $sender->addXp((int)$xp);
                    $profit += $xp;
                    $item->removeEnchantment($id, $level);

                }

            } elseif($enchantment instanceof Enchantment) {

                $xp = $this->plugin->getConfig()->get("vanilla-xp-amount");
                $sender->addXp((int)$xp);
                $profit += $xp;
                $item->removeEnchantment($id, $level);

            }
        }

        $sender->sendMessage($this->plugin->getConfig()->get(str_replace("{AMOUNT}", $profit, $this->plugin->getConfig()->get("successfully-tinkered"))));

        return true;
    }

}
<?php

declare(strict_types=1);

namespace TPE\EnchantAddon;

use DaPigGuy\PiggyCustomEnchants\CustomEnchantManager;
use DaPigGuy\PiggyCustomEnchants\PiggyCustomEnchants;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\nbt\tag\IntTag;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use TPE\EnchantAddon\Commands\TinkererCommand;

class EnchantAddon extends PluginBase {

    public function  onEnable() {
        if($this->getServer()->getPluginManager()->getPlugin("PiggyCustomEnchants") == null) {
            $this->getServer()->getPluginManager()->disablePlugin($this);
            $this->getLogger()->error("PiggyCustomEnchants must be installed in order for this plugin to work! Download it here: https://poggit.pmmp.io/p/PiggyCustomEnchants");
        }
        $this->getServer()->getCommandMap()->register("EnchantAddon", new TinkererCommand($this));
    }

    // WIP, ignore
   /** public function getCeBook(int $enchantId, int $level = 1, int $success = 100) : ?Item {
        $book = Item::get(Item::BOOK);
        $enchantment = CustomEnchantManager::getEnchantment($enchantId);
        if(!$enchantment == null) {
            $instance = new EnchantmentInstance(CustomEnchantManager::getEnchantment($enchantId));
            $desc = $enchantment->getDescription();
            $desc = chunk_split($desc, "46", "\n");
            $book->setCustomName(TextFormat::RESET . TextFormat::BOLD . TextFormat::YELLOW . $enchantment->getName() . " " . $instance->getLevel());
            $book->setLore([
                TextFormat::RESET . TextFormat::DARK_GRAY . $desc,
                TextFormat::RESET . TextFormat::LIGHT_PURPLE . "Success: " . TextFormat::RESET . "$success%"
            ]);
        }

        $book->setNamedTagEntry(new IntTag("enchantbook", $enchantId));
        $book->setNamedTagEntry(new IntTag("levelbook", $level));
        $book->setNamedTagEntry(new IntTag("successbook", $success));
        return $book;
    }*/

}
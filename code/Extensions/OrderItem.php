<?php
/**
 * Milkyway Multimedia
 * OrderItem.php
 *
 * @package reggardocolaianni.com
 * @author Mellisa Hankins <mell@milkywaymultimedia.com.au>
 */

namespace Milkyway\SS\Shop\Inventory\Extensions;


class OrderItem extends \DataExtension {
    function onPlacement() {
        if($this->isAffectedItem($this->owner->Buyable(), 'placement'))
            $this->owner->Buyable()->decrementStock($this->owner->Quantity);
    }

    function onPayment() {
        if($this->isAffectedItem($this->owner->Buyable(), 'payment'))
            $this->owner->Buyable()->decrementStock($this->owner->Quantity);
    }

    function onBeforeDelete() {
        if($this->owner->_ReturnStock)
            $this->owner->Buyable()->incrementStock($this->owner->Quantity);
    }

    protected function isAffectedItem($buyable, $during) {
        return !SiteConfig::env('Shop_DisableInventory') && strtolower(SiteConfig::env('Shop_AffectStockDuring')) == $during && ($buyable instanceof \Object) && $buyable->hasExtension('Milkyway\SS\Shop\Inventory\Extensions\Product');
    }
} 
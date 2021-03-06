<?php
/**
 * BillUpdateService.php
 * Copyright (c) 2018 thegrumpydictator@gmail.com
 *
 * This file is part of Firefly III.
 *
 * Firefly III is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Firefly III is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Firefly III. If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace FireflyIII\Services\Internal\Update;

use FireflyIII\Models\Bill;
use FireflyIII\Services\Internal\Support\BillServiceTrait;

/**
 * @codeCoverageIgnore
 * Class BillUpdateService
 */
class BillUpdateService
{
    use BillServiceTrait;

    /**
     * @param Bill  $bill
     * @param array $data
     *
     * @return Bill
     */
    public function update(Bill $bill, array $data): Bill
    {

        $matchArray = explode(',', $data['match']);
        $matchArray = array_unique($matchArray);
        $match      = join(',', $matchArray);

        $bill->name        = $data['name'];
        $bill->match       = $match;
        $bill->amount_min  = $data['amount_min'];
        $bill->amount_max  = $data['amount_max'];
        $bill->date        = $data['date'];
        $bill->repeat_freq = $data['repeat_freq'];
        $bill->skip        = $data['skip'];
        $bill->automatch   = $data['automatch'];
        $bill->active      = $data['active'];
        $bill->save();

        // update note:
        if (isset($data['notes']) && null !== $data['notes']) {
            $this->updateNote($bill, strval($data['notes']));
        }

        return $bill;
    }

}

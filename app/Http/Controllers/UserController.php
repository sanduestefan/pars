<?php

namespace App\Http\Controllers;

use App\Battle;
use App\Item;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * @param $id
     * @return mixed
     */
    public function getIndex($id)
    {
        return User::where('id', '<>', $id)->get()->toArray();
    }
    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return View
     */
    public function show($id)
    {
        $user =  User::with('items')->findOrFail($id);
        $char = [
           'name' =>  $user->name,
           'type' => $user->type,
           'user_id'  => $user->id,
           'damage'  => $user->damage,
           'gold' => $user->gold,
            'life'  => $user->life,
            'speed'  => $user->speed,
            'agility'  => $user->agility,
            'energy'  => $user->energy,
            'experience'  => $user->experience,
            'armour'  => $user->armour,
            'image'  => $user->image
        ];
        $inventory = [];
        foreach ($user->items as $item) {
            $inventoryItem = [];
            $inventoryItem['id'] = $item->id;
            $inventoryItem['name'] = $item->name;
            $inventoryItem['description'] = $item->description;
            $inventoryItem['damage'] = $item->damage;
            $inventoryItem['speed'] = $item->speed;
            $inventoryItem['agility'] = $item->agility;
            $inventoryItem['image'] = $item->image;

            $char['damage'] += $item->damage;
            $char['speed'] += $item->speed;
            $char['agility'] += $item->agility;
            $char['life'] += $item->life;
            $inventory[] = $inventoryItem;
        }
        $char['inventory'] = array_reverse($inventory);

        $shop = Item::all()->toArray();
        $result = [
            'char' => $char,
            'shop' => $shop
        ];

        return$result;
/*
        char: {
        name: 'Gogu',
                type: 'orc',
                user_id: 4,
                damage: 340,
                gold: 45554,
                life: 444,
                speed: 333,
                agility: 553,
                energy: 3232,
                experience: 5,
                image: 'sdasda.jpg',
                inventory: [
                    {
                        id: 5,
                        name: 'ss',
                        desc: 'sdd',
                        damage: 340,
                        speed: 333,
                        agility: 553,
                        image: 'sdasda.jpg'
                    }
                ]
            },
        shop: [
                {
                    id: 2,
                    name: 'ss',
                    desc: 'sdd',
                    damage: 340,
                    speed: 333,
                    agility: 553,
                    image: 'sdasda.jpg'
                }
            ]
        }
*/
    }

    /**
     * @param $id
     * @param Request $request
     * @return View
     */
    public function postBuy($id, Request $request)
    {
        $user = User::find($id);
        $items = $user->items->pluck('id')->toArray();
        if ( ! in_array($request->item_id, $items )) {
            $item = Item::find($request->item_id);
            $user->items()->attach($item->id);
            $user->gold = $user->gold - $item->gold;
            $user->save();
        }
        return $this->show($id);
    }

    public function postBattle($id, Request $request)
    {
        $user1 = User::find($id);
        $user2 = User::find($request->user_id);
        $score1 = $user1->life * 0.2 + $user1->armour * 0.8 + $user1->damage * 0.5 + $user1->speed * 0.2 + $user1->agility * 0.2 + $user1->energy * 0.1;
        $score2 = $user2->life * 0.2 + $user2->armour * 0.8 + $user2->damage * 0.5 + $user2->speed * 0.2 + $user2->agility * 0.2 + $user2->energy * 0.1;

        // 5,6 castiga prostu
        // u1 > u2
        $luckyVictory = false;
        $mainPlayerId = $user1->id;
        $rand = rand(1, 5);
        if ($score1 > $score2) {
            $win = 1;
            $winner = $user1;
        } else {
            $win = 2;
            $winner = $user2;
        }
        if ($rand > 5 && $win == 1) {
            $luckyVictory = true;
            $winner = $user2;
        }

        if ($winner->id == $mainPlayerId) {
            //get win text
            $type = 1;
        } else {
            $type = 2;
            //get defeat
        }

        if ($luckyVictory) {
            $scenario = Battle::where('message', 'like',  'The fight just' . '%')->first();
        } else {
            $scenarios = Battle::where('type', $type)->get();
            $count = count($scenarios);

            $scenarioIndex = rand(1, ($count-1));
            $scenario = $scenarios[$scenarioIndex];
        }

        //winner
        $winner->experience =  $winner->experience +$scenario->experience;
        $winner->gold =  $winner->gold + $scenario->gold;
        $winner->life =  $winner->life + $scenario->life;
        $winner->damage =  $winner->damage + $scenario->damage - rand(1,3);
        $winner->speed =  $winner->speed + $scenario->speed;
        $winner->agility =  $winner->agility + $scenario->agility;
        $winner->armour =  $winner->armour + $scenario->armour;
        $winner->energy =  $winner->energy + $scenario->energy;
        $winner->save();

        if ($winner->id == $user1->id) {
            $loser = $user2;
        } else {
            $loser = $user1;
        }
        //loser
        $loser->experience =  $winner->experience + $scenario->experience;
        $loser->gold =  $winner->gold - $scenario->gold;
        $loser->life =  $winner->life - $scenario->life;
        $loser->damage =  $winner->damage + $scenario->damage;
        $loser->speed =  $winner->speed - $scenario->speed;
        $loser->agility =  $winner->agility - $scenario->agility;
        $loser->armour =  $winner->armour - $scenario->armour;
        $loser->energy =  $winner->energy - $scenario->energy;
        $loser->save();

        $user = $this->show($winner->id);
        $user['message'] = $scenario->message;
        $user['status'] = ($type == 1) ? 'victory' : 'defeat';

        return $user;
    }

    /**
     * @param $id
     * @param $itemId
     * @return View
     */
    public function delete($id, $itemId)
    {
        $user = User::find($id);
        $user->items()->detach($itemId);

        $item = Item::find($itemId);

        $user->gold = $user->gold + ($item->gold - (0.8 *  $item->gold));
        $user->save();

        $user->gold = $user->gold - $item->gold;
        $user->save();


        return $this->show($id);
    }
}

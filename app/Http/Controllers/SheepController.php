<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sheepfold;
use App\Sheep;
use App\History;
use Session;
use DB;

class SheepController extends Controller
{
    public function create()
    {
        if (empty(Sheepfold::first())) {
            Session::put('day', 0);
            $sheepfolds = $this->createSheepfolds();
            $this->addTenSheeps($sheepfolds);
        }

        $folds = Sheepfold::with('sheeps')->get();

        return ['folds' => $folds];
    }

    public function createSheepfolds()
    {
        for ($i=1; $i <= 4; $i++) {
            Sheepfold::create([
                'name' => 'Sheepfold ' . $i
            ]);
        }
        return Sheepfold::all();
    }

    public function new($day)
    {
        Session::put('day', $day);
        $sheepfolds = Sheepfold::all();
        $numeration = Sheep::orderBy('id', 'desc')->first()->id;
        foreach ($sheepfolds as $sheepfold) {
            if ($sheepfold->sheeps->count() > 1) {
                $numeration++;
                $sheep = $sheepfold->sheeps()->create([
                    'name' => 'Sheep ' . $numeration
                ]);
                $this->addHistory($sheepfold, $sheep, $day, 'new');
            }
        }
        $sheep = $this->replace($sheepfolds, $day);

        return ['sheep' => $sheep];
    }

    public function replace($sheepfolds, $day)
    {
        $array = $sheepfolds->map(function($sheepfold){
            return [
                'sheepfold' => $sheepfold,
                'sheep_count' => $sheepfold->sheeps->count()
            ];
        });
        $whereOneSheep = $array->where('sheep_count', 1);
        $max = $array->where('sheep_count', $array->max('sheep_count'))->first();

        if (!empty($whereOneSheep)) {
            $maxSheepfold = $max['sheepfold'];
            $max = $maxSheepfold->sheeps;
            foreach ($whereOneSheep as $key => $sheep) {
                $max[$key]->update([
                    'sheepfold_id' => $sheep['sheepfold']->id
                ]);
                $this->addHistory($maxSheepfold, $max[$key], $day, 'replaced');
            }

        }
        return $whereOneSheep;
    }

    public function delete($day)
    {
        $lastId = Sheep::where('is_dead', 0)->orderBy('id', 'desc')->first()->id;
        $sheep = Sheep::find(rand(1, $lastId));
        $sheep->update([
            'is_dead' => 1
        ]);
        $this->addHistory($sheep->sheepfold, $sheep, $day, 'deleted');
        return ['status' => 'success'];
    }

    public function addHistory($sheepfold, $sheep, $day, $action)
    {
        History::create([
            'sheep_id' => $sheep->id,
            'sheepfold_id' => $sheepfold->id,
            'day' => $day,
            'action' => $action
        ]);
    }

    public function history()
    {
        $this->validate(request(), [
            'day' => 'required'
        ]);
        $day = request('day');
        $histories = History::where('day', '<=', $day);
        $allSheeps = $histories->where('action', '<>', 'replaced')->count('sheep_id');
        $deleted = $histories->where('action', 'deleted')->count('sheep_id');
        $alive = $allSheeps - $deleted;

        $sheepfolds = collect();
        for ($i=1; $i <= 4; $i++) {
            $sheepfolds->push([
                'name' => Sheepfold::find($i)->name,
                'count' => $histories->where('sheepfold_id', $i)
            ]);
        }

        return view('history', compact('day', 'allSheeps', 'deleted', 'alive'));
    }

    public function refresh()
    {
        DB::table('sheep')->delete();
        DB::table('histories')->delete();
        Session::put('day', 0);
        $sheepfolds = Sheepfold::all();
        $this->addTenSheeps($sheepfolds);
        return ['status' => 'success'];
    }

    public function addTenSheeps($sheepfolds)
    {
        $arr = [];
        $r1 = rand(1, 7);
        $r2 = rand(1, 10-$r1-2);
        $r3 = rand(1, 10-($r1+$r2)-1);
        $r4 = 10 - ($r1+$r2+$r3);

        array_push($arr, $r1);
        array_push($arr, $r2);
        array_push($arr, $r3);
        array_push($arr, $r4);

        $numeration = 1;

        foreach ($sheepfolds as $key => $sheepfold) {
            for ($i=0; $i < $arr[$key]; $i++) {
                $sheep = $sheepfold->sheeps()->create([
                    'name' => 'Sheep ' . $numeration
                ]);
                $numeration++;
                $this->addHistory($sheepfold, $sheep, 0, 'new');
            }
        }
    }

    public function kill($id, $day)
    {
        $sheep = Sheep::find($id);
        $sheepfold = $sheep->sheepfold;
        if ($sheepfold->sheeps->count() > 1) {
            $sheep->update([
                'is_dead' => 1
            ]);
            $this->addHistory($sheep->sheepfold, $sheep, $day, 'deleted');
        }
    }
}

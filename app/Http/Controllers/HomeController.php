<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\BenchmarkName;
use App\Models\BenchmarkStructure;
use Illuminate\Http\Request;
use Illuminate\Support\Benchmark;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function indexAction(Request $request):View
    {
        $benchmarkName = null;
        $validatedData = $request->validate([
            'benchmarkName' => 'sometimes|required|numeric',
            'fromDate' => 'sometimes|required|date',
            'toDate' => 'sometimes|required|date',
        ]);

        $benchmarkName = $validatedData['benchmarkName'] ?? $this->getRandomBenchmarkName();
        $benchmarkNameData = implode(", ", \App\Models\BenchmarkName::where('id', '=', $benchmarkName)
            ->select('name', 'from_date', 'until_date', 'active', 'strategy', 'type')
            ->first()
            ->toArray());
        $instruments = BenchmarkStructure::where('benchmark_name', '=', $benchmarkName)
            ->select('type', 'exposure')
            ->get()
            ->toArray();
        $benchmarksBuilder = \App\Models\Benchmark::where('benchmark_name', '=', $benchmarkName);

        if(isset($validatedData['fromDate']) && isset($validatedData['toDate'])){
            $benchmarksBuilder = $benchmarksBuilder->where([
                ['date', '>=', $validatedData['fromDate']],
                ['date', '<=', $validatedData['toDate']],
            ]);
        }

        $benchmarks = $benchmarksBuilder->select('date', 'benchmark_index', 'daily_growth')->paginate(10);


        return view("home", ['name' => $benchmarkNameData,
            'queryName' => $benchmarkName,
            'instruments' => $instruments,
            'benchmarks' => $benchmarks]);
    }
    protected function getRandomBenchmarkName():int{
        $names = BenchmarkName::select('id')->get()->toArray();
        return $names[random_int(0, count($names)-1)]['id'];
    }
}

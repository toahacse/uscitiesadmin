<?php

namespace Toaha\UsCitiesAdmin\Http\Controllers\Api;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Toaha\UsCitiesAdmin\Models\UsCities;
use Toaha\UsCitiesAdmin\Http\Traits\UtilityFunction;

class UsCitiesFileUploadApiController extends Controller
{
    use UtilityFunction;
        
	public function file_upload(Request $request)
	{
        try{
            $req = $request->all();
            DB::beginTransaction();
                foreach($req['data'] as $item){
                    UsCities::create([
                        "uuid"        => (String) Str::uuid(),
                        "city"        => $item['city'] ?? null,
                        "city_ascii"  => $item['city_ascii'] ?? null,
                        "state_id"    => $item['state_id'] ?? null,
                        "state_name"  => $item['state_name'] ?? null,
                        "county_fips" => $item['county_fips'] ?? null,
                        "county_name" => $item['county_name'] ?? null,
                        "lat"         => $item['lat'] ?? null,
                        "lng"         => $item['lng'] ?? null,
                        "population"  => $item['population'] ?? null,
                        "density"     => $item['density'] ?? null,
                        "source"      => $item['source'] ?? null,
                        "military"    => $item['military'] ?? null,
                        "incorporated"=> $item['incorporated'] ?? null,
                        "timezone"    => $item['timezone'] ?? null,
                        "ranking"     => $item['ranking'] ?? null,
                        "zips"        => $item['zips'] ?? null,
                    ]);
                }
            DB::commit();
            return response()->json([
                'success'   => true,
                'msg'      => 'Successfully upload done',
            ]);

        }catch (\Exception $th){
            DB::rollback();
            return response()->json([
                'success'   => false,
                'msg'       => $th->getMessage(),
                'line'       => $th->getLine()
            ],400);
        }
    }

    function get_cities_data() {
        $paginatePerPage = !is_null(\request('rows_per_page')) ? \request('rows_per_page') : 20;
        $filterableColumns = \request('filterable_columns');

        $query = DB::table('cities')
                    ->orderBy('id', 'DESC')
                    ->selectRaw('cities.*');

            if (!is_null($filterableColumns)) {
                $columns = explode(';', $filterableColumns);
                foreach ($columns as $column) {
                    if ($column != '') {
                        $columnName = explode('|', $column);
                        if (isset($columnName[0]) && $columnName[1] != '') {
                            $query = $query->where($columnName[0], 'LIKE', "%{$columnName[1]}%");
                        }
                    }
                }
            }

        $data = $query->paginate($paginatePerPage);

        return response()->json([
            'status' => 'ok',
            'data'   => $data,
            'pages'  => $this->getPages($data->currentPage(), $data->lastPage(), $data->total()),
            'sl'     => !is_null(\request()->page) ? (\request()->page - 1) * $paginatePerPage : 0
        ]);
    }

    function get_city_data(Request $request) {
        return response()->json(UsCities::firstWhere('uuid', $request->input('uuid')));
    }

    function citiesApiData(Request $request) {
        $city = $request->input('city');
        $state = $request->input('state');
        $county = $request->input('county');

        if(is_null($city) && is_null($state) && is_null($county)){
            return response()->json('Please select city or state or county');
        }
        $filteredData = UsCities::when($city, function ($query) use ($city) {
            $query->where('city', 'LIKE', "%{$city}%");
        })
        ->when($state, function ($query) use ($state) {
            $query->where('state_name', 'LIKE', "%{$state}%");
        })
        ->when($county, function ($query) use ($county) {
            $query->where('county_name', 'LIKE', "%{$county}%");
        })
        ->get();
        return response()->json($filteredData);
    }

    private function getPages($currentPage, $lastPage, $totalPages)
    {
        $startPage = ($currentPage < 5) ? 1 : $currentPage - 4;
        $endPage = 8 + $startPage;
        $endPage = ($totalPages < $endPage) ? $totalPages : $endPage;
        $diff = $startPage - $endPage + 8;
        $startPage -= ($startPage - $diff > 0) ? $diff : 0;
        $pages = [];

        if ($startPage > 1) {
            $pages[] = '...';
        }

        for ($i = $startPage; $i <= $endPage && $i <= $lastPage; $i++) {
            $pages[] = $i;
        }

        if ($currentPage < $lastPage) {
            $pages[] = '...';
        }

        return $pages;
    }

}



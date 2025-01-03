<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\DivisionCollection;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $perPage = $request->input('per_page') ?? 5;
        $filter = $request->input('name');

        if ($filter) {
            $divisions = Division::where('name','like',"%$filter%")
                ->paginate($perPage);
        } else {
            $divisions = Division::paginate($perPage);
        }

        return ApiResponse::success(
            new DivisionCollection($divisions),
            'Divisions retrieve successful'
        );
    }
}

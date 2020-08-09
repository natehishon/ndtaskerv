<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function __invoke(Request $request)
    {
        $user = $request->user();
        $jotCount = $user->jotAuditCount();
        $adminCount = $user->jotAuditCount();

        return response()->json([
            'adminCount' => $adminCount,
            'email' => $user->email,
            'name' => $user->name,
            'isAdmin' => $user->isAdmin,
            'jots' => $jotCount
        ]);
    }
}

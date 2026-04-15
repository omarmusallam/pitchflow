<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $workspace = auth()->user()->workspace;

        abort_unless($workspace, 404);

        $query = trim((string) $request->get('q', ''));

        $proposalResults = collect();
        $clientResults = collect();

        if ($query !== '') {
            $proposalResults = $workspace->proposals()
                ->with('client')
                ->where(function ($builder) use ($query) {
                    $builder->where('title', 'like', '%' . $query . '%')
                        ->orWhere('notes', 'like', '%' . $query . '%')
                        ->orWhereHas('client', function ($clientQuery) use ($query) {
                            $clientQuery->where('name', 'like', '%' . $query . '%')
                                ->orWhere('company', 'like', '%' . $query . '%')
                                ->orWhere('email', 'like', '%' . $query . '%');
                        });
                })
                ->latest()
                ->limit(8)
                ->get();

            $clientResults = $workspace->clients()
                ->where(function ($builder) use ($query) {
                    $builder->where('name', 'like', '%' . $query . '%')
                        ->orWhere('email', 'like', '%' . $query . '%')
                        ->orWhere('company', 'like', '%' . $query . '%')
                        ->orWhere('phone', 'like', '%' . $query . '%')
                        ->orWhere('notes', 'like', '%' . $query . '%');
                })
                ->latest()
                ->limit(8)
                ->get();
        }

        return view('search.index', compact(
            'query',
            'proposalResults',
            'clientResults'
        ));
    }
}

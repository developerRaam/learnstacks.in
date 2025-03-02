<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request){
        // check permission
        if (!auth()->user()->can('view_subscriber')) {
            return back()->withError('You don\'t have permission to access this.');
        }
        $data['heading_title'] = "Subscribers";
        $data['list_title'] = "Subscriber List";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Subscribers',
            'href' => null
        ];

        $query = Subscriber::query();

        // filter by date
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('subscribers.created_at', [
                $request->start_date . ' 00:00:00',  
                $request->end_date . ' 23:59:59'     
            ]);
        } elseif ($request->filled('start_date')) {
            $query->whereDate('subscribers.created_at', '>=', $request->start_date);
        } elseif ($request->filled('end_date')) {
            $query->whereDate('subscribers.created_at', '<=', $request->end_date);
        }

        if ($request->filled('plan')) {
            $query->where('subscribers.plan_id', $request->plan);
        }

        $data['subscribers'] = $query->latest('subscribers.created_at')->paginate();

        return view('admin.subscriber', $data);

    }
}

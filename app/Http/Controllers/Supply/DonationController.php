<?php

namespace App\Http\Controllers\Supply;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDonationRequest;
use App\Http\Requests\StoreDonationRequest;
use App\Http\Requests\UpdateDonationRequest;
use App\Models\Donation;
use App\Models\DavnorsysEmployee;
use App\Models\Position;
use App\Models\Station;
use App\Models\Supplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;


class DonationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('donation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
       
        return view('supply.donation.index');
    }

    public function getDonations(Request $request)
    {            
                
        $data = Donation::with(['supplier'])->get();

        return datatables($data)->make(true);   
    }

    public function create()
    {
        abort_if(Gate::denies('donation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = DavnorsysEmployee::orderBy('fullname', 'asc')->get();
        $designations = Position::orderBy('position', 'asc')->get();
        $stations = Station::orderBy('station_name', 'asc')->get();
        $suppliers = Supplier::all()->sortBy('name');

        return view('supply.donation.create', compact('employees', 'designations', 'stations', 'suppliers'));
    }

    public function store(StoreDonationRequest $request)
    {
        abort_if(Gate::denies('donation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = $request->all();
        $data['donation_no'] =  $this->generateDonationNo();
       
        $donation = Donation::create($data);

        return redirect()->route('supply.donation.index');
    }

    private function generateDonationNo()
    {
        $last_donation = Donation::where('donation_no', 'like', 'DN%')->orderByDesc('donation_no')->first();
        $current_date = Carbon::now();
        $year = $current_date->year;
        $month = str_pad($current_date->month, 2, "0", STR_PAD_LEFT);
        $code = 'DN';

        if (!$last_donation || !$last_donation->donation_no) {
            return "{$code}-{$year}-{$month}-0001";
        }

        $parts = explode('-', $last_asset->asset_no);

        if ($parts[1] == $year) {
            $parts[3] = str_pad(++$parts[3], 4, '0', STR_PAD_LEFT);
        } else {
            $parts[3] = str_pad(0, 4, '0', STR_PAD_LEFT);
        }

        return "{$code}-{$year}-{$month}-{$parts[3]}";
    }

    public function edit(Donation $donation)
    {
        abort_if(Gate::denies('donation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden'); 

        $donation->load(['supplier:id,name']);
        $employees = DavnorsysEmployee::orderBy('fullname', 'asc')->get();
        $designations = Position::orderBy('position', 'asc')->get();
        $stations = Station::orderBy('station_name', 'asc')->get();
        $suppliers = Supplier::all()->sortBy('name');

        return view('supply.donation.edit', compact('donation', 'employees', 'designations', 'stations', 'suppliers'));
    }

    public function update(UpdateDonationRequest $request, Donation $donation)
    {
        abort_if(Gate::denies('donation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $donation->update($request->all());

        return redirect()->route('supply.donation.index');
    }

    public function show(Donation $donation)
    {
        abort_if(Gate::denies('donation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $donation->load(['supplier:id,name']);

        return view('supply.donation.show', compact('donation'));
    }

    public function destroy(Donation $donation)
    {
        abort_if(Gate::denies('donation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $donation->delete();

        return back();
    }

    public function massDestroy(MassDestroyDonationRequest $request)
    {
        abort_if(Gate::denies('donation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        Donation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}

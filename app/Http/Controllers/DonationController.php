<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonationPostRequest;
use App\Http\Requests\DonationPutRequest;
use App\Models\Donation;
use App\Models\DonationAddress;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DonationController extends Controller
{
    public function index(Request $request, Response $response)
    {
        $organization = $request->get('organization');
        $status = $request->input('status');

        return Donation::where('organization_id', $organization->id)
            ->where(function ($query) use ($status) {
                switch ($status) {
                    case 'approved':
                    case 'rejected':
                        $query->where('status', $status);
                        break;
                    case 'all':
                        break;
                    default:
                        $query->whereNull('status');
                        break;
                }
            })
            ->orderBy('created_at')
            ->paginate();
    }

    public function show($organization, $id, Request $request, Response $response)
    {
        $organization = $request->get('organization');

        return Donation::where('id', $id)
            ->where('organization_id', $organization->id)
            ->firstOrFail()
            ->load('address');
    }

    public function store(DonationPostRequest $request, Response $response)
    {
        $organization = $request->get('organization');

        $proof_of_transfer = $request->file('proof_of_transfer')
            ->store(
                sprintf('proof_of_transfer/%d-%s', $organization->id, $organization->slug),
                ['disk' => 'public']
            );

        $donation = new Donation([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'donate' => $request->input('donate'),
            'amount' => $request->input('amount'),
            'proof_of_transfer' => $proof_of_transfer,
        ]);

        $organization->donations()->save($donation);

        if ($request->input('address_allow')) {
            $address = new DonationAddress([
                'address' => $request->input('address'),
                'subdistrict' => $request->input('subdistrict'),
                'district' => $request->input('district'),
                'province' => $request->input('province'),
                'zip_code' => $request->input('zip_code'),
                'address_allowed_at' => \Carbon\Carbon::now(),
            ]);

            $donation->address()->save($address);
        }

        return response(null, 201);
    }

    public function update($organization, $id, DonationPutRequest $request, Response $response)
    {
        $organization = $request->get('organization');

        $donation = Donation::where('id', $id)
            ->where('organization_id', $organization->id)
            ->firstOrFail();

        $donation->update([
            'firstname' => $request->input('firstname') ?? $donation->firstname,
            'lastname' => $request->input('lastname') ?? $donation->lastname,
            'donate' => $request->input('donate') ?? $donation->donate,
            'amount' => $request->input('amount') ?? $donation->amount,
            'status' => $request->input('status') ?? $donation->status,
        ]);

        if ($request->input('address_allow')) {
            $address = $donation->address()->firstOrNew();

            $address->fill([
                'address' => $request->input('address') ?? $address->address,
                'subdistrict' => $request->input('subdistrict') ?? $address->subdistrict,
                'district' => $request->input('district') ?? $address->district,
                'province' => $request->input('province') ?? $address->province,
                'zip_code' => $request->input('zip_code') ?? $address->zip_code,
                'address_allowed_at' => $address->address_allowed_at ?? \Carbon\Carbon::now(),
            ]);

            $address->save();
        } else if (!is_null($request->input('address_allow')) && !$request->input('address_allow')) {
            $donation->address?->delete();
        }

        return response($donation);
    }
}

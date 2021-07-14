<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonationPostRequest;
use App\Models\Donation;
use App\Models\DonationAddress;
use Illuminate\Http\Response;

class DonationController extends Controller
{
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

        return $donation;
    }
}

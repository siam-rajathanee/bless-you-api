<?php

namespace App\Listeners;

use App\Events\DonationApproved;
use App\Models\BlessingCard;
use App\Models\Donation;
use Image;
use Rundiz\Number\NumberThai;
use Storage;

class CreateBlessingCard
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DonationApproved  $event
     * @return void
     */
    public function handle(DonationApproved $event)
    {
        $donation = $event->getDonation();

        switch ($donation->organization->slug) {
            case 'wat-sao-thong-hin':
                $this->createForWatSaoThongHin($donation);
                break;
        }
    }

    protected function createForWatSaoThongHin(Donation $donation)
    {
        $font_callback = function ($font) {
            $font->file(Storage::path('blessing-card/wat-sao-thong-hin/Sarabun-Regular.ttf'));
            $font->size(64);
            $font->color('#000000');
            $font->align('center');
            $font->valign('top');
        };

        $destination = sprintf('blessing-card/wat-sao-thong-hin/%s.jpg', uniqid());
        $card = Image::make(Storage::path('blessing-card/wat-sao-thong-hin/background.jpg'));

        $card->text($donation->fullname, 1240, 1175, $font_callback);
        $card->text($donation->donate, 1485, 1330, $font_callback);
        $card->text(sprintf('%.2f', $donation->amount), 1240, 1890, $font_callback);
        $card->text((new NumberThai)->convertBaht($donation->amount), 1240, 2000, $font_callback);
        $card->text($donation->created_at->format('d'), 656, 2524, $font_callback);
        $card->text($donation->created_at->thaidate('F'), 1294, 2524, $font_callback);
        $card->text($donation->created_at->thaidate('Y'), 1843, 2524, $font_callback);

        $card->save(Storage::disk('public')->path($destination));

        $blessing_card = new BlessingCard(['card' => $destination]);
        $donation->blessingCard()->save($blessing_card);
    }
}
